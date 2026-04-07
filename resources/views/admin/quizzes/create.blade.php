<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Créer un Quiz pour : "{{ $sous_chapitre->titre }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('sous_chapitres.quizzes.store', $sous_chapitre) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre du quiz :</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                               placeholder="Ex : Quiz sur les verbes irréguliers" required>
                        @error('titre') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">Créer le Quiz</button>
                        <a href="{{ route('sous_chapitres.quizzes.index', $sous_chapitre) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
