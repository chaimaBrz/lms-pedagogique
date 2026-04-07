<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h2>
            <p class="text-sm text-slate-500 mt-1">Gérez votre plateforme d'apprentissage intelligente</p>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- ── Statistiques Principales (Grid) ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Stat 1: Formations --}}
            <div class="card !p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total Formations</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['formations_count'] }}</p>
                </div>
            </div>

            {{-- Stat 2: Apprenants --}}
            <div class="card !p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Apprenants Inscrits</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['apprenants_count'] }}</p>
                </div>
            </div>

            {{-- Stat 3: Quiz --}}
            <div class="card !p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Quiz Créés</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['quizzes_count'] }}</p>
                </div>
            </div>

            {{-- Stat 4: Moyenne --}}
            <div class="card !p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Moyenne Globale</h3>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['moyenne_notes'] }} <span class="text-sm font-normal text-slate-400">/ 20</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- ── Activité Récente (2/3 largeur) ── --}}
            <div class="lg:col-span-2">
                <div class="card h-full">
                    <div class="card-header pb-0 border-none mb-4">
                        <h3 class="card-title">Dernières Formations Créées</h3>
                        <a href="{{ route('formations.index') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium">Voir tout →</a>
                    </div>
                    
                    @if($dernieresFormations->isEmpty())
                        <div class="py-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <p class="text-slate-500">Aucune formation créée pour le moment.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm whitespace-nowrap">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-t border-slate-200">
                                        <th class="px-4 py-3 first:pl-0 last:pr-0">Formation</th>
                                        <th class="px-4 py-3">Chapitres</th>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($dernieresFormations as $formation)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-4 py-3 first:pl-0">
                                                <p class="font-medium text-slate-800 truncate max-w-[200px]">{{ $formation->nom }}</p>
                                                <p class="text-xs text-slate-400">{{ $formation->niveau }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700">
                                                    {{ $formation->chapitres_count }} chapitre(s)
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-slate-500">
                                                {{ $formation->created_at->diffForHumans() }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('formations.chapitres.index', $formation) }}" class="text-primary-600 hover:text-primary-800 font-medium text-sm bg-primary-50 px-3 py-1 rounded-lg hover:bg-primary-100 transition">Ouvrir</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Actions Rapides (1/3 largeur) ── --}}
            <div>
                <div class="card h-full bg-gradient-to-br from-primary-600 to-violet-700 text-white border-none shadow-lg">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Actions Rapides
                    </h3>
                    
                    <div class="space-y-4">
                        {{-- Créer IA --}}
                        <a href="{{ route('assistant.ia') }}" class="flex items-center justify-between bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 p-4 rounded-xl transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/20 p-2 rounded-lg text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                </div>
                                <span class="font-medium group-hover:translate-x-1 transition-transform">Créer par Assistant IA</span>
                            </div>
                            <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>

                        {{-- Créer manuel --}}
                        <a href="{{ route('formations.create') }}" class="flex items-center justify-between bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 p-4 rounded-xl transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/20 p-2 rounded-lg text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="font-medium group-hover:translate-x-1 transition-transform">Nouvelle formation vide</span>
                            </div>
                            <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>

                        {{-- Ajouter Apprenant --}}
                        <a href="{{ route('apprenants.create') }}" class="flex items-center justify-between bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 p-4 rounded-xl transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/20 p-2 rounded-lg text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </div>
                                <span class="font-medium group-hover:translate-x-1 transition-transform">Inscrire un apprenant</span>
                            </div>
                            <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
