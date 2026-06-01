<?php

namespace App\Services;

use App\Models\Content;

class ContentMediaService
{
    public function __construct(
        protected ImageGenerationService $imageService
    ) {}

    public function process(
        Content $content
    ): void {

        $body =
            $content->body;

        /*
        |--------------------------------------------------------------------------
        | THUMBNAIL
        |--------------------------------------------------------------------------
        */

        if (
            !$content->thumbnail &&
            !empty($body['thumbnail_prompt'])
        ) {

            try {

                $content->update([
                    'thumbnail' =>
                    $this->imageService
                        ->generateAndStoreImage(
                            $body['thumbnail_prompt'],
                            'thumbnails'
                        ),
                ]);

                return;
            } catch (\Exception $e) {

                logger()->error(
                    $e->getMessage()
                );

                return;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IMAGE BLOCKS
        |--------------------------------------------------------------------------
        */

        $blocks =
            $body['blocks'] ?? [];

        foreach ($blocks as $index => $block) {

            if (
                ($block['type'] ?? null)
                !== 'image'
            ) {
                continue;
            }

            if (
                isset($block['value'])
                && !empty($block['value'])
            ) {
                continue;
            }

            if (
                !isset($block['prompt'])
            ) {
                continue;
            }

            try {

                $url =
                    $this->imageService
                    ->generateAndStoreImage(
                        $block['prompt'],
                        'blocks'
                    );

                $blocks[$index]['value'] = $url;
                unset($blocks[$index]['prompt']);

                $body['blocks'] =
                    $blocks;

                $content->update([
                    'body' => $body,
                ]);

                return;
            } catch (\Exception $e) {

                logger()->error(
                    $e->getMessage()
                );

                return;
            }
        }
    }
}
