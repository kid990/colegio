@php
    $navLinks = [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'active' => 'dashboard',
        ],
        [
            'name' => 'Configuración',
            'route' => 'configuracion.index',
            'active' => 'configuracion.*',
        ],
        [
            'name' => 'Gestión',
            'active' => 'gestion.*',
            'submenu' => [
                [
                    'name' => 'Lista de Gestiones',
                    'route' => 'gestion.index',
                    'active' => 'gestion.index',
                ],
                [
                    'name' => 'Crear Gestión',
                    'route' => 'gestion.create',
                    'active' => 'gestion.create',
                ],
               ]
        ],
        [
             'name'   => 'Nivel',
    'route'  => 'nivel.index',   // ✅ nombre correcto
    'active' => 'nivel.*',
        ],
    ];
@endphp

<div x-data="{ open: false }" class="contents lg:block">

    {{-- SIDEBAR ESCRITORIO (solo lg y arriba) --}}
    <nav class="bg-white dark:bg-gray-800
            text-gray-900 dark:text-gray-100
            w-64 h-screen flex-shrink-0 hidden lg:flex flex-col
            border-r border-gray-200 dark:border-gray-700">

        {{-- 1) LOGO FIJO ARRIBA --}}
        <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 px-4 shrink-0">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-900 dark:text-gray-100"/>
            </a>
        </div>

        {{-- 2) MENÚ (SOLO AQUÍ HAY SCROLL) --}}
        <div class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">

            {{-- BUCLE PARA GENERAR ENLACES DE ESCRITORIO --}}
            @foreach($navLinks as $link)
                @if(isset($link['submenu']))
                    {{-- MENÚ CON SUBMENÚ --}}
                    <div x-data="{ expanded: {{ request()->routeIs($link['active']) ? 'true' : 'false' }} }">
                        <button @click="expanded = !expanded"
                                class="flex items-center justify-between w-full px-4 py-2 rounded-md
                                       text-gray-700 dark:text-gray-300
                                       hover:bg-gray-100 dark:hover:bg-gray-700
                                       {{ request()->routeIs($link['active']) ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                            <span>{{ __($link['name']) }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200"
                                 :class="{ 'rotate-180': expanded }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- SUBMENÚ --}}
                        <div x-show="expanded"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="mt-2 ml-4 space-y-1">
                            @foreach($link['submenu'] as $sublink)
                                <x-nav-link :href="route($sublink['route'])"
                                            :active="request()->routeIs($sublink['active'])"
                                            class="flex items-center w-full px-4 py-2 rounded-md text-sm">
                                    {{ __($sublink['name']) }}
                                </x-nav-link>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- MENÚ SIMPLE (sin submenú) --}}
                    <x-nav-link :href="route($link['route'])"
                                :active="request()->routeIs($link['active'])"
                                class="flex items-center w-full px-4 py-2 rounded-md">
                        {{ __($link['name']) }}
                    </x-nav-link>
                @endif
            @endforeach

        </div>

        {{-- 3) PERFIL FIJO ABAJO --}}
        <div class="border-t border-gray-200 dark:border-gray-700
                    px-4 py-3 bg-white dark:bg-gray-800 shrink-0">

            <x-dropdown align="left" width="48" position="top">
                <x-slot name="trigger">
                    <button class="flex items-center w-full px-3 py-2 text-sm font-medium
                                   text-gray-600 dark:text-gray-300
                                   bg-white dark:bg-gray-800
                                   hover:text-gray-900 dark:hover:text-gray-100
                                   hover:bg-gray-100 dark:hover:bg-gray-700
                                   rounded-md focus:outline-none transition">

                        <div class="flex-1 text-left truncate">{{ Auth::user()->name }}</div>

                        <svg class="fill-current h-4 w-4 ms-2"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault();
                                                  this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

        </div>
    </nav>

    {{-- NAVEGACIÓN MÓVIL (sm–md, lg usa sidebar de arriba) --}}
    <div class="lg:hidden">
        {{-- Barra fija arriba en móvil --}}
        <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700
                    h-16 flex items-center justify-between px-4 fixed top-0 left-0 right-0 z-40">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
            </a>
            <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md
                           text-gray-400 dark:text-gray-500
                           hover:text-gray-500 dark:hover:text-gray-400
                           hover:bg-gray-100 dark:hover:bg-gray-900
                           focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}"
                          class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}"
                          class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Espaciador para compensar la barra fija --}}
        <div class="h-16"></div>

        {{-- Overlay --}}
        <div x-show="open"
             x-transition:enter="transition-opacity duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 bg-black bg-opacity-50 z-40"
             x-cloak></div>

        {{-- Sidebar móvil deslizable --}}
        <div x-show="open"
             x-transition:enter="transform transition-transform duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition-transform duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 left-0 bottom-0 w-64 bg-white dark:bg-gray-800 z-50 flex flex-col shadow-xl"
             x-cloak>

            {{-- Logo móvil --}}
            <div class="h-16 flex items-center justify-center border-b border-gray-100 dark:border-gray-700 px-4">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                </a>
            </div>

            {{-- Links móviles --}}
            <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                {{-- BUCLE PARA GENERAR ENLACES MÓVILES --}}
                @foreach($navLinks as $link)
                    @if(isset($link['submenu']))
                        {{-- MENÚ MÓVIL CON SUBMENÚ --}}
                        <div x-data="{ expanded: {{ request()->routeIs($link['active']) ? 'true' : 'false' }} }">
                            <button @click="expanded = !expanded"
                                    class="flex items-center justify-between w-full px-3 py-2 rounded-md
                                           text-gray-700 dark:text-gray-300
                                           hover:bg-gray-100 dark:hover:bg-gray-700
                                           {{ request()->routeIs($link['active']) ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                                <span>{{ __($link['name']) }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{ 'rotate-180': expanded }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- SUBMENÚ MÓVIL --}}
                            <div x-show="expanded"
                                 x-transition
                                 class="mt-2 ml-4 space-y-1">
                                @foreach($link['submenu'] as $sublink)
                                    <x-responsive-nav-link :href="route($sublink['route'])"
                                                           :active="request()->routeIs($sublink['active'])"
                                                           class="text-sm">
                                        {{ __($sublink['name']) }}
                                    </x-responsive-nav-link>
                                @endforeach
                            </div>
                        </div>
                    @else
                        {{-- MENÚ MÓVIL SIMPLE --}}
                        <x-responsive-nav-link :href="route($link['route'])"
                                               :active="request()->routeIs($link['active'])">
                            {{ __($link['name']) }}
                        </x-responsive-nav-link>
                    @endif
                @endforeach

            </div>

            {{-- Perfil móvil --}}
            <div class="border-t border-gray-200 dark:border-gray-600 p-4">
                <div class="px-4 mb-3">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
