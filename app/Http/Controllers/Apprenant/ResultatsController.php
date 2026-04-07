<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;

class ResultatsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Notes de l'apprenant (via la relation user → apprenant → notes)
        $notes = $user->apprenant
            ? $user->apprenant->notes()->orderBy('created_at', 'desc')->get()
            : collect();

        // Calcul de la moyenne
        $moyenne = $notes->isNotEmpty()
            ? round($notes->avg('note'), 2)
            : null;

        // Résultats de quiz (via user)
        $resultats = $user->resultatQuizzes()
            ->with('quiz.sousChapitre.chapitre.formation')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('apprenant.resultats.index', compact('notes', 'moyenne', 'resultats'));
    }
}
