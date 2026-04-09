<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('services.gemini.api_key', '');
        $this->model   = config('services.gemini.model', 'gemini-2.5-flash-lite');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';
    }

    /**
     * Génère une formation complète à partir d'un prompt utilisateur.
     *
     * @return array ['success' => bool, 'data' => array|null, 'raw' => string, 'error' => string|null]
     */
    public function generateFormation(string $userPrompt): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'data'    => null,
                'raw'     => '',
                'error'   => 'Clé API Gemini non configurée. Ajoutez GEMINI_API_KEY dans votre fichier .env.',
            ];
        }

        $systemPrompt = <<<'PROMPT'
Tu es un expert en pédagogie. Crée une formation en JSON valide uniquement (pas de markdown ni backticks).
Structure exacte :
{
  "formation": "Nom",
  "niveau": "Débutant/Intermédiaire/Avancé",
  "duree": "durée estimée",
  "chapitres": [
    {
      "titre": "Chapitre",
      "sous_chapitres": [
        {
          "titre": "Sous-chapitre",
          "contenu": "Cours détaillé en 2-3 paragraphes.",
          "quiz": [
            {
              "question": "Question ?",
              "reponses": ["A", "B", "C", "D"],
              "bonne_reponse": 0
            }
          ]
        }
      ]
    }
  ]
}
Règles : 2 chapitres minimum, 2 sous-chapitres par chapitre, 2 questions de quiz par sous-chapitre, 4 réponses par question, bonne_reponse = index 0-3. Retourne UNIQUEMENT le JSON.
PROMPT;

        try {
            $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

            // UNE SEULE requête, pas de retry (pour ne pas gaspiller le quota)
            $response = Http::timeout(120)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'contents' => [
                        [
                            'role'  => 'user',
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nCrée : " . $userPrompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature'      => 0.7,
                        'maxOutputTokens'  => 4096,
                        'responseMimeType' => 'application/json',
                    ],
                ]);

            if ($response->failed()) {
                $status    = $response->status();
                $errorBody = $response->json();
                Log::error('Gemini API error', ['status' => $status, 'body' => $errorBody]);

                if ($status === 429) {
                    return [
                        'success' => false,
                        'data'    => null,
                        'raw'     => '',
                        'error'   => 'Quota API dépassé. Le quota gratuit se réinitialise toutes les 24h. Réessayez demain ou créez une nouvelle clé API sur un nouveau projet Google : aistudio.google.com/apikey',
                    ];
                }

                if ($status === 404) {
                    return [
                        'success' => false,
                        'data'    => null,
                        'raw'     => '',
                        'error'   => "Modèle IA introuvable ({$this->model}). Vérifiez la variable GEMINI_MODEL.",
                    ];
                }

                if ($status === 403) {
                    return [
                        'success' => false,
                        'data'    => null,
                        'raw'     => '',
                        'error'   => 'Clé API invalide ou désactivée. Vérifiez votre GEMINI_API_KEY.',
                    ];
                }

                $apiMessage = $errorBody['error']['message'] ?? '';
                return [
                    'success' => false,
                    'data'    => null,
                    'raw'     => '',
                    'error'   => "Erreur IA (Code {$status}). " . ($apiMessage ?: 'Réessayez dans un instant.'),
                ];
            }

            // Extraire le texte de la réponse Gemini
            $body = $response->json();
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

            if (empty($text)) {
                return [
                    'success' => false,
                    'data'    => null,
                    'raw'     => '',
                    'error'   => 'L\'IA n\'a retourné aucune réponse. Reformulez votre demande.',
                ];
            }

            // Nettoyer le texte
            $cleanedText = preg_replace('/^```json\s*\n?/i', '', $text);
            $cleanedText = preg_replace('/\n?```\s*$/i', '', $cleanedText);
            $cleanedText = trim($cleanedText);

            $parsed = json_decode($cleanedText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'data'    => null,
                    'raw'     => $cleanedText,
                    'error'   => 'Format JSON invalide : ' . json_last_error_msg(),
                ];
            }

            // Valeurs par défaut
            $parsed['formation'] = $parsed['formation'] ?? 'Formation';
            $parsed['niveau']    = $parsed['niveau'] ?? 'Débutant';
            $parsed['duree']     = $parsed['duree'] ?? '1h';
            $parsed['chapitres'] = $parsed['chapitres'] ?? [];

            return [
                'success' => true,
                'data'    => $parsed,
                'raw'     => $cleanedText,
                'error'   => null,
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gemini connection error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data'    => null,
                'raw'     => '',
                'error'   => 'Impossible de joindre l\'API Gemini. Vérifiez la connexion internet.',
            ];
        } catch (\Exception $e) {
            Log::error('Gemini error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data'    => null,
                'raw'     => '',
                'error'   => 'Erreur : ' . $e->getMessage(),
            ];
        }
    }
}
