<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(Request $request)
    {
        $query = Formation::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('niveau', 'like', "%{$search}%");
            });
        }

        $formations = $query->get();
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required|string|max:255',
            'duree' => 'nullable|string|max:255',
        ]);

        Formation::create($validated);
        return redirect()->route('formations.index')->with('success', 'Formation créée avec succès.');
    }

    public function show(Formation $formation)
    {
        $formation->load('apprenants');
        
        $enrolledIds = $formation->apprenants->pluck('id');
        $eligibleApprenants = \App\Models\Apprenant::whereNotIn('id', $enrolledIds)->get();

        return view('admin.formations.show', compact('formation', 'eligibleApprenants'));
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required|string|max:255',
            'duree' => 'nullable|string|max:255',
        ]);

        $formation->update($validated);
        return redirect()->route('formations.index')->with('success', 'Formation modifiée avec succès.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('formations.index')->with('success', 'Formation supprimée avec succès.');
    }
}
