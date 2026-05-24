<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Services\ContentGenerationService;
use Illuminate\Console\Command;

class GenerateContentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        ContentGenerationService $service
    ) {

        $categories = Category::get();
        foreach ($categories as $category) {
            for ($i = 0; $i < 1; $i++) {
                $content =
                    $service->generateFromCategory($category);

                $this->info(
                    "Generated content: {$content->title}"
                );
            }
        }
    }
}
