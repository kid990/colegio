<x-app-layout>

    {{-- HEADER --}}

    <x-header>
        Periodos
    </x-header>

    {{--  --}}

    <div class="max-w-7xl mx-auto py-2">

        <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Lista de periodos
            </h2>

            <div class="mb-3">

                <x-primary-button type="button" x-data x-on:click="$dispatch('open-modal','crear-periodo')">
                    {{ __('Nuevo Periodo') }}
                </x-primary-button>

            </div>

            {{-- TABLA --}}
            <div class="max-w-4xl overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
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
                                Gestion
                            </th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($periodos as $periodo)
                            <tr>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $periodo->id }}
                                </td>

                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $periodo->nombre }}
                                </td>

                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $periodo->gestion->nombre }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        {{-- EDITAR: modal editar-nivel-{{ $nivel->id }} --}}
                                        <x-secondary-button type="button" x-data
                                            x-on:click="$dispatch('open-modal', 'editar-periodo-{{ $periodo->id }}')">
                                            {{ __('Editar') }}
                                        </x-secondary-button>

                                        {{-- ELIMINAR --}}
                                        <x-delete-button :route="route('periodo.destroy', $periodo->id)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-paginacion :data="$periodos" />


        </div>




    </div>


    {{-- MODAL CREAR NIVEL --}}
    <x-modal name="crear-periodo" :show="false" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Crear periodo') }}
            </h2>

            <form method="POST" action="{{ route('periodo.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <x-input-label for="nombre_nuevo" :value="__('Nombre')" />
                        <x-text-input id="nombre_nuevo" name="nombre" type="text" class="block w-full mt-1"
                            :value="old('nombre')" autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>
                    <div>
                        <x-input-label for="gestion_nuevo" :value="__('Gestion')" />
                        <select name="gestion_id" id="gestion_nuevo" class="block w-full mt-1">
                            @foreach ($gestiones as $gestion)
                                <option value="{{ $gestion->id }}">{{ $gestion->nombre }}</option>
                            @endforeach
                            <select/>
                            <x-input-error class="mt-2" :messages="$errors->get('gestion_id')" />
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <x-secondary-button type="button" @click="$dispatch('close')">
                            {{ __('Cancelar') }}
                        </x-secondary-button>

                        <x-primary-button>
                            {{ __('Guardar') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </x-modal>


    {{-- MODALES EDITAR POR CADA NIVEL --}}
    @foreach ($periodos as $periodo)
        <x-modal name="editar-periodo-{{ $periodo->id }}" :show="false" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Editar periodo') }}
                </h2>

                <form method="POST" action="{{ route('periodo.update', $periodo->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nombre_{{ $periodo->id }}" :value="__('Nombre')" />
                            <x-text-input id="nombre_{{ $periodo->id }}" name="nombre" type="text"
                                class="block w-full mt-1" :value='$periodo->nombre' autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <x-secondary-button type="button" @click="$dispatch('close')">
                                {{ __('Cancelar') }}
                            </x-secondary-button>

                            <x-primary-button>
                                {{ __('Actualizar') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach





</x-app-layout>
