<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    public function index(SousChapitre $sous_chapitre)
    {
        $contenus = $sous_chapitre->contenus;
        return view('admin.contenus.index', compact('sous_chapitre', 'contenus'));
    }

    public function create(SousChapitre $sous_chapitre)
    {
        return view('admin.contenus.create', compact('sous_chapitre'));
    }

    public function store(Request $request, SousChapitre $sous_chapitre)
    {
        $validated = $request->validate([
            'titre'          => 'required|string|max:255',
            'texte'          => 'required|string',
            'lien_ressource' => 'nullable|url|max:255',
        ]);

        $sous_chapitre->contenus()->create($validated);

        return redirect()
            ->route('sous_chapitres.contenus.index', $sous_chapitre)
            ->with('success', 'Contenu ajouté avec succès.');
    }

    /**
     * Import rapide : un seul champ texte collé depuis une IA.
     * On crée automatiquement un Contenu avec un titre généré.
     */
    public function importStore(Request $request, SousChapitre $sous_chapitre)
    {
        $request->validate([
            'texte_importe' => 'required|string',
        ]);

        $sous_chapitre->contenus()->create([
            'titre' => 'Import IA – ' . now()->format('d/m/Y H:i'),
            'texte' => $request->texte_importe,
        ]);

        return redirect()
            ->route('sous_chapitres.contenus.index', $sous_chapitre)
            ->with('success', 'Contenu importé avec succès.');
    }

    public function show(Contenu $contenu)
    {
        return redirect()->route('sous_chapitres.contenus.index', $contenu->sous_chapitre_id);
    }

    public function edit(Contenu $contenu)
    {
        return view('admin.contenus.edit', compact('contenu'));
    }

    public function update(Request $request, Contenu $contenu)
    {
        $validated = $request->validate([
            'titre'          => 'required|string|max:255',
            'texte'          => 'required|string',
            'lien_ressource' => 'nullable|url|max:255',
        ]);

        $contenu->update($validated);

        return redirect()
            ->route('sous_chapitres.contenus.index', $contenu->sous_chapitre_id)
            ->with('success', 'Contenu modifié avec succès.');
    }

    public function destroy(Contenu $contenu)
    {
        $sous_chapitre_id = $contenu->sous_chapitre_id;
        $contenu->delete();

        return redirect()
            ->route('sous_chapitres.contenus.index', $sous_chapitre_id)
            ->with('success', 'Contenu supprimé avec succès.');
    }
}
