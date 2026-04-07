<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Créer un Apprenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-0 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-6">
                    <h3 class="text-xl font-bold text-white">Nouveau Profil Apprenant</h3>
                    <p class="text-indigo-100 text-sm mt-1">Remplissez les informations pour inscrire un nouvel élève.</p>
                </div>

                <form action="{{ route('apprenants.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Section 1 : Compte --}}
                        <div class="space-y-6">
                            <h4 class="text-sm font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Identifiants de connexion
                            </h4>
                            
                            <div>
                                <label for="nom" class="form-label">Nom complet</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="form-input @error('nom') border-red-500 @enderror" placeholder="Ex: Jean Dupont" required>
                                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input @error('email') border-red-500 @enderror" placeholder="jean.dupont@exemple.com" required>
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-input @error('password') border-red-500 @enderror" required>
                                </div>
                                <div>
                                    <label for="password_confirmation" class="form-label">Confirmation</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2 : Infos Persos --}}
                        <div class="space-y-6">
                            <h4 class="text-sm font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                Informations Personnelles
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="form-input" placeholder="06 12 34 56 78">
                                </div>
                                <div>
                                    <label for="date_naissance" class="form-label">Date de naissance</label>
                                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" class="form-input">
                                </div>
                            </div>

                            <div>
                                <label for="niveau_etudes" class="form-label">Niveau d'études / Classe</label>
                                <select name="niveau_etudes" id="niveau_etudes" class="form-input">
                                    <option value="">Sélectionner un niveau</option>
                                    <option value="Débutant" {{ old('niveau_etudes') == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="Intermédiaire" {{ old('niveau_etudes') == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="Avancé" {{ old('niveau_etudes') == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                                    <option value="Baccalauréat" {{ old('niveau_etudes') == 'Baccalauréat' ? 'selected' : '' }}>Baccalauréat</option>
                                    <option value="Licence / Bachelor" {{ old('niveau_etudes') == 'Licence / Bachelor' ? 'selected' : '' }}>Licence / Bachelor</option>
                                    <option value="Master" {{ old('niveau_etudes') == 'Master' ? 'selected' : '' }}>Master</option>
                                    <option value="Doctorat" {{ old('niveau_etudes') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                </select>
                            </div>

                            <div>
                                <label for="adresse" class="form-label">Adresse de résidence</label>
                                <textarea name="adresse" id="adresse" rows="2" class="form-input" placeholder="123 Rue de la Formation, 75000 Paris">{{ old('adresse') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('apprenants.index') }}" class="text-slate-500 hover:text-slate-700 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Retour à la liste
                        </a>
                        <button type="submit" class="btn-primary px-10">
                            Enregistrer l'apprenant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
