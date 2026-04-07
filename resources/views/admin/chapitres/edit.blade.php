<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Éditer le Chapitre : {{ $chapitre->titre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('chapitres.update', $chapitre) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre :</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre', $chapitre->titre) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description :</label>
                        <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>{{ old('description', $chapitre->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">Mettre à jour</button>
                        <a href="{{ route('formations.chapitres.index', $chapitre->formation_id) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
