<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Éditer le Quiz : "{{ $quiz->titre }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre du quiz :</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre', $quiz->titre) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        @error('titre') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">Mettre à jour</button>
                        <a href="{{ route('sous_chapitres.quizzes.index', $quiz->sous_chapitre_id) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
