<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('reponses')->get();
        return view('admin.questions.index', compact('quiz', 'questions'));
    }

    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question'              => 'required|string|max:255',
            'reponses'              => 'required|array|size:4',
            'reponses.*'            => 'required|string|max:255',
            'bonne_reponse'         => 'required|integer|min:0|max:3',
        ]);

        $question = $quiz->questions()->create(['question' => $request->question]);

        foreach ($request->reponses as $index => $texte) {
            $question->reponses()->create([
                'reponse'     => $texte,
                'est_correcte' => ($index == $request->bonne_reponse),
            ]);
        }

        return redirect()
            ->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question ajoutée avec succès.');
    }

    public function show(Question $question)
    {
        return redirect()->route('quizzes.questions.index', $question->quiz_id);
    }

    public function edit(Question $question)
    {
        $question->load('reponses');
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question'      => 'required|string|max:255',
            'reponses'      => 'required|array|size:4',
            'reponses.*'    => 'required|string|max:255',
            'bonne_reponse' => 'required|integer|min:0|max:3',
        ]);

        $question->update(['question' => $request->question]);

        // Mise à jour des réponses dans l'ordre existant
        $reponses = $question->reponses()->orderBy('id')->get();

        foreach ($request->reponses as $index => $texte) {
            if (isset($reponses[$index])) {
                $reponses[$index]->update([
                    'reponse'      => $texte,
                    'est_correcte' => ($index == $request->bonne_reponse),
                ]);
            } else {
                $question->reponses()->create([
                    'reponse'      => $texte,
                    'est_correcte' => ($index == $request->bonne_reponse),
                ]);
            }
        }

        return redirect()
            ->route('quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Question modifiée avec succès.');
    }

    public function destroy(Question $question)
    {
        $quiz_id = $question->quiz_id;
        $question->delete(); // supprime aussi les réponses en cascade

        return redirect()
            ->route('quizzes.questions.index', $quiz_id)
            ->with('success', 'Question supprimée avec succès.');
    }
}
