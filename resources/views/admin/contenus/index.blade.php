<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                    Contenus : {{ $sous_chapitre->titre }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    <a href="{{ route('formations.index') }}" class="hover:underline">Formations</a>
                    → <a href="{{ route('formations.chapitres.index', $sous_chapitre->chapitre->formation_id) }}" class="hover:underline">Chapitres</a>
                    → <a href="{{ route('chapitres.sous_chapitres.index', $sous_chapitre->chapitre_id) }}" class="hover:underline">{{ $sous_chapitre->chapitre->titre }}</a>
                    → {{ $sous_chapitre->titre }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('chapitres.sous_chapitres.index', $sous_chapitre->chapitre_id) }}" class="btn-secondary">
                    ← Sous-chapitres
                </a>
                <a href="{{ route('sous_chapitres.contenus.create', $sous_chapitre) }}" class="btn-primary">
                    + Nouveau Contenu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Liste des contenus --}}
            <div class="card">
                <div class="">
                    <h3 class="text-lg font-semibold mb-4">Contenus enregistrés ({{ $contenus->count() }})</h3>
                    @forelse($contenus as $contenu)
                        <div class="border rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-800">{{ $contenu->titre }}</h4>
                                    <p class="text-slate-600 text-sm mt-1 whitespace-pre-wrap">{{ Str::limit($contenu->texte, 200) }}</p>
                                    @if($contenu->lien_ressource)
                                        <a href="{{ $contenu->lien_ressource }}" target="_blank" class="text-blue-500 text-xs mt-1 inline-block hover:underline">
                                            🔗 {{ $contenu->lien_ressource }}
                                        </a>
                                    @endif
                                </div>
                                <div class="flex flex-col space-y-1 ml-4">
                                    <a href="{{ route('contenus.edit', $contenu) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Éditer</a>
                                    <form action="{{ route('contenus.destroy', $contenu) }}" method="POST" onsubmit="return confirm('Supprimer ce contenu ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-center py-8">Aucun contenu pour ce sous-chapitre. Cliquez sur "+ Nouveau Contenu" pour en ajouter un.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
