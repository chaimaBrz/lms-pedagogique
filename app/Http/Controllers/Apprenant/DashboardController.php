<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Apprenant;
use App\Models\Formation;

use App\Models\Note;
use App\Models\ResultatQuiz;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $apprenant = $user->apprenant;

        if (!$apprenant) {
            // Cas de l'admin ou d'un utilisateur sans profil apprenant
            return view('apprenant.dashboard', [
                'user' => $user,
                'formations' => collect(),
                'stats' => ['moyenne' => 0, 'formations_count' => 0, 'quiz_count' => 0]
            ]);
        }

        $formations = $apprenant->formations()->withCount('chapitres')->get();
        
        $stats = [
            'formations_count' => $formations->count(),
            'quiz_count'       => ResultatQuiz::where('user_id', $user->id)->count(),
            'moyenne'          => number_format(Note::where('apprenant_id', $apprenant->id)->avg('note') ?? 0, 1)
        ];

        return view('apprenant.dashboard', compact('user', 'apprenant', 'formations', 'stats'));
    }
}
