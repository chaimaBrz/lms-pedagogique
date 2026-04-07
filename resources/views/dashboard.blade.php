<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="">
                    @if(auth()->user()->role === 'admin')
                        <p class="mb-4">Bonjour Admin ! Bienvenue sur l'espace d'administration.</p>
                        <div class="flex space-x-3">
                            <a href="{{ route('formations.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-5 rounded">
                                → Gérer les formations
                            </a>
                            <a href="{{ route('notes.index') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-5 rounded">
                                → Gérer les notes
                            </a>
                            <a href="{{ route('apprenants.index') }}" class="bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-5 rounded">
                                → Voir les apprenants
                            </a>
                        </div>
                    @else
                        <p class="mb-4">Bonjour ! Tu vas être redirigé vers ton espace apprenant…</p>
                        <a href="{{ route('apprenant.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-5 rounded">
                            → Mon espace apprenant
                        </a>
                        <script>
                            // Redirection automatique vers l'espace apprenant
                            setTimeout(() => window.location.href = "{{ route('apprenant.dashboard') }}", 800);
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
