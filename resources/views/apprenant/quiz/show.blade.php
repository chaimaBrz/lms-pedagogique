<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ $quiz->titre }}</h2>
            <p class="text-sm text-slate-500 mt-1">
                {{ $questions->count() }} question(s)
                @if($resultat)
                    · Dernier score : <strong>{{ $resultat->score }} / {{ $questions->count() }}</strong>
                @endif
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if($resultat)
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg px-5 py-3 flex justify-between items-center">
                    <p>Tu as déjà passé ce quiz. Score précédent : <strong>{{ $resultat->score }} / {{ $questions->count() }}</strong></p>
                    <span class="text-sm text-blue-500">Tu peux recommencer ↓</span>
                </div>
            @endif

            <form action="{{ route('apprenant.quiz.submit', $quiz) }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded">
                        Veuillez répondre à toutes les questions.
                    </div>
                @endif

                <div class="space-y-6">
                    @foreach($questions as $i => $question)
                        <div class="card p-5">
                            <p class="font-semibold text-slate-800 mb-4">
                                <span class="text-indigo-600">Q{{ $i + 1 }}.</span>
                                {{ $question->question }}
                            </p>

                            @error("reponses.{$question->id}")
                                <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                            @enderror

                            <div class="space-y-2">
                                @foreach($question->reponses as $reponse)
                                    <label class="flex items-center space-x-3 p-3 rounded-lg border cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition
                                        {{ old("reponses.{$question->id}") == $reponse->id ? 'bg-indigo-50 border-indigo-400' : '' }}">
                                        <input type="radio"
                                               name="reponses[{{ $question->id }}]"
                                               value="{{ $reponse->id }}"
                                               class="w-4 h-4 text-indigo-600"
                                               {{ old("reponses.{$question->id}") == $reponse->id ? 'checked' : '' }}>
                                        <span class="text-gray-700">{{ $reponse->reponse }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('apprenant.cours.contenus', $quiz->sous_chapitre_id) }}" class="text-slate-500 hover:text-gray-700 text-sm">← Retour au contenu</a>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-8 rounded-lg text-lg">
                        Valider mes réponses
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
