<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use App\Models\Formation;
use Illuminate\Http\Request;

class ApprenantEnrollmentController extends Controller
{
    /**
     * Inscrire l'élève à une formation supplémentaire.
     */
    public function enroll(Request $request, Apprenant $apprenant)
    {
        $request->validate([
            'formation_id' => 'required|exists:formations,id',
        ]);

        $formation = Formation::findOrFail($request->formation_id);

        // Attacher sans dédoubler
        $apprenant->formations()->syncWithoutDetaching([$formation->id]);

        return redirect()
            ->route('apprenants.show', $apprenant)
            ->with('success', "L'élève a bien été inscrit à la formation : {$formation->nom}.");
    }

    /**
     * Désinscrire l'élève d'une formation précise.
     */
    public function unenroll(Apprenant $apprenant, Formation $formation)
    {
        $apprenant->formations()->detach($formation->id);

        return redirect()
            ->route('apprenants.show', $apprenant)
            ->with('success', "L'élève a été retiré de la formation : {$formation->nom}.");
    }
}
