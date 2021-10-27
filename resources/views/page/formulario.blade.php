<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formularios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('componente-formulario')
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            window.addEventListener('alert', event => {
                toastr.success(event.detail.mensaje)
            })
        </script>
        <script>
            window.addEventListener('delete', event => {
                toastr.warning(event.detail.mensaje)
            })
        </script>
    @endsection
</x-app-layout>