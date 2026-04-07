<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Éditer l'Apprenant : {{ $apprenant->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-0 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-6 text-white text-center">
                    <h3 class="text-xl font-bold">Modifier le Profil : {{ $apprenant->nom }}</h3>
                    <p class="text-amber-100 text-sm mt-1">Mettez à jour les informations du compte ou les détails personnels.</p>
                </div>

                <form action="{{ route('apprenants.update', $apprenant) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Section 1 : Compte --}}
                        <div class="space-y-6">
                            <h4 class="text-sm font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Sécurité du Compte
                            </h4>
                            
                            <div>
                                <label for="nom" class="form-label">Nom complet</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $apprenant->nom) }}" class="form-input @error('nom') border-red-500 @enderror" required>
                                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $apprenant->email) }}" class="form-input @error('email') border-red-500 @enderror" required>
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs text-slate-500 mb-3 italic">Modifier le mot de passe (laisser vide si inchangé)</p>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="password" class="form-label">Nouveau mot de passe</label>
                                        <input type="password" name="password" id="password" class="form-input @error('password') border-red-500 @enderror" placeholder="••••••••">
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="form-label">Confirmer le nouveau</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2 : Infos Persos --}}
                        <div class="space-y-6">
                            <h4 class="text-sm font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                Détails Personnels
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $apprenant->telephone) }}" class="form-input">
                                </div>
                                <div>
                                    <label for="date_naissance" class="form-label">Date de naissance</label>
                                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $apprenant->date_naissance) }}" class="form-input">
                                </div>
                            </div>

                            <div>
                                <label for="niveau_etudes" class="form-label">Niveau d'études / Classe</label>
                                <select name="niveau_etudes" id="niveau_etudes" class="form-input">
                                    <option value="">Sélectionner un niveau</option>
                                    @php $levels = ['Débutant', 'Intermédiaire', 'Avancé', 'Baccalauréat', 'Licence / Bachelor', 'Master', 'Doctorat']; @endphp
                                    @foreach($levels as $level)
                                        <option value="{{ $level }}" {{ old('niveau_etudes', $apprenant->niveau_etudes) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="adresse" class="form-label">Adresse de résidence</label>
                                <textarea name="adresse" id="adresse" rows="2" class="form-input">{{ old('adresse', $apprenant->adresse) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('apprenants.index') }}" class="text-slate-500 hover:text-slate-700 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Retour à la galerie
                        </a>
                        <button type="submit" class="btn-primary bg-amber-600 hover:bg-amber-700 shadow-amber-200">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
