<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LMS Admin') }} - Administration</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js pour les menus -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
            
            {{-- ─── Sidebar Gauche (Mobile: Caché par défaut, Desktop: Fixe) ─── --}}
            <aside class="bg-slate-900 w-64 flex-shrink-0 fixed inset-y-0 left-0 transform transition-transform duration-300 z-50 lg:translate-x-0 lg:static lg:flex flex-col border-r border-slate-800"
                   :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
                
                {{-- Entête Sidebar (Logo) --}}
                <div class="h-16 flex items-center px-6 bg-slate-950 border-b border-slate-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-white font-bold text-xl tracking-wide">
                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        LMS Admin
                    </a>
                </div>

                {{-- Liens Navigation --}}
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('formations.index')" :active="request()->routeIs('formations.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Formations
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('apprenants.index')" :active="request()->routeIs('apprenants.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Apprenants
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('notes.index')" :active="request()->routeIs('notes.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Notes
                    </x-sidebar-link>

                    <div class="pt-4 mt-4 border-t border-slate-800">
                        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Automatisations</p>
                        <x-sidebar-link :href="route('assistant.ia')" :active="request()->routeIs('assistant.ia*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Assistant IA
                        </x-sidebar-link>
                    </div>
                </nav>

                {{-- Footer Sidebar (Profil Utilisateur) --}}
                <div class="h-20 bg-slate-950 p-4 border-t border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold z-10 shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="truncate">
                            <p class="text-sm font-semibold text-slate-200 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">Administrateur</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" title="Déconnexion">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-white transition p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </aside>

            {{-- ─── Contenu Principal ─── --}}
            <div class="flex-1 flex flex-col min-w-0" :class="{'lg:ml-64': false}">
                
                {{-- Barre supérieure (Mobile Toggle + Titre) --}}
                <header class="h-16 bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/60 shadow-sm flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 focus:outline-none lg:hidden mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>
                </header>

                {{-- Zone de contenu --}}
                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
            
            {{-- Overlay Mobile --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden" style="display: none;"></div>
        </div>
    </body>
</html>
