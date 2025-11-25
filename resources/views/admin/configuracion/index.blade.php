<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Configuración del Sistema') }}
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- EXTERIOR AJUSTADO --}}

        <div class="max-w-7xl mx-auto py-2 "> {{-- Antes sin padding --}}

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 overflow-hidden">

                {{-- Header --}}
                <div class="p-5 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Información de Configuración') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Actualice la información básica de la institución y el logotipo.') }}
                    </p>
                </div>

                {{-- Form --}}
                <form method="post" action="{{route('config.store')}}" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf
                    @method('post')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {{-- Columna 1 - Logo --}}
                        <div class="space-y-5">
                            <div x-data="{ photoPreview: null }">
                                <x-input-label for="logo" :value="__('Logo Institucional')" />

                                <div class="mt-4 flex flex-col items-center gap-4">
                                    <div class="flex-shrink-0">
                                        <img
                                            x-show="!photoPreview"
                                            src="{{ isset($configuracion->logo) && $configuracion->logo ? asset('storage/' . $configuracion->logo) : asset('') }}"
                                            alt="Logo actual"
                                            class="h-40 w-40 rounded-lg object-cover border border-gray-300 dark:border-gray-600"
                                        >
                                        <img
                                            x-show="photoPreview"
                                            :src="photoPreview"
                                            alt="Vista previa"
                                            class="h-40 w-40 rounded-lg object-cover border border-gray-300 dark:border-gray-600"
                                            style="display: none;"
                                        >
                                    </div>

                                    <div class="text-center">
                                        <input
                                            type="file"
                                            id="logo"
                                            name="logo"
                                            class="hidden"
                                            accept="image/*"
                                            x-ref="photo"
                                            x-on:change="
                                                const file = $refs.photo.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                                    reader.readAsDataURL(file);
                                                }
                                            "
                                        />
                                        <x-secondary-button type="button" x-on:click="$refs.photo.click()">
                                            {{ __('Seleccionar Imagen') }}
                                        </x-secondary-button>
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            PNG, JPG, SVG hasta 10MB
                                        </p>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                            </div>
                        </div>

                        {{-- Columna 2 --}}
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre')" />
                                <x-text-input
                                    id="nombre"
                                    name="nombre"
                                    type="text"
                                    class="block w-full mt-1"
                                    :value="old('nombre', $configuracion->nombre ?? '')"
                                    autocomplete="nombre"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="descripcion" :value="__('Descripción')" />
                                <x-text-input
                                    id="descripcion"
                                    name="descripcion"
                                    type="text"
                                    class="block w-full mt-1"
                                    :value="old('descripcion', $configuracion->descripcion ?? '')"
                                    autocomplete="descripcion"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                            </div>

                            <div>
                                <x-input-label for="direccion" :value="__('Dirección')" />
                                <x-text-input
                                    id="direccion"
                                    name="direccion"
                                    type="text"
                                    class="block w-full mt-1"
                                    :value="old('direccion', $configuracion->direccion ?? '')"
                                    autocomplete="street-address"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                            </div>

                            <div>
                                <x-input-label for="telefono" :value="__('Teléfono')" />
                                <x-text-input
                                    id="telefono"
                                    name="telefono"
                                    type="tel"
                                    class="block w-full mt-1"
                                    :value="old('telefono', $configuracion->telefono ?? '')"
                                    autocomplete="tel"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                            </div>
                        </div>

                        {{-- Columna 3 --}}
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
                                <x-text-input
                                    id="correo_electronico"
                                    name="correo_electronico"
                                    type="email"
                                    class="block w-full mt-1"
                                    :value="old('correo_electronico', $configuracion->correo_electronico ?? '')"
                                    autocomplete="email"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('correo_electronico')" />
                            </div>

                            <div>
                                <x-input-label for="web" :value="__('Sitio Web')" />
                                <x-text-input
                                    id="web"
                                    name="web"
                                    type="url"
                                    class="block w-full mt-1"
                                    :value="old('web', $configuracion->web ?? '')"
                                    autocomplete="url"
                                    placeholder="https://"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('web')" />
                            </div>

                            <div>
                                <x-input-label for="divisa" :value="__('Divisa')" />
                                <select
                                    id="divisa"
                                    name="divisa"
                                    class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option value="">{{ __('Seleccione una divisa') }}</option>
                                    @foreach($divisas as $divisa)
                                        <option
                                            value="{{ $divisa['code'] }}"
                                            {{ old('divisa', $configuracion->divisa ?? '') == $divisa['code'] ? 'selected' : '' }}
                                        >
                                            {{ $divisa['code'] }} - {{ $divisa['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('divisa')" />
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <x-primary-button>
                            {{ __('Guardar Cambios') }}
                        </x-primary-button>

                    </div>
                </form>
            </div>

        </div>

</x-app-layout>
