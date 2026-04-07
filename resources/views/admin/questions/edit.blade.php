<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Éditer la Question
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('questions.update', $question) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Intitulé --}}
                    <div class="mb-6">
                        <label for="question" class="block text-gray-700 text-sm font-bold mb-2">
                            Intitulé de la question :
                        </label>
                        <input type="text" name="question" id="question"
                               value="{{ old('question', $question->question) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        @error('question') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- 4 réponses avec pré-remplissage --}}
                    <div class="mb-6">
                        <p class="text-gray-700 text-sm font-bold mb-3">
                            Réponses <span class="text-gray-400 font-normal">(cochez la bonne réponse)</span> :
                        </p>

                        @php
                            $reponses = $question->reponses()->orderBy('id')->get();
                            $bonneIndex = $reponses->search(fn($r) => $r->est_correcte);
                        @endphp

                        <div class="space-y-3">
                            @for($i = 0; $i < 4; $i++)
                                @php
                                    $rep = $reponses[$i] ?? null;
                                    $isCorrect = old('bonne_reponse') !== null
                                        ? old('bonne_reponse') == $i
                                        : ($bonneIndex === $i);
                                @endphp
                                <div class="flex items-center space-x-3 border rounded-lg p-3 {{ $isCorrect ? 'bg-green-50 border-green-300' : 'bg-slate-50' }}">
                                    <input type="radio" name="bonne_reponse" id="bonne_{{ $i }}" value="{{ $i }}"
                                           class="w-4 h-4 text-green-600"
                                           {{ $isCorrect ? 'checked' : '' }}>
                                    <label for="bonne_{{ $i }}" class="text-sm text-slate-600 font-medium w-12 shrink-0">
                                        Réponse {{ $i + 1 }} :
                                    </label>
                                    <input type="text" name="reponses[{{ $i }}]"
                                           value="{{ old("reponses.$i", $rep?->reponse ?? '') }}"
                                           class="flex-1 border border-slate-300 rounded py-1 px-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-indigo-400"
                                           placeholder="Texte de la réponse {{ $i + 1 }}" required>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">
                            Mettre à jour
                        </button>
                        <a href="{{ route('quizzes.questions.index', $question->quiz_id) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
