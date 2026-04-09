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
        $this->model   = config('services.gemini.model', 'gemini-2.0-flash');
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
Tu es un expert en pédagogie et en création de contenu éducatif.
L'utilisateur va te demander de créer une formation. Tu dois répondre UNIQUEMENT avec un JSON valide, sans aucun texte avant ou après, sans backticks, sans markdown.

Le JSON doit suivre EXACTEMENT cette structure :
{
  "formation": "Nom de la formation",
  "niveau": "Ex: Débutant, Intermédiaire, Avancé",
  "duree": "Ex: 10h, 2 semaines, etc.",
  "chapitres": [
    {
      "titre": "Nom du chapitre",
      "sous_chapitres": [
        {
          "titre": "Titre du sous-chapitre",
          "contenu": "Texte pédagogique détaillé de 3 à 5 paragraphes. Écris un vrai cours complet et instructif.",
          "quiz": [
            {
              "question": "Question à choix multiple ?",
              "reponses": ["Réponse A", "Réponse B", "Réponse C", "Réponse D"],
              "bonne_reponse": 0
            }
          ]
        }
      ]
    }
  ]
}

Règles strictes :
- Génère au moins 2 chapitres (ou le nombre exact demandé par l'utilisateur)
- Chaque chapitre doit avoir au moins 2 sous-chapitres
- Chaque sous-chapitre doit avoir exactement 3 questions de quiz
- Chaque question doit avoir exactement 4 réponses
- "bonne_reponse" est l'index (0, 1, 2 ou 3) de la bonne réponse
- Le contenu pédagogique doit être détaillé, pédagogique et adapté au niveau
- Retourne UNIQUEMENT le JSON, rien d'autre
PROMPT;

        try {
            $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

            $requestBody = [
                'contents' => [
                    [
                        'role'  => 'user',
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nDemande de l'utilisateur : " . $userPrompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature'      => 0.7,
                    'maxOutputTokens'  => 8192,
                    'responseMimeType' => 'application/json',
                ],
            ];

            $response = Http::timeout(150)
                ->retry(2, 10000)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $requestBody);

            // Vérifier si la réponse est en erreur
            if ($response->failed()) {
                $status    = $response->status();
                $errorBody = $response->json();
                Log::error('Gemini API error', ['status' => $status, 'body' => $errorBody]);

                if ($status === 429) {
                    return [
                        'success' => false,
                        'data'    => null,
                        'raw'     => '',
                        'error'   => 'Quota API dépassé. L\'API gratuite Google Gemini limite le nombre de requêtes par minute. Veuillez patienter 1 à 2 minutes puis réessayer.',
                    ];
                }

                if ($status === 404) {
                    return [
                        'success' => false,
                        'data'    => null,
                        'raw'     => '',
                        'error'   => "Modèle IA introuvable ({$this->model}). Vérifiez la variable GEMINI_MODEL dans les paramètres.",
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
                    'error'   => "Erreur du service IA (Code {$status}). " . ($apiMessage ?: 'Réessayez dans un instant.'),
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
                    'error'   => 'L\'IA n\'a retourné aucune réponse. Essayez de reformuler votre demande.',
                ];
            }

            // Nettoyer le texte (enlever ```json ... ``` si présent)
            $cleanedText = $text;
            $cleanedText = preg_replace('/^```json\s*\n?/i', '', $cleanedText);
            $cleanedText = preg_replace('/\n?```\s*$/i', '', $cleanedText);
            $cleanedText = trim($cleanedText);

            // Parser le JSON
            $parsed = json_decode($cleanedText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'data'    => null,
                    'raw'     => $cleanedText,
                    'error'   => 'L\'IA a répondu mais le format JSON est invalide : ' . json_last_error_msg(),
                ];
            }

            // Valider la structure minimale
            foreach (['formation', 'niveau', 'duree', 'chapitres'] as $key) {
                if (empty($parsed[$key])) {
                    $parsed[$key] = $key === 'duree' ? '1h' : 'Débutant';
                }
            }

            return [
                'success' => true,
                'data'    => $parsed,
                'raw'     => $cleanedText,
                'error'   => null,
            ];

        } catch (\Illuminate\Http\Client\RequestException $e) {
            $status = $e->response->status();
            Log::error('Gemini RequestException', ['status' => $status, 'message' => $e->getMessage()]);

            if ($status === 429) {
                return [
                    'success' => false,
                    'data'    => null,
                    'raw'     => '',
                    'error'   => 'Quota API dépassé (429). Veuillez patienter 1 à 2 minutes puis réessayer.',
                ];
            }

            return [
                'success' => false,
                'data'    => null,
                'raw'     => '',
                'error'   => "Erreur API Gemini (Code {$status}). Réessayez dans un instant.",
            ];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gemini connection error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data'    => null,
                'raw'     => '',
                'error'   => 'Impossible de joindre l\'API Gemini. Vérifiez votre connexion internet.',
            ];
        } catch (\Exception $e) {
            Log::error('Gemini unexpected error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data'    => null,
                'raw'     => '',
                'error'   => 'Erreur inattendue : ' . $e->getMessage(),
            ];
        }
    }
}
