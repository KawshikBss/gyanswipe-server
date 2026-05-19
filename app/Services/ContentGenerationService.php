<?php

namespace App\Services;

use App\Jobs\GenerateContentImagesJob;
use App\Jobs\GenerateThumbnailJob;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Support\Str;
use Exception;

class ContentGenerationService
{
    public function __construct(
        protected OpenAIService $openAIService
    ) {}

    public function generateFromCategory(
        Category $category
    ): Content {

        // Generate AI content
        $generated =
            $this->openAIService
            ->generateContent(
                $category->name
            );

        // Validate response
        $this->validateGeneratedContent(
            $generated
        );

        // Extract text
        $summary =
            $this->extractTextFromBlocks(
                $generated['blocks']
            );

        // Calculate duration
        $duration =
            $this->calculateDuration(
                $summary
            );

        // Save content immediately
        $content = Content::create([

            'title' =>
            $generated['title'],

            'slug' =>
            $this->generateSlug(
                $generated['title']
            ),

            'body' => [
                'thumbnail_prompt' =>
                $generated['thumbnail_prompt']
                    ?? null,

                'blocks' =>
                $generated['blocks'],
            ],

            'thumbnail' => null,

            'category_id' =>
            $category->id,

            'type' => 'mixed',

            'duration_seconds' =>
            $duration,

            'is_published' => true,
        ]);

        // Dispatch async jobs
        GenerateThumbnailJob::dispatch(
            $content
        );

        GenerateContentImagesJob::dispatch(
            $content
        );

        return $content;
    }

    protected function validateGeneratedContent(
        array $generated
    ): void {

        if (
            empty($generated['title'])
        ) {
            throw new Exception(
                'Missing title.'
            );
        }

        if (
            !isset($generated['blocks']) ||
            !is_array($generated['blocks'])
        ) {
            throw new Exception(
                'Invalid blocks.'
            );
        }
    }

    protected function extractTextFromBlocks(
        array $blocks
    ): string {

        return collect($blocks)
            ->where('type', 'text')
            ->pluck('value')
            ->implode(' ');
    }

    protected function calculateDuration(
        string $text
    ): int {

        $words =
            str_word_count($text);

        return max(
            5,
            ceil(($words / 200) * 60)
        );
    }

    protected function generateSlug(
        string $title
    ): string {

        return Str::slug($title)
            . '-'
            . uniqid();
    }
}
