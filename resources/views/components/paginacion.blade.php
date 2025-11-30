@props(['data'])




{{-- PAGINACIÓN --}}
            @if (method_exists($data, 'links'))

                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            @endif


        </div>
