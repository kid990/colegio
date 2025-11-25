@props([
    'route',
    'buttonText' => 'Eliminar',
    'buttonClass' => 'inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition-colors duration-150'
])

<form action="{{ $route }}"
      method="POST"
      x-data
      @submit.prevent="
          Swal.fire({
              title: '¿Estás seguro?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#dc2626',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
              reverseButtons: true
          }).then((result) => {
              if (result.isConfirmed) {
                  $el.submit();
              }
          });
      "
      class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="{{ $buttonClass }}">
        {{ $buttonText }}
    </button>
</form>
