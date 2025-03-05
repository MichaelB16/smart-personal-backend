<?php

namespace App\Services;

use App\Enums\TYPE_FORMAT;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\ModelType;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Enums\ResponseMimeType;

class GeminiAiService
{

    public function sendMessage(string $prompt, string $format = TYPE_FORMAT::TEXT->value)
    {
        $gemini = Gemini::generativeModel(ModelType::GEMINI_FLASH)->withGenerationConfig(new GenerationConfig(
            responseMimeType: ResponseMimeType::APPLICATION_JSON
        ));

        $response = $gemini->generateContent($prompt);

        if ($format === TYPE_FORMAT::JSON->value) {
            return $response->json();
        }

        return $response->text();
    }
}
