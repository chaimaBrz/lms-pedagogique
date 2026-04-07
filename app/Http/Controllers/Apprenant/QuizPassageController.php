<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\ResultatQuiz;
use Illuminate\Http\Request;

class QuizPassageController extends Controller
{
    public function show(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('reponses')->get();
        $resultat  = auth()->user()->resultatQuizzes()->where('quiz_id', $quiz->id)->latest()->first();

        return view('apprenant.quiz.show', compact('quiz', 'questions', 'resultat'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $questions = $quiz->questions()->with('reponses')->get();
        $total     = $questions->count();

        $request->validate([
            'reponses'   => 'required|array',
            'reponses.*' => 'required|integer|exists:reponses,id',
        ]);

        $score = 0;

        foreach ($questions as $question) {
            $reponseDonneeId = $request->reponses[$question->id] ?? null;
            if ($reponseDonneeId) {
                $repCorrecte = $question->reponses->where('est_correcte', true)->first();
                if ($repCorrecte && $repCorrecte->id == $reponseDonneeId) {
                    $score++;
                }
            }
        }

        // Enregistrement du résultat
        ResultatQuiz::create([
            'score'   => $score,
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
        ]);

        $sousChapitreId = $quiz->sous_chapitre_id;

        return redirect()
            ->route('apprenant.cours.contenus', $sousChapitreId)
            ->with('quiz_score', $score)
            ->with('quiz_total', $total)
            ->with('quiz_nom', $quiz->titre);
    }
}
