<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;
    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function generateContent(string $categoryName)
    {

        $prompt = $this->buildPrompt($categoryName);

        $response = $this->client->chat()->create([
            'model' => 'gpt-4.1-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' =>
                    'You create engaging mobile micro-learning content.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => 0.9,
        ]);

        $content =
            $response->choices[0]->message->content;

        return json_decode($content, true);
    }

    protected function buildPrompt(
        string $categoryName
    ): string {

        return "
            Act as a viral mobile storytelling creator.

            Create engaging mobile feed content optimized for vertical scrolling.

            Requirements:
            - emotionally engaging
            - include storytelling
            - multiple readable paragraphs
            - include image prompts between sections
            - highly visual
            - mobile friendly
            - no markdown
            - mix short and medium paragraphs

            Return ONLY valid JSON.

            Format:
            {
            \"title\": \"\",
            \"thumbnail_prompt\": \"\",
            \"blocks\": [
                {
                \"type\": \"text\",
                \"value\": \"\"
                },
                {
                \"type\": \"image\",
                \"prompt\": \"\"
                }
            ]
            }

            Category: {$categoryName}
        ";
    }
}
