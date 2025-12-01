<x-app-layout>

    {{-- HEADER --}}
    <x-header>
            Materias
        </x-header>


    {{-- CONTENIDO PRINCIPAL --}}
    <div class="max-w-7xl mx-auto py-2">
        <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg">

            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Lista de materias
            </h2>

            {{-- Botón NUEVO (abre modal crear-nivel) --}}
            <div class="mb-3">
                <x-primary-button
                    type="button"
                    x-data
                    x-on:click="$dispatch('open-modal', 'crear')"
                >
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
                            Acciones
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($materias as $materia)
                        <tr>
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                {{ $materia->id }}
                            </td>

                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                {{ $materia->nombre }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    {{-- EDITAR: modal editar-nivel-{{ $nivel->id }} --}}
                                    <x-secondary-button
                                        type="button"
                                        x-data
                                        x-on:click="$dispatch('open-modal', 'editar-{{ $materia->id }}')"
                                    >
                                        {{ __('Editar') }}
                                    </x-secondary-button>

                                    {{-- ELIMINAR --}}
                                    <x-delete-button :route="route('materias.destroy', $materia->id)" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

   <x-paginacion :data="$materias" />

        </div>
    </div>

    {{-- MODAL CREAR NIVEL --}}
    <x-modal name="crear" :show="false" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Crear Materia') }}
            </h2>

            <form method="POST" action="{{ route('materias.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <x-input-label for="nombre_nuevo" :value="__('Nombre')" />
                        <x-text-input
                            id="nombre_nuevo"
                            name="nombre"
                            type="text"
                            class="block w-full mt-1"
                            :value="old('nombre')"
                            autocomplete="off"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <x-secondary-button
                            type="button"
                            @click="$dispatch('close')"

                        >
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
    @foreach($materias as $m)
        <x-modal name="editar-{{ $m->id }}" :show="false" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Editar Materia') }} #{{ $m->id }}
                </h2>

                <form method="POST" action="{{ route('materias.update', $m->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input
                                id="nombre"
                                name="nombre"
                                type="text"
                                class="block w-full mt-1"
                                :value="$m->nombre ?? ''"
                                autocomplete="off"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <x-secondary-button
                                type="button"
                                @click="$dispatch('close')"

                            >
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
