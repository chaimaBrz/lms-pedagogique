<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Nouveau contenu pour : "{{ $sous_chapitre->titre }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('sous_chapitres.contenus.store', $sous_chapitre) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre :</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        @error('titre') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="texte" class="block text-gray-700 text-sm font-bold mb-2">Contenu pédagogique :</label>
                        <textarea name="texte" id="texte" rows="12"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                                  required>{{ old('texte') }}</textarea>
                        @error('texte') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="lien_ressource" class="block text-gray-700 text-sm font-bold mb-2">
                            Lien ressource <span class="text-gray-400 font-normal">(optionnel)</span> :
                        </label>
                        <input type="url" name="lien_ressource" id="lien_ressource" value="{{ old('lien_ressource') }}"
                               placeholder="https://..."
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        @error('lien_ressource') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">
                            Enregistrer
                        </button>
                        <a href="{{ route('sous_chapitres.contenus.index', $sous_chapitre) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
