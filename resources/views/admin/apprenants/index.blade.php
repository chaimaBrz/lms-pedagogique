<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Liste des Apprenants') }}
                @if($selectedFormation)
                    - {{ $selectedFormation->nom }}
                @endif
            </h2>
            <div class="flex space-x-2">
                @if(request()->has('formation_id'))
                    <a href="{{ route('formations.index') }}" class="btn-secondary">Retour aux formations</a>
                @endif
                <a href="{{ route('apprenants.create') }}" class="btn-primary">
                    Nouvel Apprenant
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl shadow-sm mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Barre de recherche et filtres Premium --}}
            <div class="card p-6 border-none shadow-lg bg-white/80 backdrop-blur-md">
                <form action="{{ route('apprenants.index') }}" method="GET" class="flex flex-col lg:flex-row gap-6 items-end">
                    <div class="flex-1 w-full">
                        <label class="form-label text-slate-400">Rechercher</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Nom, email..." 
                                class="form-input pl-10">
                        </div>
                    </div>
                    <div class="w-full lg:w-72">
                        <label class="form-label text-slate-400">Par formation</label>
                        <select name="formation_id" class="form-input">
                            <option value="">Toutes les formations</option>
                            @foreach($formations as $f)
                                <option value="{{ $f->id }}" {{ request('formation_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3 w-full lg:w-auto">
                        <button type="submit" class="btn-primary w-full lg:w-auto px-8">
                            Filtrer
                        </button>
                        @if(request()->has('search') || request()->has('formation_id'))
                            <a href="{{ route('apprenants.index') }}" class="btn-secondary w-full lg:w-auto justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card p-0 overflow-hidden border-none shadow-xl">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black border-b border-slate-100">
                        <tr>
                            <th class="py-4 px-8 uppercase font-black tracking-widest">Apprenant</th>
                            <th class="py-4 px-8 uppercase font-black tracking-widest">Contact / Niveau</th>
                            <th class="py-4 px-8 uppercase font-black tracking-widest">Formations</th>
                            <th class="py-4 px-8 text-right uppercase font-black tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($apprenants as $apprenant)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-5 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">
                                        {{ strtoupper(substr($apprenant->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-base">{{ $apprenant->nom }}</p>
                                        <p class="text-xs text-slate-400">{{ $apprenant->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-8 text-sm">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="font-bold text-slate-700">{{ $apprenant->telephone ?? 'Non renseigné' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[9px] font-black uppercase rounded">
                                        {{ $apprenant->niveau_etudes ?? 'Niveau non défini' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @forelse($apprenant->formations as $formation)
                                        <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-tight">
                                            {{ $formation->nom }}
                                        </span>
                                    @empty
                                        <span class="text-slate-300 text-xs italic">Aucune inscription</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-5 px-8 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('apprenants.show', $apprenant) }}" title="Voir profil & formations" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </a>
                                    <a href="{{ route('apprenants.edit', $apprenant) }}" title="Modifier" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('apprenants.destroy', $apprenant) }}" method="POST" onsubmit="return confirm('Sûr de vouloir supprimer ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Supprimer" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6 font-black italic">!</div>
                                    <p class="text-slate-400 font-medium italic">Aucun apprenant enregistré.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
