<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('apprenant.cours.sous_chapitres', $sous_chapitre->chapitre) }}" class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">{{ $sous_chapitre->titre }}</h2>
                <p class="text-xs text-slate-400 mt-0.5 uppercase tracking-widest font-black">
                    Chapitre : <span class="text-slate-600">{{ $sous_chapitre->chapitre->titre }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Résultat de quiz flash --}}
            @if(session('quiz_score') !== null)
                @php $score = session('quiz_score'); $total = session('quiz_total'); @endphp
                <div class="{{ $score === $total ? 'bg-emerald-50 border-emerald-100 text-emerald-800 shadow-emerald-100' : ($score >= $total / 2 ? 'bg-amber-50 border-amber-100 text-amber-800 shadow-amber-100' : 'bg-rose-50 border-rose-100 text-rose-800 shadow-rose-100') }} border-2 rounded-3xl px-6 py-6 shadow-xl animate-bounce-subtle">
                    <div class="flex items-center gap-4">
                        <div class="text-3xl">
                            @if($score === $total) 🏆
                            @elseif($score >= $total / 2) ✨
                            @else 💪
                            @endif
                        </div>
                        <div>
                            <p class="text-lg font-black uppercase tracking-tight">
                                @if($score === $total) Score Parfait !
                                @elseif($score >= $total / 2) Très bon score !
                                @else Continue tes efforts !
                                @endif
                            </p>
                            <p class="opacity-80">Tu as obtenu <strong>{{ $score }} / {{ $total }}</strong> au quiz <em>{{ session('quiz_nom') }}</em>.</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Contenus --}}
            @forelse($contenus as $contenu)
                <article class="card p-8 md:p-12 prose max-w-none shadow-2xl shadow-slate-200/50">
                    <h3 class="text-3xl font-black text-slate-800 mb-6 border-l-4 border-indigo-500 pl-6">{{ $contenu->titre }}</h3>
                    <div class="text-slate-600 text-lg whitespace-pre-wrap leading-relaxed font-medium tracking-tight">{{ $contenu->texte }}</div>
                    
                    @if($contenu->lien_ressource)
                        <div class="mt-10 pt-6 border-t border-slate-100">
                            <a href="{{ $contenu->lien_ressource }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-slate-50 hover:bg-indigo-50 text-indigo-600 rounded-xl text-sm font-bold transition-all border border-transparent hover:border-indigo-100">
                                🔗 Ressource complémentaire
                            </a>
                        </div>
                    @endif
                </article>
            @empty
                <div class="card p-12 text-center bg-slate-50/50 border-dashed border-2">
                    <p class="text-slate-400 font-medium italic">Aucun contenu textuel n'est encore disponible pour cette leçon.</p>
                </div>
            @endforelse

            {{-- Section Quiz Premium --}}
            @if($quiz)
                <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 text-white shadow-2xl shadow-indigo-200 flex flex-col md:flex-row items-center justify-between gap-8 group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                            🎯
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] opacity-70 mb-1">Auto-évaluation</p>
                            <h4 class="text-xl font-black">{{ $quiz->titre }}</h4>
                            @if($resultat)
                                <p class="text-sm font-bold text-indigo-200 mt-2 bg-white/10 inline-block px-3 py-1 rounded-lg">
                                    Dernier essai : {{ $resultat->score }} / {{ $quiz->questions->count() }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('apprenant.quiz.show', $quiz) }}"
                       class="w-full md:w-auto px-8 py-4 bg-white text-indigo-600 font-black rounded-2xl hover:bg-slate-50 transition-all shadow-lg hover:shadow-xl active:scale-95 text-center">
                        {{ $resultat ? 'Recommencer le quiz' : 'Démarrer le quiz' }}
                    </a>
                </div>
            @endif

            {{-- Pied de page / Navigation --}}
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('apprenant.cours.sous_chapitres', $sous_chapitre->chapitre) }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-2">
                    ← Retour à la liste des leçons
                </a>
            </div>

        </div>
    </div>

        </div>
    </div>
</x-app-layout>
