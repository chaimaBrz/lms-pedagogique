<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                👥 Gestion des Apprenants : {{ $formation->nom }}
            </h2>
            <a href="{{ route('formations.index') }}" class="btn-secondary">
                ← Retour aux formations
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Panneau d'inscription --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="card p-6 bg-white shadow-sm border-t-4 border-green-500">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Inscrire un élève</h3>
                        
                        <form action="{{ route('formations.enroll', $formation) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Sélectionner un apprenant :</label>
                                <select name="apprenant_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                                    <option value="">-- Choisir dans le LMS --</option>
                                    @foreach($eligibleApprenants as $eligible)
                                        <option value="{{ $eligible->id }}">{{ $eligible->nom }} ({{ $eligible->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition @if($eligibleApprenants->isEmpty()) opacity-50 cursor-not-allowed @endif" @if($eligibleApprenants->isEmpty()) disabled @endif>
                                Ajouter à la formation
                            </button>
                        </form>

                        @if($eligibleApprenants->isEmpty())
                            <p class="mt-4 text-sm text-slate-500 italic text-center">
                                Tous les apprenants du système sont déjà inscrits.
                            </p>
                        @endif
                    </div>

                    <div class="p-4 bg-slate-50 border rounded-lg text-sm text-slate-600">
                        <p>💡 <strong>Note :</strong> Les élèves listés ici sont ceux déjà créés dans votre base globale. Si vous ne trouvez pas un élève, créez son compte d'abord dans l'onglet "Apprenants".</p>
                    </div>
                </div>

                {{-- Liste des inscrits --}}
                <div class="lg:col-span-2">
                    <div class="card overflow-hidden bg-white shadow-sm">
                        <div class="p-4 border-b bg-slate-50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-700">Apprenants inscrits à ce cours ({{ $formation->apprenants->count() }})</h3>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b">
                                    <tr>
                                        <th class="py-3 px-6">Nom</th>
                                        <th class="py-3 px-6">Email</th>
                                        <th class="py-3 px-6 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-sm">
                                    @forelse($formation->apprenants as $apprenant)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="py-4 px-6 font-semibold text-slate-700">{{ $apprenant->nom }}</td>
                                            <td class="py-4 px-6 text-slate-500">{{ $apprenant->email }}</td>
                                            <td class="py-4 px-6 text-right">
                                                <form action="{{ route('formations.unenroll', [$formation, $apprenant]) }}" method="POST" onsubmit="return confirm('Retirer cet élève de cette formation ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-tighter">
                                                        Désinscrire
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-12 text-center text-slate-400 italic">
                                                Aucun apprenant n'est inscrit à cette formation pour le moment.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
