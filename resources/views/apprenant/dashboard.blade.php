<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Bonjour, {{ Auth::user()->name }} 👋
                </h2>
                <p class="text-slate-500 mt-1">Heureux de vous revoir ! Prêt à continuer votre apprentissage ?</p>
            </div>
            <div>
                {{-- Bouton "Continuer" supprimé car confus en multi-formations --}}
            </div>
        </div>
    </x-slot>

    <div class="py-8 space-y-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- ── Statistiques ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Formations -->
                <div class="card flex items-center gap-4 bg-gradient-to-br from-white to-indigo-50/30">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Mes Formations</p>
                        <p class="text-2xl font-black text-slate-800">{{ $stats['formations_count'] }}</p>
                    </div>
                </div>

                <!-- Quiz -->
                <div class="card flex items-center gap-4 bg-gradient-to-br from-white to-emerald-50/30">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Quiz Complétés</p>
                        <p class="text-2xl font-black text-slate-800">{{ $stats['quiz_count'] }}</p>
                    </div>
                </div>

                <!-- Moyenne -->
                <div class="card flex items-center gap-4 bg-gradient-to-br from-white to-amber-50/30">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Ma Moyenne</p>
                        <p class="text-2xl font-black text-slate-800">{{ $stats['moyenne'] }} <span class="text-sm font-normal text-slate-400">/ 20</span></p>
                    </div>
                </div>
            </div>

            {{-- ── Formations en cours ── --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">Mes Parcours d'Apprentissage</h3>
                </div>

                @if($formations->isEmpty())
                    <div class="card border-dashed border-2 border-slate-200 bg-slate-50/50 flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Vous n'êtes inscrit à aucune formation pour le moment.</p>
                        <p class="text-sm text-slate-400 mt-1">Contactez votre administrateur pour commencer votre parcours !</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($formations as $f)
                            <div class="card group hover:scale-[1.02] transition-all duration-300">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                        {{ $f->niveau }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $f->chapitres_count }} chapitres
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-slate-800 mb-2 truncate">{{ $f->nom }}</h4>
                                <p class="text-slate-500 text-sm line-clamp-2 mb-6 h-10">{{ $f->description }}</p>
                                
                                <div class="mt-auto pt-4 border-t border-slate-50">
                                    <a href="{{ route('apprenant.cours.chapitres', $f) }}" class="w-full btn-secondary text-xs uppercase font-black group-hover:bg-slate-100 transition-colors">
                                        Accéder aux cours
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
