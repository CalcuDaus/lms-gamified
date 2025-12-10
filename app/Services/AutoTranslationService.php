<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AutoTranslationService
{
    /**
     * Translate text from source to target language using Google Translate Free API.
     * 
     * @param string $text The text to translate
     * @param string $target Target language code (e.g., 'id')
     * @param string $source Source language code (e.g., 'en')
     * @return string|null Translated text or null on failure
     */
    public function translate(string $text, string $target = 'id', string $source = 'en'): ?string
    {
        if (empty($text)) {
            return $text;
        }

        try {
            // Google Translate 'gtx' client endpoint (free, rate-limited)
            $response = Http::get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => $source,
                'tl' => $target,
                'dt' => 't',
                'q' => $text,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Result structure is usually [[[ "Translated", "Original", ... ]]]
                // We concatenate parts if it splits sentences
                $result = '';
                if (isset($data[0]) && is_array($data[0])) {
                    foreach ($data[0] as $part) {
                        if (isset($part[0])) {
                            $result .= $part[0];
                        }
                    }
                }

                return $result ?: $text; // Fallback to original if empty result
            }
        } catch (\Exception $e) {
            // Log error or ignore
        }

        return $text; // Fallback to original on error
    }
}
