<?php

namespace App\Jobs;

use App\Models\Content;
use App\Services\ImageGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateContentImagesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Content $content
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        ImageGenerationService $imageService
    ): void {
        $body =
            $this->content->body;

        $blocks =
            $body['blocks'] ?? [];

        $updatedBlocks =
            collect($blocks)
            ->map(function ($block)
            use ($imageService) {

                if (
                    $block['type'] === 'image'
                    && isset($block['prompt'])
                ) {

                    try {

                        $url =
                            $imageService
                            ->generateAndStoreImage(
                                $block['prompt'],
                                'blocks'
                            );

                        return [
                            'type' => 'image',
                            'value' => $url,
                        ];
                    } catch (\Exception $e) {

                        logger()->error(
                            $e->getMessage()
                        );

                        return null;
                    }
                }

                return $block;
            })
            ->filter()
            ->values()
            ->toArray();

        $body['blocks'] =
            $updatedBlocks;

        $this->content->update([
            'body' => $body,
        ]);
    }
}
