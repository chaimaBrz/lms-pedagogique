<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationEnrollmentController extends Controller
{
    /**
     * Inscrire un apprenant à une formation.
     */
    public function enroll(Request $request, Formation $formation)
    {
        $request->validate([
            'apprenant_id' => 'required|exists:apprenants,id',
        ]);

        $apprenant = Apprenant::findOrFail($request->apprenant_id);

        // Attacher sans dupliquer (syncWithoutDetaching est plus sûr)
        $formation->apprenants()->syncWithoutDetaching([$apprenant->id]);

        return redirect()
            ->route('formations.show', $formation)
            ->with('success', "L'apprenant {$apprenant->nom} a été inscrit à la formation.");
    }

    /**
     * Désinscrire un apprenant d'une formation.
     */
    public function unenroll(Formation $formation, Apprenant $apprenant)
    {
        $formation->apprenants()->detach($apprenant->id);

        return redirect()
            ->route('formations.show', $formation)
            ->with('success', "L'apprenant {$apprenant->nom} a été désinscrit de cette formation.");
    }
}
