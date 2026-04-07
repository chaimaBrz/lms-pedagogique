<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Créer un Sous-chapitre pour : {{ $chapitre->titre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('chapitres.sous_chapitres.store', $chapitre) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre :</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="contenu" class="block text-gray-700 text-sm font-bold mb-2">Contenu :</label>
                        <textarea name="contenu" id="contenu" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>{{ old('contenu') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">Créer</button>
                        <a href="{{ route('chapitres.sous_chapitres.index', $chapitre) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
