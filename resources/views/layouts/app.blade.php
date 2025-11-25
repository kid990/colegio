<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    @include('layouts.navigation')

    <div class="flex-1 flex flex-col h-full w-full">

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow z-10 mt-16 lg:mt-0">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6 pt-4 lg:pt-6">
            @if(session('success'))
                <div x-data x-init="
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6'
                    })
                "></div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>
