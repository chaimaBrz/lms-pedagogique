<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Apprenant::query()->with(['formations', 'notes']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $apprenants = $query->get();
        return view('admin.notes.index', compact('apprenants'));
    }

    public function create()
    {
        $apprenants = Apprenant::with('formations')->get();
        return view('admin.notes.create', compact('apprenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'apprenant_id' => 'required|exists:apprenants,id',
            'matiere'      => 'required|string|max:255',
            'note'         => 'required|numeric|min:0|max:20',
        ]);

        // user_id = l'utilisateur lié à l'apprenant
        $apprenant = Apprenant::findOrFail($validated['apprenant_id']);
        $validated['user_id'] = $apprenant->user_id;

        Note::create($validated);

        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès.');
    }

    public function show(Note $note)
    {
        return redirect()->route('notes.index');
    }

    public function edit(Note $note)
    {
        $note->load('apprenant.formations');
        $apprenants = Apprenant::with('formations')->get();
        return view('admin.notes.edit', compact('note', 'apprenants'));
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'apprenant_id' => 'required|exists:apprenants,id',
            'matiere'      => 'required|string|max:255',
            'note'         => 'required|numeric|min:0|max:20',
        ]);

        $apprenant = Apprenant::findOrFail($validated['apprenant_id']);
        $validated['user_id'] = $apprenant->user_id;

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', 'Note modifiée avec succès.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès.');
    }
}
