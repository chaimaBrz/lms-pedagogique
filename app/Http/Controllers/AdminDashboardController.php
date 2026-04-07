<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use App\Models\Formation;
use App\Models\Note;
use App\Models\Quiz;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Statistiques générales
        $stats = [
            'formations_count' => Formation::count(),
            'apprenants_count' => Apprenant::count(),
            'quizzes_count'    => Quiz::count(),
            // Calculer la moyenne des notes (si aucune note, alors 0)
            'moyenne_notes'    => number_format(Note::avg('note') ?? 0, 1)
        ];

        // 2. Activité récente (les 5 dernières formations avec leurs chapitres)
        $dernieresFormations = Formation::withCount('chapitres')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'dernieresFormations'));
    }
}
