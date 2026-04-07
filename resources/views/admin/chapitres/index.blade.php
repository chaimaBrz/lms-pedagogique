<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                Chapitres de la formation : {{ $formation->nom }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('formations.index') }}" class="btn-secondary">Retour aux formations</a>
                <a href="{{ route('formations.chapitres.create', $formation) }}" class="btn-primary">Nouveau Chapitre</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2 px-4">Ordre/ID</th>
                                <th class="border-b py-2 px-4">Titre</th>
                                <th class="border-b py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chapitres as $chapitre)
                            <tr>
                                <td class="border-b py-2 px-4">{{ $chapitre->id }}</td>
                                <td class="border-b py-2 px-4">{{ $chapitre->titre }}</td>
                                <td class="border-b py-2 px-4 flex space-x-2">
                                    <a href="{{ route('chapitres.sous_chapitres.index', $chapitre) }}" class="text-blue-600 hover:text-blue-900">Sous-chapitres</a>
                                    <a href="{{ route('chapitres.edit', $chapitre) }}" class="text-yellow-600 hover:text-yellow-900">Éditer</a>
                                    <form action="{{ route('chapitres.destroy', $chapitre) }}" method="POST" onsubmit="return confirm('Sûr de vouloir supprimer ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-slate-500">Aucun chapitre trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
