<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\Formation;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use App\Models\SousChapitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportIAController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'json_data' => 'required|string',
        ]);

        // ── 1. Décoder le JSON ────────────────────────────────────
        $data = json_decode($request->json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()
                ->withInput()
                ->with('error', 'JSON invalide : ' . json_last_error_msg() . '. Vérifiez la syntaxe de votre JSON.');
        }

        // ── 2. Valider la structure minimale ──────────────────────
        $missingKeys = [];
        foreach (['formation', 'chapitre', 'sous_chapitres'] as $key) {
            if (empty($data[$key])) {
                $missingKeys[] = $key;
            }
        }

        if (!empty($missingKeys)) {
            return back()
                ->withInput()
                ->with('error', 'Clés manquantes dans le JSON : ' . implode(', ', $missingKeys));
        }

        if (!is_array($data['sous_chapitres']) || count($data['sous_chapitres']) === 0) {
            return back()
                ->withInput()
                ->with('error', 'Le champ "sous_chapitres" doit être un tableau non vide.');
        }

        // ── 3. Import dans une transaction atomique ───────────────
        $summary = DB::transaction(function () use ($data) {
            $counts = [
                'formations'     => 0,
                'chapitres'      => 1,
                'sous_chapitres' => 0,
                'contenus'       => 0,
                'quizzes'        => 0,
                'questions'      => 0,
            ];

            // Formation : firstOrCreate par nom
            $formationCreated = false;
            $formation = Formation::where('nom', $data['formation'])->first();
            if (!$formation) {
                $formation = Formation::create([
                    'nom'         => $data['formation'],
                    'description' => 'Formation complète.',
                    'niveau'      => $data['niveau'] ?? 'Débutant',
                    'duree'       => $data['duree'] ?? 'Durée inconnue',
                ]);
                $counts['formations'] = 1;
                $formationCreated = true;
            }

            // Chapitre — toujours créé (on peut avoir plusieurs chapitres pour la même formation)
            $chapitre = Chapitre::create([
                'titre'        => $data['chapitre'],
                'description'  => 'Contenu du chapitre.',
                'formation_id' => $formation->id,
            ]);

            // Sous-chapitres
            foreach ($data['sous_chapitres'] as $scData) {
                if (empty($scData['titre'])) {
                    continue;
                }

                $sousChapitre = SousChapitre::create([
                    'titre'       => $scData['titre'],
                    'contenu'     => $scData['contenu'] ?? '',
                    'chapitre_id' => $chapitre->id,
                ]);
                $counts['sous_chapitres']++;

                // Contenu pédagogique (text du sous-chapitre → enregistré aussi dans contenus)
                if (!empty($scData['contenu'])) {
                    Contenu::create([
                        'titre'           => $scData['titre'],
                        'texte'           => $scData['contenu'],
                        'sous_chapitre_id' => $sousChapitre->id,
                    ]);
                    $counts['contenus']++;
                }

                // Quiz + questions
                if (!empty($scData['quiz']) && is_array($scData['quiz'])) {
                    $quiz = Quiz::create([
                        'titre'           => 'Quiz – ' . $scData['titre'],
                        'sous_chapitre_id' => $sousChapitre->id,
                    ]);
                    $counts['quizzes']++;

                    foreach ($scData['quiz'] as $qData) {
                        if (empty($qData['question']) || empty($qData['reponses']) || !is_array($qData['reponses'])) {
                            continue;
                        }
                        if (count($qData['reponses']) < 2) {
                            continue;
                        }

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

            $counts['formation_created'] = $formationCreated;
            $counts['formation_nom']     = $formation->nom;
            $counts['formation_id']      = $formation->id;
            $counts['chapitre_id']       = $chapitre->id;

            return $counts;
        });

        return back()->with('import_success', $summary);
    }
}
