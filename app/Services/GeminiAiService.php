<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;

class GeminiAiService
{
    public function sendMessage(string $prompt)
    {

        $response = Gemini::geminiPro()->generateContent($prompt);

        return $response->text();
    }
}
