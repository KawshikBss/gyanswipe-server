<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageGenerationService
{
    public function generateAndStoreImage(
        string $prompt,
        string $folder = 'content'
    ): string {

        $cleanPrompt = trim(
            preg_replace(
                '/\s+/',
                ' ',
                $this->enhancePrompt($prompt)
            )
        );

        $url =
            "https://image.pollinations.ai/prompt/"
            . urlencode($cleanPrompt);

        $response = Http::retry(3, 2000)
            ->timeout(20)
            ->withoutVerifying()
            ->get($url);

        if (!$response->successful()) {

            throw new \Exception(
                'Image request failed.'
            );
        }

        $imageData =
            $response->body();

        $filename =
            $folder . '/'
            . Str::uuid()
            . '.png';

        Storage::disk('public')->put(
            $filename,
            $imageData
        );

        return asset(
            'storage/' . $filename
        );
    }

    protected function enhancePrompt(
        string $prompt
    ): string {

        return trim("
{$prompt},

cinematic digital illustration
");
    }
}
