<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ApprenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Apprenant::query()->with('formations');

        // Filtrer par recherche (nom ou email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtrer par formation spécifique
        if ($request->filled('formation_id')) {
            $query->whereHas('formations', function($q) use ($request) {
                $q->where('formations.id', $request->formation_id);
            });
        }

        $apprenants = $query->get();
        $formations = Formation::orderBy('nom')->get();
        
        $selectedFormation = null;
        if ($request->filled('formation_id')) {
            $selectedFormation = Formation::find($request->formation_id);
        }

        return view('admin.apprenants.index', compact('apprenants', 'formations', 'selectedFormation'));
    }

    public function create()
    {
        return view('admin.apprenants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'                  => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email|unique:apprenants,email',
            'password'             => ['required', 'confirmed', Password::min(8)],
            'telephone'            => 'nullable|string|max:20',
            'date_naissance'       => 'nullable|date',
            'adresse'              => 'nullable|string|max:500',
            'niveau_etudes'        => 'nullable|string|max:255',
        ]);

        // 1. Créer le compte User
        $user = User::create([
            'name'     => $request->nom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'apprenant',
        ]);

        // 2. Créer l'enregistrement Apprenant lié
        Apprenant::create([
            'nom'            => $request->nom,
            'email'          => $request->email,
            'user_id'        => $user->id,
            'telephone'      => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'adresse'        => $request->adresse,
            'niveau_etudes'  => $request->niveau_etudes,
        ]);

        return redirect()
            ->route('apprenants.index')
            ->with('success', "Apprenant {$request->nom} créé avec succès. Il peut se connecter avec l'adresse {$request->email}.");
    }

    public function show(Apprenant $apprenant)
    {
        $apprenant->load('formations');
        
        $enrolledIds = $apprenant->formations->pluck('id');
        $eligibleFormations = Formation::whereNotIn('id', $enrolledIds)->get();

        return view('admin.apprenants.show', compact('apprenant', 'eligibleFormations'));
    }

    public function edit(Apprenant $apprenant)
    {
        return view('admin.apprenants.edit', compact('apprenant'));
    }

    public function update(Request $request, Apprenant $apprenant)
    {
        $request->validate([
            'nom'                  => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email,' . $apprenant->user_id . '|unique:apprenants,email,' . $apprenant->id,
            'password'             => ['nullable', 'confirmed', Password::min(8)],
            'telephone'            => 'nullable|string|max:20',
            'date_naissance'       => 'nullable|date',
            'adresse'              => 'nullable|string|max:500',
            'niveau_etudes'        => 'nullable|string|max:255',
        ]);

        // Mise à jour du User lié
        if ($apprenant->user) {
            $userUpdate = [
                'name'  => $request->nom,
                'email' => $request->email,
            ];
            // Changer le mot de passe seulement si fourni
            if ($request->filled('password')) {
                $userUpdate['password'] = Hash::make($request->password);
            }
            $apprenant->user->update($userUpdate);
        }

        // Mise à jour de l'Apprenant
        $apprenant->update([
            'nom'            => $request->nom,
            'email'          => $request->email,
            'telephone'      => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'adresse'        => $request->adresse,
            'niveau_etudes'  => $request->niveau_etudes,
        ]);

        return redirect()
            ->route('apprenants.index')
            ->with('success', 'Apprenant modifié avec succès.');
    }

    public function destroy(Apprenant $apprenant)
    {
        // Récupérer le user AVANT de supprimer l'apprenant (cascade FK)
        $user = $apprenant->user;
        $apprenant->delete();

        // Supprimer aussi le compte User sauf si c'est admin@lms.fr (sécurité)
        if ($user && $user->role === 'apprenant') {
            $user->delete();
        }

        return redirect()
            ->route('apprenants.index')
            ->with('success', 'Apprenant et son compte utilisateur supprimés avec succès.');
    }
}
