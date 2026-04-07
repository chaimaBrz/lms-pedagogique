<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Créer une Formation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('formations.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom :</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description :</label>
                        <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="niveau" class="block text-gray-700 text-sm font-bold mb-2">Niveau :</label>
                        <input type="text" name="niveau" id="niveau" value="{{ old('niveau') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="duree" class="block text-gray-700 text-sm font-bold mb-2">Durée :</label>
                        <input type="text" name="duree" id="duree" value="{{ old('duree') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">Créer</button>
                        <a href="{{ route('formations.index') }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
