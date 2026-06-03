<?php

namespace App\Services;

use App\Models\Content;
use App\Models\ContentTranslation;
use Illuminate\Support\Facades\DB;

class TranslationService
{
    public function __construct(
        protected OpenAIService $openAIService
    ) {}

    public function getTranslatedContent(
        Content $content,
        string $language
    ) {
        if ($language === 'en') {
            return $content;
        }

        $existing =
            $content->translations()
            ->where(
                'locale',
                $language
            )
            ->first();

        if ($existing) {
            return $existing;
        }

        return $content;
    }

    public function translateAndSave(
        Content $content,
        string $language
    ): ContentTranslation {

        $translated =
            $this->openAIService
            ->translateContent(
                $content,
                $language
            );

        return ContentTranslation::create([
            'content_id' => $content->id,
            'locale' => $language,
            'title' => $translated['title'],
            'body' => $translated['body'],
        ]);
    }
}
