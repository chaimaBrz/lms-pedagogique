<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\Formation;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use App\Models\SousChapitre;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssistantIAController extends Controller
{
    public function index()
    {
        $hasApiKey = !empty(config('services.gemini.api_key'));
        return view('admin.assistant-ia.index', compact('hasApiKey'));
    }

    /**
     * Reçoit le prompt de l'admin, appelle Gemini, retourne le JSON via AJAX.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|min:10|max:1000',
        ]);

        $aiService = new AIService();
        $result = $aiService->generateFormation($request->prompt);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'error'   => $result['error'],
                'raw'     => $result['raw'] ?? '',
            ], 200); // 200 pour que le JS puisse lire le JSON d'erreur
        }

        return response()->json([
            'success' => true,
            'data'    => $result['data'],
            'raw'     => $result['raw'],
            'preview' => $this->buildPreview($result['data']),
        ]);
    }

    /**
     * Reçoit le JSON validé par l'admin, crée tout en base.
     */
    public function create(Request $request)
    {
        $request->validate([
            'json_data' => 'required|string',
        ]);

        $data = json_decode($request->json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'success' => false,
                'error'   => 'JSON invalide : ' . json_last_error_msg(),
            ]);
        }

        // Valider la structure
        foreach (['formation', 'chapitres'] as $key) {
            if (empty($data[$key])) {
                return response()->json([
                    'success' => false,
                    'error'   => "Clé manquante dans le JSON : {$key}",
                ]);
            }
        }

        // Import atomique
        $summary = DB::transaction(function () use ($data) {
            $counts = [
                'formations'     => 0,
                'chapitres'      => 0,
                'sous_chapitres' => 0,
                'contenus'       => 0,
                'quizzes'        => 0,
                'questions'      => 0,
            ];

            // Formation
            $formation = Formation::where('nom', $data['formation'])->first();
            if (!$formation) {
                $formation = Formation::create([
                    'nom'         => $data['formation'],
                    'description' => 'Formation complète.',
                    'niveau'      => $data['niveau'] ?? 'Débutant',
                    'duree'       => $data['duree'] ?? 'Durée inconnue',
                ]);
                $counts['formations'] = 1;
            }

            // Boucle sur les chapitres
            foreach ($data['chapitres'] as $chapData) {
                if (empty($chapData['titre'])) continue;

                $chapitre = Chapitre::create([
                    'titre'        => $chapData['titre'],
                    'description'  => 'Contenu du chapitre.',
                    'formation_id' => $formation->id,
                ]);
                $counts['chapitres']++;

                // Boucle sur les sous-chapitres
                $sousChapitresJson = $chapData['sous_chapitres'] ?? [];
                foreach ($sousChapitresJson as $scData) {
                    if (empty($scData['titre'])) continue;

                    $sousChapitre = SousChapitre::create([
                        'titre'       => $scData['titre'],
                        'contenu'     => $scData['contenu'] ?? '',
                        'chapitre_id' => $chapitre->id,
                    ]);
                    $counts['sous_chapitres']++;

                    if (!empty($scData['contenu'])) {
                        Contenu::create([
                            'titre'            => $scData['titre'],
                            'texte'            => $scData['contenu'],
                            'sous_chapitre_id' => $sousChapitre->id,
                        ]);
                        $counts['contenus']++;
                    }

                    if (!empty($scData['quiz']) && is_array($scData['quiz'])) {
                        $quiz = Quiz::create([
                            'titre'            => 'Quiz – ' . $scData['titre'],
                            'sous_chapitre_id' => $sousChapitre->id,
                        ]);
                        $counts['quizzes']++;

                        foreach ($scData['quiz'] as $qData) {
                            if (empty($qData['question']) || empty($qData['reponses']) || !is_array($qData['reponses'])) continue;
                            if (count($qData['reponses']) < 2) continue;

                            $question = Question::create([
                                'question' => $qData['question'],
                                'quiz_id'  => $quiz->id,
                            ]);
                            $counts['questions']++;

                            $bonneReponseIndex = (int) ($qData['bonne_reponse'] ?? 0);

                            foreach ($qData['reponses'] as $index => $texte) {
                                Reponse::create([
                                    'reponse'      => $texte,
                                    'est_correcte' => ($index === $bonneReponseIndex),
                                    'question_id'  => $question->id,
                                ]);
                            }
                        }
                    }
                }
            }

            $counts['formation_nom'] = $formation->nom;
            $counts['formation_id']  = $formation->id;

            return $counts;
        });

        return response()->json([
            'success' => true,
            'summary' => $summary,
        ]);
    }

    /**
     * Construit un résumé lisible du JSON pour l'affichage dans le chat.
     */
    private function buildPreview(array $data): array
    {
        $chapitresPreview = [];
        $totalQuestions = 0;

        foreach ($data['chapitres'] ?? [] as $chap) {
            $sousChapitres = [];
            foreach ($chap['sous_chapitres'] ?? [] as $sc) {
                $nbQ = count($sc['quiz'] ?? []);
                $totalQuestions += $nbQ;
                $sousChapitres[] = [
                    'titre'       => $sc['titre'] ?? 'Sans titre',
                    'nb_questions' => $nbQ,
                    'contenu_preview' => mb_substr($sc['contenu'] ?? '', 0, 150) . '…',
                ];
            }
            
            $chapitresPreview[] = [
                'titre' => $chap['titre'] ?? 'Chapitre sans titre',
                'sous_chapitres' => $sousChapitres
            ];
        }

        return [
            'formation'      => $data['formation'] ?? '',
            'chapitres'       => $chapitresPreview,
            'total_questions' => $totalQuestions,
        ];
    }
}
