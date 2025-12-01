<x-app-layout>

    {{-- HEADER --}}

    <x-header>
        Grados
    </x-header>

    {{--  --}}

    <div class="max-w-7xl mx-auto py-2">

        <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Lista de registro de grados
            </h2>

            <div class="mb-3">

                <x-primary-button type="button" x-data x-on:click="$dispatch('open-modal','crear')">
                    {{ __('Nuevo Grado') }}
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
                                Nivel
                            </th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($grados as $grado)
                            <tr>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $grado->id }}
                                </td>

                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $grado->nombre }}
                                </td>

                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                    {{ $grado->nivel->nombre }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        {{-- EDITAR: modal editar-nivel-{{ $nivel->id }} --}}
                                        <x-secondary-button type="button" x-data
                                            x-on:click="$dispatch('open-modal', 'editar-{{ $grado->id }}')">
                                            {{ __('Editar') }}
                                        </x-secondary-button>

                                        {{-- ELIMINAR --}}
                                        <x-delete-button :route="route('grados.destroy', $grado->id)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-paginacion :data="$grados" />


        </div>




    </div>


    {{-- MODAL CREAR NIVEL --}}
    <x-modal name="crear" :show="false" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Crear grado') }}
            </h2>

            <form method="POST" action="{{ route('grados.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <x-input-label for="nombre_nuevo" :value="__('Nombre')" />
                        <x-text-input id="nombre_nuevo" name="nombre" type="text" class="block w-full mt-1"
                            :value="old('nombre')" autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>
                    <div>
                        <x-input-label for="nivel_nuevo" :value="__('Nivel')" />
                        <select name="nivel_id" id="nivel_nuevo" class="block w-full mt-1">
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('nivel_id')" />
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
    @foreach ($grados as $grado)
        <x-modal name="editar-{{ $grado->id }}" :show="false" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Editar grado') }}
                </h2>

                <form method="POST" action="{{ route('grados.update', $grado->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" name="nombre" type="text"
                                class="block w-full mt-1" :value='$grado->nombre' autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div>
                            <x-input-label for="nivel" :value="__('Nivel')" />
                            <select name="nivel_id" id="nivel" class="block w-full mt-1">
                                @foreach ($niveles as $nivel)
                                    <option
                                     value="{{ $nivel->id }}" 
                                     @selected($grado->nivel_id == $nivel->id)
                                     >
                                     {{ $nivel->nombre }}
                                     
                                    </option>
                                @endforeach

                                <select/>
                                <x-input-error class="mt-2" :messages="$errors->get('nivel_id')" />
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
