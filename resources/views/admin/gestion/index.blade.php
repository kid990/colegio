<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestiones') }}
            </h2>
        </div>
    </x-slot>

    {{-- CONTENIDO PRINCIPAL --}}

    <div class="max-w-7xl mx-auto py-2 ">
        <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg">

            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lista de Gestiones</h2>

            {{-- Botón NUEVO --}}
            <div class="mb-3"> {{-- opcional: antes mb-4, un poco más compacto --}}
                <x-nuevo-link :route="route('gestion.create')" />
            </div>

            {{-- TABLA --}}
            <div class=" max-w-4xl overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            ID
                        </th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Nombre
                        </th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Acciones
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($gestiones as $gestion)
                        <tr>
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                {{ $gestion->id }}
                            </td>

                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                {{ $gestion->nombre }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <x-edit-button :route="route('gestion.edit', $gestion->id)" />
                                    <x-delete-button :route="route('gestion.destroy', $gestion->id)" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            @if(method_exists($gestiones, 'links'))
                <div class="mt-3"> {{-- opcional: antes mt-4 --}}
                    {{ $gestiones->links() }}
                </div>
            @endif

        </div>

    </div>




</x-app-layout>
