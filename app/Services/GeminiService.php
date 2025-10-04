<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;
    protected $modelName;  // nombre de modelo como “models/gemini-2.0-flash”
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->modelName = env('GEMINI_MODEL', 'models/gemini-2.0-flash');
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta";
    }

    public function generateText(string $prompt)
    {
        $url = "{$this->baseUrl}/{$this->modelName}:generateContent?key={$this->apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'systemInstruction' => [
                'parts' => [
                    ['text' => 'Eres un cocinero creativo']
                ]
            ],
            // Podrías enviar configuración adicional como generationConfig, safetySettings, etc.
        ]);

        if ($response->failed()) {
            return ['error' => $response->json()];
        }

        return $response->json();
    }
}
