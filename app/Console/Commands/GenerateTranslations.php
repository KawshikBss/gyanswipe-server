<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Services\TranslationService;
use Illuminate\Console\Command;

class GenerateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate Contents';

    /**
     * Execute the console command.
     */
    public function handle(
        TranslationService $service
    ) {
        $content = Content::all()
            ->first(function ($content) {

                if ($content->translations()->count() === 0) {
                    return true;
                }

                return false;
            });

        if (!$content) {
            $this->info(
                'No pending content found.'
            );

            return;
        }
        if ($content->translations()->where('locale', 'bn')->count() === 0) {
            $service->translateAndSave(
                $content,
                'bn'
            );
        }
    }
}
