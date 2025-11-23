<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar - Solo visible en lg y arriba --}}
    @include('layouts.navigation')

    {{-- Contenedor principal --}}
    <div class="flex-1 flex flex-col h-full w-full">

        {{-- Header (opcional) --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow z-10
                           mt-16 lg:mt-0"> {{-- mt-16 compensa la barra móvil --}}
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Contenido con scroll independiente --}}
        <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6
                     pt-2 lg:pt-2"> {{-- pt-20 compensa la barra móvil cuando no hay header --}}
            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>
