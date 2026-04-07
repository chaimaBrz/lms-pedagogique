<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                    Quiz du sous-chapitre : "{{ $sous_chapitre->titre }}"
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
                <a href="{{ route('sous_chapitres.quizzes.create', $sous_chapitre) }}" class="btn-primary">
                    + Nouveau Quiz
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="p-6">
                    @forelse($quizzes as $quiz)
                        <div class="border rounded-lg p-4 mb-4 flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold text-slate-800">{{ $quiz->titre }}</h3>
                                <p class="text-sm text-slate-500">{{ $quiz->questions->count() }} question(s)</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('quizzes.questions.index', $quiz) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white text-sm font-bold py-1 px-3 rounded">
                                    Questions
                                </a>
                                <a href="{{ route('quizzes.edit', $quiz) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Éditer</a>
                                <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Supprimer ce quiz et toutes ses questions ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-slate-500 py-8">Aucun quiz pour ce sous-chapitre.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
