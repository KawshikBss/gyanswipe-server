<?php

namespace App\Jobs;

use App\Models\Content;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateContentImagesJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 60;

    public $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Content $content
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $body =
            $this->content->body;

        $blocks =
            $body['blocks'] ?? [];

        foreach ($blocks as $index => $block) {

            if (
                $block['type'] === 'image'
                && isset($block['prompt'])
            ) {

                GenerateSingleContentImageJob::dispatch(
                    $this->content->id,
                    $index,
                    $block['prompt']
                )->delay(
                    now()->addSeconds(
                        $index * 10
                    )
                );
            }
        }
    }
}
