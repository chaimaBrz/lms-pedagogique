<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Gestion des Notes</h2>
            <a href="{{ route('notes.create') }}" class="btn-primary">
                + Nouvelle Note
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Barre de recherche --}}
            <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100">
                <form action="{{ route('notes.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Chercher un élève pour voir ses notes..." 
                            class="w-full border-slate-200 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                            Rechercher
                        </button>
                        @if(request()->has('search'))
                            <a href="{{ route('notes.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @forelse($apprenants as $apprenant)
                <div class="card overflow-hidden">
                    {{-- En-tête de l'apprenant --}}
                    <div class="flex items-center justify-between px-6 py-4 bg-slate-50 border-b">
                        <div>
                            <p class="font-bold text-slate-800">{{ $apprenant->nom }}</p>
                            <p class="text-xs text-slate-500">
                                {{ $apprenant->email }} — 
                                <span class="font-bold">Formations :</span>
                                @forelse($apprenant->formations as $formation)
                                    <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-indigo-100">
                                        {{ $formation->nom }}
                                    </span>
                                @empty
                                    <span class="text-slate-400 italic font-normal">Aucune</span>
                                @endforelse
                            </p>
                        </div>
                        @php $moyenne = $apprenant->notes->avg('note'); @endphp
                        @if($apprenant->notes->isNotEmpty())
                            <span class="text-sm font-semibold px-3 py-1 rounded-full
                                {{ $moyenne >= 14 ? 'bg-green-100 text-green-700' : ($moyenne >= 10 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                Moyenne : {{ number_format($moyenne, 2) }} / 20
                            </span>
                        @endif
                    </div>

                    {{-- Notes --}}
                    <div class="p-4">
                        @if($apprenant->notes->isEmpty())
                            <p class="text-gray-400 text-sm text-center py-2">Aucune note enregistrée.</p>
                        @else
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="text-slate-500 uppercase text-xs">
                                        <th class="py-2 px-3">Matière</th>
                                        <th class="py-2 px-3">Note</th>
                                        <th class="py-2 px-3">Date</th>
                                        <th class="py-2 px-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($apprenant->notes as $note)
                                        <tr class="border-t">
                                            <td class="py-2 px-3 font-medium text-gray-700">{{ $note->matiere }}</td>
                                            <td class="py-2 px-3">
                                                <span class="font-bold {{ $note->note >= 14 ? 'text-green-600' : ($note->note >= 10 ? 'text-yellow-600' : 'text-red-600') }}">
                                                    {{ number_format($note->note, 2) }} / 20
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 text-gray-400">{{ $note->created_at->format('d/m/Y') }}</td>
                                            <td class="py-2 px-3 flex space-x-3">
                                                <a href="{{ route('notes.edit', $note) }}" class="text-yellow-600 hover:text-yellow-900">Éditer</a>
                                                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Supprimer cette note ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card p-8 text-center text-slate-500">
                    Aucun apprenant enregistré.
                </div>
            @endforelse

        </div>
    </div>
</x-admin-layout>
