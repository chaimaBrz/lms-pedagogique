<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                    Quiz : "{{ $quiz->titre }}"
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    <a href="{{ route('sous_chapitres.quizzes.index', $quiz->sous_chapitre_id) }}" class="hover:underline">← Retour aux quiz</a>
                    &bull; {{ $questions->count() }} question(s)
                </p>
            </div>
            <a href="{{ route('quizzes.questions.create', $quiz) }}" class="btn-primary">
                + Nouvelle Question
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($questions as $i => $question)
                <div class="card p-5">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-semibold text-slate-800 mb-3">
                                <span class="text-indigo-600 font-bold">Q{{ $i + 1 }}.</span>
                                {{ $question->question }}
                            </p>
                            <ul class="space-y-1">
                                @foreach($question->reponses as $reponse)
                                    <li class="flex items-center space-x-2 text-sm">
                                        @if($reponse->est_correcte)
                                            <span class="inline-flex items-center justify-center w-5 h-5 bg-green-500 text-white rounded-full text-xs">✓</span>
                                            <span class="font-semibold text-green-700">{{ $reponse->reponse }}</span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-5 h-5 bg-slate-200 text-slate-500 rounded-full text-xs">✗</span>
                                            <span class="text-slate-600">{{ $reponse->reponse }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="flex flex-col space-y-1 ml-6 text-sm">
                            <a href="{{ route('questions.edit', $question) }}" class="text-yellow-600 hover:text-yellow-900">Éditer</a>
                            <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Supprimer cette question ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card p-8 text-center text-slate-500">
                    Aucune question pour ce quiz. Ajoutez la première !
                </div>
            @endforelse

        </div>
    </div>
</x-admin-layout>
