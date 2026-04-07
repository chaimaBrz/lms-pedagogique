<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                🎓 Formations de l'apprenant : {{ $apprenant->nom }}
            </h2>
            <a href="{{ route('apprenants.index') }}" class="btn-secondary">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl shadow-sm mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Carte de Profil GAUCHE --}}
                <div class="lg:col-span-4 space-y-6">
                    <div class="card p-0 overflow-hidden bg-white shadow-xl border-none">
                        <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                        <div class="px-6 pb-8 -mt-12">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-white rounded-3xl shadow-lg p-1 mb-4">
                                    <div class="w-full h-full bg-slate-100 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-3xl">
                                        {{ strtoupper(substr($apprenant->nom, 0, 1)) }}
                                    </div>
                                </div>
                                <h3 class="text-xl font-black text-slate-800">{{ $apprenant->nom }}</h3>
                                <p class="text-slate-500 text-sm font-medium mb-6">{{ $apprenant->email }}</p>
                                
                                <div class="w-full space-y-4 pt-4 border-t border-slate-100">
                                    <div class="flex items-start gap-4">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Téléphone</p>
                                            <p class="text-sm font-bold text-slate-700">{{ $apprenant->telephone ?? 'Non renseigné' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Date de Naissance</p>
                                            <p class="text-sm font-bold text-slate-700">{{ $apprenant->date_naissance ? \Carbon\Carbon::parse($apprenant->date_naissance)->format('d F Y') : 'Non renseignée' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Niveau Académique</p>
                                            <p class="text-sm font-bold text-slate-700">{{ $apprenant->niveau_etudes ?? 'Non défini' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Adresse</p>
                                            <p class="text-sm font-bold text-slate-700 leading-snug">{{ $apprenant->adresse ?? 'Non renseignée' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full mt-8">
                                    <a href="{{ route('apprenants.edit', $apprenant) }}" class="btn-secondary w-full justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Modifier le Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Inscription --}}
                    <div class="card p-6 border-none shadow-lg">
                        <h4 class="text-sm font-black uppercase text-slate-800 mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            Nouvelle Inscription
                        </h4>
                        
                        <form action="{{ route('apprenants.enroll', $apprenant) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <select name="formation_id" class="form-input text-sm" required>
                                    <option value="">Sélectionner une formation...</option>
                                    @foreach($eligibleFormations as $eligible)
                                        <option value="{{ $eligible->id }}">{{ $eligible->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-primary w-full shadow-indigo-200 @if($eligibleFormations->isEmpty()) opacity-50 cursor-not-allowed @endif" @if($eligibleFormations->isEmpty()) disabled @endif>
                                Inscrire l'apprenant
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Liste des cours suivis DROITE --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="card p-0 overflow-hidden border-none shadow-lg">
                        <div class="px-8 py-6 border-b border-slate-50 bg-white">
                            <h3 class="text-xl font-black text-slate-800">Parcours Académique</h3>
                            <p class="text-sm text-slate-400 mt-1">Liste des formations auxquelles l'apprenant participe activement.</p>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black border-b border-slate-100">
                                    <tr>
                                        <th class="py-4 px-8">Formation</th>
                                        <th class="py-4 px-8">Niveau</th>
                                        <th class="py-4 px-8 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($apprenant->formations as $formation)
                                        <tr class="hover:bg-slate-50 transition-colors group">
                                            <td class="py-5 px-8">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                                        {{ substr($formation->nom, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-slate-800 block text-base">{{ $formation->nom }}</span>
                                                        <span class="text-xs text-slate-400">{{ $formation->chapitres->count() }} chapitres enregistrés</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-5 px-8">
                                                <span class="px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase rounded-lg tracking-wide">
                                                    {{ $formation->niveau }}
                                                </span>
                                            </td>
                                            <td class="py-5 px-8 text-right">
                                                <form action="{{ route('apprenants.unenroll', [$apprenant, $formation]) }}" method="POST" onsubmit="return confirm('Désinscrire l\'élève ?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-20 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                    <p class="text-slate-400 font-medium italic">Aucun cours suivi pour le moment.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
