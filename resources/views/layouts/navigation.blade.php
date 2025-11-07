<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-600 to-purple-600 border-b border-indigo-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl">
                        🌟 Wellness Dance & Spa
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-indigo-200">
                        Dashboard
                    </x-nav-link>

                    @hasrole('Cliente')
                        <x-nav-link :href="route('client.classes.index')" :active="request()->routeIs('client.classes.*')" class="text-white hover:text-indigo-200">
                            💃 Clases de Baile
                        </x-nav-link>
                        <x-nav-link :href="route('client.appointments.index')" :active="request()->routeIs('client.appointments.*')" class="text-white hover:text-indigo-200">
                            💆 Spa
                        </x-nav-link>
                        <x-nav-link :href="route('client.shop.index')" :active="request()->routeIs('client.shop.*')" class="text-white hover:text-indigo-200">
                            🛍️ Tienda
                        </x-nav-link>
                    @endhasrole

                    @hasrole('Profesional')
                        <x-nav-link :href="route('professional.agenda.index')" :active="request()->routeIs('professional.*')" class="text-white hover:text-indigo-200">
                            📅 Mi Agenda
                        </x-nav-link>
                    @endhasrole

                    @hasanyrole('Super Admin|Administrador')
                        <x-nav-link href="/admin" class="text-white hover:text-indigo-200">
                            ⚙️ Panel Admin
                        </x-nav-link>
                    @endhasanyrole
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-indigo-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Mi Perfil
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-indigo-200 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                Dashboard
            </x-responsive-nav-link>
            @hasrole('Cliente')
                <x-responsive-nav-link :href="route('client.classes.index')" class="text-white">
                    💃 Clases
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.appointments.index')" class="text-white">
                    💆 Spa
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.shop.index')" class="text-white">
                    🛍️ Tienda
                </x-responsive-nav-link>
            @endhasrole
            @hasrole('Profesional')
                <x-responsive-nav-link :href="route('professional.agenda.index')" class="text-white">
                    📅 Mi Agenda
                </x-responsive-nav-link>
            @endhasrole
        </div>
        <div class="pt-4 pb-1 border-t border-indigo-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-indigo-200">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                    Mi Perfil
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
