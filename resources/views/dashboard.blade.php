<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- <x-jet-welcome /> -->
                <ul class="p-2 uppercase">
                    <li class="mr2">
                        <a href="{{ route('pagina.planificacion') }}" class="">
                            Planificacion
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="{{ route('pagina.propuesta') }}" class="">
                            Propuesta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
