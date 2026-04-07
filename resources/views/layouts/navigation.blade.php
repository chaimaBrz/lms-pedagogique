<nav x-data="{ open: false }" class="bg-white/70 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200/50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[72px]">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="transition-transform hover:scale-105 active:scale-95 duration-200">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <!-- Navigation Links (Adaptatifs sur Desktop) -->
                <div class="hidden space-x-2 sm:ms-10 sm:flex items-center">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-btn {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                🚀 Dashboard
                            </a>
                            <a href="{{ route('formations.index') }}" class="nav-btn {{ request()->routeIs('formations.*') ? 'active' : '' }}">
                                📚 Formations
                            </a>
                            <a href="{{ route('apprenants.index') }}" class="nav-btn {{ request()->routeIs('apprenants.*') ? 'active' : '' }}">
                                👥 Apprenants
                            </a>
                            <a href="{{ route('notes.index') }}" class="nav-btn {{ request()->routeIs('notes.*') ? 'active' : '' }}">
                                📝 Notes
                            </a>
                            <a href="{{ route('assistant.ia') }}" class="nav-btn {{ request()->routeIs('assistant.ia*') ? 'active' : '' }}">
                                🤖 Assistant IA
                            </a>
                        @else
                            <a href="{{ route('apprenant.dashboard') }}" class="nav-btn {{ request()->routeIs('apprenant.dashboard') ? 'active' : '' }}">
                                🏠 Mon espace
                            </a>
                            <a href="{{ route('apprenant.resultats') }}" class="nav-btn {{ request()->routeIs('apprenant.resultats') ? 'active' : '' }}">
                                🎓 Mes résultats
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 bg-slate-100/50 hover:bg-slate-100 rounded-2xl text-sm font-semibold text-slate-700 transition duration-150 ease-in-out border border-transparent hover:border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-primary-600 flex items-center justify-center text-white text-[10px]">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2 space-y-1">
                            <x-dropdown-link :href="route('profile.edit')" class="rounded-lg">
                                ⚙️ {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="rounded-lg text-red-600 hover:bg-red-50"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-slate-500 hover:bg-slate-100 transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">🚀 Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('formations.index')" :active="request()->routeIs('formations.*')">📚 Formations</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('apprenants.index')" :active="request()->routeIs('apprenants.*')">👥 Apprenants</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('notes.index')" :active="request()->routeIs('notes.*')">📝 Notes</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('assistant.ia')" :active="request()->routeIs('assistant.ia*')">🤖 IA Assistant</x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('apprenant.dashboard')" :active="request()->routeIs('apprenant.dashboard')">🏠 Mon espace</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('apprenant.resultats')" :active="request()->routeIs('apprenant.resultats')">📊 Résultats</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-slate-100 bg-slate-50/50">
            <div class="px-6 flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white text-lg font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')">⚙️ {{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-red-600"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        🚪 {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

