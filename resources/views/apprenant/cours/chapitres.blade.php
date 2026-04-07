<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ $formation->nom }}</h2>
            <p class="text-sm text-slate-500 mt-1">
                <a href="{{ route('apprenant.dashboard') }}" class="hover:underline">Dashboard</a>
                → Chapitres
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-0 overflow-hidden">
                <div class="bg-slate-50/50 p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">Contenu de la formation</h3>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ count($chapitres) }} Chapitres</span>
                </div>
                
                <div class="divide-y divide-slate-100">
                    @forelse($chapitres as $i => $chapitre)
                        <a href="{{ route('apprenant.cours.sous_chapitres', $chapitre) }}"
                           class="group flex items-center justify-between p-6 hover:bg-indigo-50/30 transition-all duration-300">
                            <div class="flex items-center gap-6">
                                <span class="w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-100 text-slate-400 group-hover:bg-indigo-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-indigo-200 font-black text-sm transition-all duration-300">
                                    {{ $i + 1 }}
                                </span>
                                <div>
                                    <p class="font-bold text-slate-700 group-hover:text-indigo-600 transition-colors text-lg">{{ $chapitre->titre }}</p>
                                    <p class="text-sm text-slate-400 mt-0.5">{{ Str::limit($chapitre->description, 120) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-bold text-slate-400 group-hover:text-indigo-400 transition-colors">Explorer</span>
                                <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5 5 5-5M7 7l5 5 5-5"></path></svg>
                            </div>
                        </a>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-400 italic">Aucun chapitre n'est encore disponible pour cette formation.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-8">
                <a href="{{ route('apprenant.dashboard') }}" class="text-sm font-semibold text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-2">
                   ← Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
