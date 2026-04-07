<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-3xl text-slate-800 tracking-tight">Mes Réussites</h2>
                <p class="text-sm text-slate-500 mt-1">Suivez votre progression et vos scores en temps réel.</p>
            </div>
            @if($moyenne !== null)
                <div class="bg-white border-2 {{ $moyenne >= 14 ? 'border-emerald-100 bg-emerald-50 text-emerald-700' : ($moyenne >= 10 ? 'border-amber-100 bg-amber-50 text-amber-700' : 'border-rose-100 bg-rose-50 text-rose-700') }} px-6 py-3 rounded-2xl shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Moyenne Générale</p>
                    <p class="text-2xl font-black">{{ $moyenne }} <span class="text-xs font-bold opacity-60">/ 20</span></p>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            {{-- ── SECTION NOTES ───────────────────────────────────────────────── --}}
            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Évaluations de l'Enseignant</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($notes as $note)
                        <div class="card flex items-center justify-between p-6 hover:shadow-xl hover:shadow-slate-100 transition-all group overflow-hidden relative">
                            <div class="relative z-10">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">{{ $note->created_at->format('d M Y') }}</p>
                                <h4 class="text-xl font-bold text-slate-800">{{ $note->matiere }}</h4>
                            </div>
                            <div class="text-right relative z-10">
                                <div class="flex items-baseline justify-end gap-1">
                                    <span class="text-3xl font-black {{ $note->note >= 14 ? 'text-emerald-600' : ($note->note >= 10 ? 'text-amber-600' : 'text-rose-600') }}">
                                        {{ number_format($note->note, 1) }}
                                    </span>
                                    <span class="text-sm font-bold text-slate-300">/ 20</span>
                                </div>
                            </div>
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-slate-50 rounded-full group-hover:scale-150 transition-transform duration-500 opacity-50"></div>
                        </div>
                    @empty
                        <div class="col-span-full card p-12 text-center border-dashed border-2 bg-slate-50/30">
                            <p class="text-slate-400 font-medium italic">Aucune note n'a encore été attribuée.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- ── SECTION QUIZ ───────────────────────────────────────────── --}}
            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-violet-600 text-white flex items-center justify-center shadow-lg shadow-violet-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Historique des Quiz</h3>
                </div>

                <div class="card p-0 overflow-hidden shadow-xl shadow-slate-200/50 border-none">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr class="font-black text-[10px] text-slate-400 uppercase tracking-widest">
                                    <th class="px-8 py-4">Quiz</th>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4 text-center">Score</th>
                                    <th class="px-8 py-4 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($resultats as $resultat)
                                    @php
                                        $quiz  = $resultat->quiz;
                                        $total = $quiz?->questions?->count() ?? 0;
                                        $pct   = $total > 0 ? round($resultat->score / $total * 100) : 0;
                                    @endphp
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-8 py-5">
                                            <p class="font-bold text-slate-700">{{ $quiz?->titre ?? 'Archive' }}</p>
                                        </td>
                                        <td class="px-8 py-5 text-sm text-slate-400">
                                            {{ $resultat->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="font-black {{ $pct >= 80 ? 'text-emerald-500' : ($pct >= 50 ? 'text-amber-500' : 'text-rose-500') }}">
                                                {{ $resultat->score }} / {{ $total }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right font-black text-[10px] {{ $pct >= 80 ? 'text-emerald-500' : ($pct >= 50 ? 'text-amber-500' : 'text-rose-500') }}">
                                            {{ $pct >= 80 ? 'RÉUSSI' : ($pct >= 50 ? 'MOYEN' : 'À REFAIRE') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic">Aucun quiz complété.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <div class="mt-8 flex justify-center">
                <a href="{{ route('apprenant.dashboard') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-2">
                    ← Retour au tableau de bord
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
