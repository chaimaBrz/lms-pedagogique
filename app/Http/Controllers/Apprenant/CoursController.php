<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Formation;
use App\Models\SousChapitre;

class CoursController extends Controller
{
    public function chapitres(Formation $formation)
    {
        // Vérifier que l'apprenant est inscrit à cette formation
        $apprenant = auth()->user()->apprenant;
        abort_unless($apprenant && $apprenant->formations->contains($formation->id), 403);

        $chapitres = $formation->chapitres;
        return view('apprenant.cours.chapitres', compact('formation', 'chapitres'));
    }

    public function sousChapitres(Chapitre $chapitre)
    {
        $formation = $chapitre->formation;
        $apprenant = auth()->user()->apprenant;
        abort_unless($apprenant && $apprenant->formations->contains($formation->id), 403);

        $sous_chapitres = $chapitre->sousChapitres;
        return view('apprenant.cours.sous_chapitres', compact('formation', 'chapitre', 'sous_chapitres'));
    }

    public function contenus(SousChapitre $sous_chapitre)
    {
        $formation = $sous_chapitre->chapitre->formation;
        $apprenant = auth()->user()->apprenant;
        abort_unless($apprenant && $apprenant->formations->contains($formation->id), 403);

        $contenus = $sous_chapitre->contenus;
        $quiz = $sous_chapitre->quizzes()->first();
        $resultat = $quiz
            ? auth()->user()->resultatQuizzes()->where('quiz_id', $quiz->id)->latest()->first()
            : null;

        return view('apprenant.cours.contenus', compact('formation', 'sous_chapitre', 'contenus', 'quiz', 'resultat'));
    }
}
