<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('apprenant.cours.chapitres', $formation) }}" class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">{{ $chapitre->titre }}</h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    Formation : <span class="font-semibold text-indigo-500">{{ $formation->nom }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-0 overflow-hidden shadow-xl shadow-slate-200/50">
                <div class="p-6 md:p-8 bg-gradient-to-br from-slate-50 to-white border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Objectifs du chapitre</h3>
                    <p class="text-slate-500 leading-relaxed">{{ $chapitre->description }}</p>
                </div>

                <div class="p-6 md:p-8 space-y-4">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">📖 Liste des leçons</h4>
                    <div class="grid gap-3">
                        @forelse($sous_chapitres as $i => $sc)
                            <a href="{{ route('apprenant.cours.contenus', $sc) }}"
                               class="group flex items-center justify-between p-5 rounded-2xl border border-slate-100 bg-slate-50/30 hover:bg-white hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-50 transition-all duration-300">
                                <div class="flex items-center gap-5">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-100 transition-colors font-bold shadow-sm">
                                        {{ $i + 1 }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 group-hover:text-indigo-700 transition-colors">{{ $sc->titre }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            Leçon interactive disponible
                                        </p>
                                    </div>
                                </div>
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 group-hover:text-indigo-500 group-hover:bg-indigo-50 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        @empty
                            <div class="py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <p class="text-slate-400 italic">Aucune leçon n'est encore programmée pour ce chapitre.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
