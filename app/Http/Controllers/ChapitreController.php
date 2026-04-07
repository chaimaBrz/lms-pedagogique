<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Formation;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    public function index(Formation $formation)
    {
        $chapitres = $formation->chapitres;
        return view('admin.chapitres.index', compact('formation', 'chapitres'));
    }

    public function create(Formation $formation)
    {
        return view('admin.chapitres.create', compact('formation'));
    }

    public function store(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $formation->chapitres()->create($validated);
        return redirect()->route('formations.chapitres.index', $formation)->with('success', 'Chapitre créé avec succès.');
    }

    public function show(Chapitre $chapitre)
    {
        return redirect()->route('chapitres.sous_chapitres.index', $chapitre);
    }

    public function edit(Chapitre $chapitre)
    {
        return view('admin.chapitres.edit', compact('chapitre'));
    }

    public function update(Request $request, Chapitre $chapitre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $chapitre->update($validated);
        return redirect()->route('formations.chapitres.index', $chapitre->formation_id)->with('success', 'Chapitre modifié avec succès.');
    }

    public function destroy(Chapitre $chapitre)
    {
        $formation_id = $chapitre->formation_id;
        $chapitre->delete();
        return redirect()->route('formations.chapitres.index', $formation_id)->with('success', 'Chapitre supprimé avec succès.');
    }
}
