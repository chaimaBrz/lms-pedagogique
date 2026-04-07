<?php

namespace Database\Seeders;

use App\Models\Chapitre;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use App\Models\SousChapitre;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Récupère le sous-chapitre "10 verbes indispensables" créé à l'étape 5
        $sousChapitre = SousChapitre::where('titre', '10 verbes indispensables')->first();

        if (!$sousChapitre) {
            // Fallback : premier sous-chapitre dispo
            $sousChapitre = SousChapitre::first();
        }

        if (!$sousChapitre) {
            $this->command->warn('Aucun sous-chapitre trouvé. Lancez d\'abord ContenusSeeder.');
            return;
        }

        $quiz = Quiz::firstOrCreate(
            ['titre' => 'Quiz : Les verbes irréguliers', 'sous_chapitre_id' => $sousChapitre->id]
        );

        $questionsData = [
            [
                'question' => 'Quel est le prétérit de GO ?',
                'reponses' => ['goed', 'went', 'gone', 'go'],
                'bonne'    => 1, // went
            ],
            [
                'question' => 'Quel est le participe passé de EAT ?',
                'reponses' => ['ated', 'eated', 'eaten', 'eat'],
                'bonne'    => 2, // eaten
            ],
            [
                'question' => 'Quel est le prétérit de HAVE ?',
                'reponses' => ['haved', 'had', 'have', 'has'],
                'bonne'    => 1, // had
            ],
            [
                'question' => 'Quel est le participe passé de KNOW ?',
                'reponses' => ['knowed', 'knew', 'known', 'knows'],
                'bonne'    => 2, // known
            ],
            [
                'question' => 'Quel est le prétérit de COME ?',
                'reponses' => ['comed', 'came', 'coming', 'come'],
                'bonne'    => 1, // came
            ],
        ];

        foreach ($questionsData as $qData) {
            $existing = Question::where('question', $qData['question'])
                ->where('quiz_id', $quiz->id)
                ->first();

            if ($existing) {
                continue;
            }

            $question = $quiz->questions()->create(['question' => $qData['question']]);

            foreach ($qData['reponses'] as $index => $texteReponse) {
                $question->reponses()->create([
                    'reponse'      => $texteReponse,
                    'est_correcte' => ($index === $qData['bonne']),
                ]);
            }
        }

        $this->command->info("✅ QuizSeeder exécuté avec succès !");
        $this->command->info("   Sous-chapitre : {$sousChapitre->titre}");
        $this->command->info("   Quiz : {$quiz->titre}");
        $this->command->info("   Questions créées : " . count($questionsData));
    }
}
