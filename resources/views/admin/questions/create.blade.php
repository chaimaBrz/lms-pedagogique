<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Nouvelle Question — Quiz : "{{ $quiz->titre }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('quizzes.questions.store', $quiz) }}" method="POST">
                    @csrf

                    {{-- Intitulé de la question --}}
                    <div class="mb-6">
                        <label for="question" class="block text-gray-700 text-sm font-bold mb-2">
                            Intitulé de la question :
                        </label>
                        <input type="text" name="question" id="question" value="{{ old('question') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                               placeholder="Ex : Quel est le prétérit de GO ?" required>
                        @error('question') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- 4 réponses + bouton radio --}}
                    <div class="mb-6">
                        <p class="text-gray-700 text-sm font-bold mb-3">
                            Réponses <span class="text-gray-400 font-normal">(cochez la bonne réponse)</span> :
                        </p>

                        @if($errors->has('bonne_reponse'))
                            <p class="text-red-500 text-xs italic mb-2">{{ $errors->first('bonne_reponse') }}</p>
                        @endif

                        <div class="space-y-3">
                            @for($i = 0; $i < 4; $i++)
                                <div class="flex items-center space-x-3 border rounded-lg p-3 {{ old('bonne_reponse') == $i ? 'bg-green-50 border-green-300' : 'bg-slate-50' }}">
                                    <input type="radio" name="bonne_reponse" id="bonne_{{ $i }}" value="{{ $i }}"
                                           class="w-4 h-4 text-green-600"
                                           {{ old('bonne_reponse') == $i ? 'checked' : '' }}>
                                    <label for="bonne_{{ $i }}" class="text-sm text-slate-600 font-medium w-12 shrink-0">
                                        Réponse {{ $i + 1 }} :
                                    </label>
                                    <input type="text" name="reponses[{{ $i }}]" value="{{ old("reponses.$i") }}"
                                           class="flex-1 border border-slate-300 rounded py-1 px-2 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-indigo-400"
                                           placeholder="Texte de la réponse {{ $i + 1 }}" required>
                                    @error("reponses.$i") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">
                            Ajouter la question
                        </button>
                        <a href="{{ route('quizzes.questions.index', $quiz) }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
