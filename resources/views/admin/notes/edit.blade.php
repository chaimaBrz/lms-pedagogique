<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Modifier la note — {{ $note->apprenant->nom }} / {{ $note->matiere }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('notes.update', $note) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="apprenant_id" class="block text-gray-700 text-sm font-bold mb-2">Apprenant :</label>
                        <select name="apprenant_id" id="apprenant_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            @foreach($apprenants as $apprenant)
                                <option value="{{ $apprenant->id }}" {{ old('apprenant_id', $note->apprenant_id) == $apprenant->id ? 'selected' : '' }}>
                                    {{ $apprenant->nom }} ({{ $apprenant->formations->pluck('nom')->join(', ') ?: 'Sans formation' }})
                                </option>
                            @endforeach
                        </select>
                        @error('apprenant_id') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="matiere" class="block text-gray-700 text-sm font-bold mb-2">Matière :</label>
                        <input type="text" name="matiere" id="matiere"
                               value="{{ old('matiere', $note->matiere) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        @error('matiere') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="note" class="block text-gray-700 text-sm font-bold mb-2">
                            Note <span class="text-gray-400 font-normal">(0 – 20)</span> :
                        </label>
                        <input type="number" name="note" id="note"
                               value="{{ old('note', $note->note) }}"
                               min="0" max="20" step="0.5"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        @error('note') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn-primary">
                            Mettre à jour
                        </button>
                        <a href="{{ route('notes.index') }}" class="text-slate-600 underline">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
