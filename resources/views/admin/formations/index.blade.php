<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Liste des Formations') }}
            </h2>
            <a href="{{ route('formations.create') }}" class="btn-primary">
                Nouvelle Formation
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Barre de recherche --}}
            <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100 mb-6">
                <form action="{{ route('formations.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Rechercher une formation (nom, niveau...)" 
                            class="w-full border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                            Filtrer
                        </button>
                        @if(request()->has('search'))
                            <a href="{{ route('formations.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">ID</th>
                                <th class="border-b py-2 px-4">Nom</th>
                                <th class="border-b py-2 px-4">Niveau</th>
                                <th class="border-b py-2 px-4">Durée</th>
                                <th class="border-b py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formations as $formation)
                            <tr>
                                <td class="border-b py-2 px-4">{{ $formation->id }}</td>
                                <td class="border-b py-2 px-4">{{ $formation->nom }}</td>
                                <td class="border-b py-2 px-4">{{ $formation->niveau }}</td>
                                <td class="border-b py-2 px-4">{{ $formation->duree }}</td>
                                <td class="border-b py-2 px-4 flex space-x-2">
                                    <a href="{{ route('formations.chapitres.index', $formation) }}" class="text-blue-600 hover:text-blue-900 font-medium">Chapitres</a>
                                    <a href="{{ route('formations.show', $formation) }}" class="text-green-600 hover:text-green-900 font-medium">Apprenants</a>
                                    <a href="{{ route('formations.edit', $formation) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Éditer</a>
                                    <form action="{{ route('formations.destroy', $formation) }}" method="POST" onsubmit="return confirm('Sûr de vouloir supprimer ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
