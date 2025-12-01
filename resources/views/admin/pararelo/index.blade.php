<x-app-layout>

    {{-- HEADER --}}

    <x-header>
        Pararelos
    </x-header>

    {{--  --}}

    <div class="max-w-7xl mx-auto py-2">

        <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Lista de paralelos
            </h2>

            <div class="mb-3">

                <x-primary-button type="button" x-data x-on:click="$dispatch('open-modal','crear')">
                    {{ __('Nuevo') }}
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
                                Grado
                            </th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($pararelos as $pararelo)
                            <tr>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $pararelo->id }}
                                </td>

                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $pararelo->nombre }}
                                </td>

                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $pararelo->grado->nombre }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        {{-- EDITAR: modal editar-nivel-{{ $nivel->id }} --}}
                                        <x-secondary-button type="button" x-data
                                            x-on:click="$dispatch('open-modal', 'editar-{{ $pararelo->id }}')">
                                            {{ __('Editar') }}
                                        </x-secondary-button>

                                        {{-- ELIMINAR --}}
                                        <x-delete-button :route="route('pararelos.destroy', $pararelo->id)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-paginacion :data="$pararelos" />


        </div>




    </div>


    {{-- MODAL CREAR NIVEL --}}
    <x-modal name="crear" :show="false" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Crear periodo') }}
            </h2>

            <form method="POST" action="{{ route('pararelos.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <x-input-label for="nombre_nuevo" :value="__('Nombre')" />
                        <x-text-input id="nombre_nuevo" name="nombre" type="text" class="block w-full mt-1"
                            :value="old('nombre')" autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>
                    <div>
                        <x-input-label for="grado_nuevo" :value="__('Grado')" />
                        <select name="grado_id" id="grado_nuevo" class="block w-full mt-1">
                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
                            @endforeach
                        </select>
                            <x-input-error class="mt-2" :messages="$errors->get('grado_id')" />
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
    @foreach ($pararelos as $pararelo)
        <x-modal name="editar-{{ $pararelo->id }}" :show="false" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Editar ') }}
                </h2>

                <form method="POST" action="{{ route('pararelos.update', $pararelo->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" name="nombre" type="text"
                                class="block w-full mt-1" :value='$pararelo->nombre' autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div>
                            <x-input-label for="grado_id" :value="__('Grado')" />
                            <select name="grado_id" id="grado_id" class="block w-full mt-1">
                                @foreach ($grados as $grado)
                                    <option
                                     value="{{ $grado->id }}" 
                                     {{ $pararelo->grado_id == $grado->id ? 'selected' : '' }}>
                                     
                                     {{ $grado->nombre }}
                                    </option>
                                @endforeach

                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('grado_id')" />
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
