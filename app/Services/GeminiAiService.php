<?php

namespace App\Services;

use App\Enums\TYPE_FORMAT;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\ModelType;
use Gemini\Laravel\Facades\Gemini;


class GeminiAiService
{

    public function sendMessage(string $prompt, string $format = TYPE_FORMAT::TEXT->value)
    {
        $gemini = Gemini::generativeModel(ModelType::GEMINI_FLASH)->withGenerationConfig(new GenerationConfig());

        $response = $gemini->generateContent($prompt);

        if ($format === TYPE_FORMAT::JSON->value) {

            $json_string = trim(preg_replace('/^\`\`\`json\n|\n\`\`\`$/', '', $response->text()));

            $data = json_decode($json_string);

            return $data;
        }

        return $response->text();
    }
}
