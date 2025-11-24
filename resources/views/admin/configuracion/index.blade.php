<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                <span class="material-icons text-indigo-600 dark:text-indigo-400">settings</span>
            </div>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Configuración del Sistema') }}
                </h2>

            </div>
        </div>
    </x-slot>

    <div class="py-0">
        <div class="max-w-7xl mx-auto">
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
                                            <span class="material-icons text-sm mr-2">add_photo_alternate</span>
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
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                                        business
                                    </span>
                                    <x-text-input
                                        id="nombre"
                                        name="nombre"
                                        type="text"
                                        class="block w-full pl-11"
                                        :value="old('nombre', $configuracion->nombre ?? '')"
                                        autocomplete="nombre"
                                    />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <div>
                                <x-input-label for="descripcion" :value="__('Descripción')" />
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                                        description
                                    </span>
                                    <x-text-input
                                        id="descripcion"
                                        name="descripcion"
                                        type="text"
                                        class="block w-full pl-11"
                                        :value="old('descripcion', $configuracion->descripcion ?? '')"
                                        autocomplete="descripcion"
                                    />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                            </div>

                            <div>
                                <x-input-label for="direccion" :value="__('Dirección')" />
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                                        location_on
                                    </span>
                                    <x-text-input
                                        id="direccion"
                                        name="direccion"
                                        type="text"
                                        class="block w-full pl-11"
                                        :value="old('direccion', $configuracion->direccion ?? '')"
                                        autocomplete="street-address"
                                    />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                            </div>

                            <div>
                                <x-input-label for="telefono" :value="__('Teléfono')" />
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                                        phone
                                    </span>
                                    <x-text-input
                                        id="telefono"
                                        name="telefono"
                                        type="tel"
                                        class="block w-full pl-11"
                                        :value="old('telefono', $configuracion->telefono ?? '')"
                                        autocomplete="tel"
                                    />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                            </div>
                        </div>

                        {{-- Columna 3 --}}
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                                        email
                                    </span>
                                    <x-text-input
                                        id="correo_electronico"
                                        name="correo_electronico"
                                        type="email"
                                        class="block w-full pl-11"
                                        :value="old('correo_electronico', $configuracion->correo_electronico ?? '')"
                                        autocomplete="email"
                                    />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('correo_electronico')" />
                            </div>

                            <div>
                                <x-input-label for="web" :value="__('Sitio Web')" />
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl">
                                        language
                                    </span>
                                    <x-text-input
                                        id="web"
                                        name="web"
                                        type="url"
                                        class="block w-full pl-11"
                                        :value="old('web', $configuracion->web ?? '')"
                                        autocomplete="url"
                                        placeholder="https://"
                                    />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('web')" />
                            </div>

                            <div>
                                <x-input-label for="divisa" :value="__('Divisa')" />
                                <div class="relative mt-1">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xl z-10">
                                        payments
                                    </span>
                                    <select
                                        id="divisa"
                                        name="divisa"
                                        class="block w-full pl-11 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
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
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('divisa')" />
                            </div>
                        </div>
                    </div>

                    {{-- Footer con botones --}}
                    <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <x-primary-button>
                            <span class="material-icons text-sm mr-2">save</span>
                            {{ __('Guardar Cambios') }}
                        </x-primary-button>

                        @if (session('status') === 'config-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-600 dark:text-green-400 flex items-center gap-1"
                            >
                                <span class="material-icons text-sm">check_circle</span>
                                {{ __('Guardado correctamente.') }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
