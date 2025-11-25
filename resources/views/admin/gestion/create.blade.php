<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Gestión') }}
            </h2>
        </div>
    </x-slot>

    {{-- CONTENEDOR EXTERNO (AJUSTADO) --}}

        <div class="max-w-7xl mx-auto py-2 ">

            <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4 dark:border-gray-700">
                    {{ __('Crear un nuevo registro') }}
                </h2>

                <form action="{{ route('gestion.store') }}" method="POST"  class="max-w-xl">
                    @csrf
                    @method('POST')

                    <div class="space-y-5">

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input
                                id="nombre"
                                name="nombre"
                                type="text"
                                class="block w-full mt-1"
                                :value="old('nombre')"
                                autocomplete="nombre"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <x-primary-button>
                            {{ __('Guardar') }}
                        </x-primary-button>

                    </div>
                </form>
            </div>

        </div>


</x-app-layout>
