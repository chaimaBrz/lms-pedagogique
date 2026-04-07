<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(SousChapitre $sous_chapitre)
    {
        $quizzes = $sous_chapitre->quizzes;
        return view('admin.quizzes.index', compact('sous_chapitre', 'quizzes'));
    }

    public function create(SousChapitre $sous_chapitre)
    {
        return view('admin.quizzes.create', compact('sous_chapitre'));
    }

    public function store(Request $request, SousChapitre $sous_chapitre)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        $sous_chapitre->quizzes()->create(['titre' => $request->titre]);

        return redirect()
            ->route('sous_chapitres.quizzes.index', $sous_chapitre)
            ->with('success', 'Quiz créé avec succès.');
    }

    public function show(Quiz $quiz)
    {
        return redirect()->route('quizzes.questions.index', $quiz);
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        $quiz->update(['titre' => $request->titre]);

        return redirect()
            ->route('sous_chapitres.quizzes.index', $quiz->sous_chapitre_id)
            ->with('success', 'Quiz modifié avec succès.');
    }

    public function destroy(Quiz $quiz)
    {
        $sous_chapitre_id = $quiz->sous_chapitre_id;
        $quiz->delete();

        return redirect()
            ->route('sous_chapitres.quizzes.index', $sous_chapitre_id)
            ->with('success', 'Quiz supprimé avec succès.');
    }
}
