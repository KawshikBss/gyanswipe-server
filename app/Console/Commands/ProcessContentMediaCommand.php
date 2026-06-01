<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Services\ContentMediaService;
use Illuminate\Console\Command;

class ProcessContentMediaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:process-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails and images';

    /**
     * Execute the console command.
     */
    public function handle(
        ContentMediaService $service
    ) {

        $content = Content::all()
            ->first(function ($content) {

                if (empty($content->thumbnail)) {
                    return true;
                }

                $blocks =
                    $content->body['blocks'] ?? [];

                foreach ($blocks as $block) {

                    if (
                        ($block['type'] ?? null) === 'image'
                        && isset($block['prompt'])
                    ) {
                        return true;
                    }
                }

                return false;
            });

        if (!$content) {

            $this->info(
                'No pending content found.'
            );

            return;
        }

        $service->process($content);

        $this->info(
            "Processed content {$content->id}"
        );
    }
}
