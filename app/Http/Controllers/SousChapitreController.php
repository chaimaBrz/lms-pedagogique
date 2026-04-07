<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Contenu;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class SousChapitreController extends Controller
{
    public function index(Chapitre $chapitre)
    {
        $sous_chapitres = $chapitre->sousChapitres;
        return view('admin.sous_chapitres.index', compact('chapitre', 'sous_chapitres'));
    }

    public function create(Chapitre $chapitre)
    {
        return view('admin.sous_chapitres.create', compact('chapitre'));
    }

    public function store(Request $request, Chapitre $chapitre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
        ]);

        $sousChapitre = $chapitre->sousChapitres()->create($validated);

        // Si un contenu a été saisi, créer un enregistrement dans la table contenus
        if (!empty($validated['contenu'])) {
            Contenu::create([
                'titre'           => $sousChapitre->titre,
                'texte'           => $validated['contenu'],
                'sous_chapitre_id' => $sousChapitre->id,
            ]);
        }

        return redirect()->route('chapitres.sous_chapitres.index', $chapitre)->with('success', 'Sous-chapitre créé avec succès.');
    }

    public function show(SousChapitre $sous_chapitre)
    {
        // En attendant une page de visualisation
        return back();
    }

    public function edit(SousChapitre $sous_chapitre)
    {
        return view('admin.sous_chapitres.edit', compact('sous_chapitre'));
    }

    public function update(Request $request, SousChapitre $sous_chapitre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
        ]);

        $sous_chapitre->update($validated);

        // Synchroniser avec la table contenus
        if (!empty($validated['contenu'])) {
            $contenu = $sous_chapitre->contenus()->first();
            if ($contenu) {
                // Mettre à jour le premier contenu existant
                $contenu->update([
                    'titre' => $sous_chapitre->titre,
                    'texte' => $validated['contenu'],
                ]);
            } else {
                // Créer un contenu s'il n'en existe pas encore
                Contenu::create([
                    'titre'           => $sous_chapitre->titre,
                    'texte'           => $validated['contenu'],
                    'sous_chapitre_id' => $sous_chapitre->id,
                ]);
            }
        }

        return redirect()->route('chapitres.sous_chapitres.index', $sous_chapitre->chapitre_id)->with('success', 'Sous-chapitre modifié avec succès.');
    }

    public function destroy(SousChapitre $sous_chapitre)
    {
        $chapitre_id = $sous_chapitre->chapitre_id;
        $sous_chapitre->delete();
        return redirect()->route('chapitres.sous_chapitres.index', $chapitre_id)->with('success', 'Sous-chapitre supprimé avec succès.');
    }
}
