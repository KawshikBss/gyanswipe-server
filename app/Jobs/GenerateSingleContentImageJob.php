<?php

namespace App\Jobs;

use App\Models\Content;
use App\Services\ImageGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateSingleContentImageJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 120;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $contentId,
        public int $blockIndex,
        public string $prompt
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        ImageGenerationService $imageService
    ): void {

        $content =
            Content::find($this->contentId);

        if (!$content) {
            return;
        }

        $body =
            $content->body;

        $blocks =
            $body['blocks'] ?? [];

        if (
            !isset($blocks[$this->blockIndex])
        ) {
            return;
        }

        try {

            $url =
                $imageService
                ->generateAndStoreImage(
                    $this->prompt,
                    'blocks'
                );

            $blocks[$this->blockIndex] = [
                'type' => 'image',
                'value' => $url,
            ];

            $body['blocks'] = $blocks;

            $content->update([
                'body' => $body,
            ]);
        } catch (\Exception $e) {

            logger()->error(
                $e->getMessage()
            );
        }
    }
}
