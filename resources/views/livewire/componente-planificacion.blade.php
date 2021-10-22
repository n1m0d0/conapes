<div class="p-4 grid grid-cols-1 md:grid-cols-12">
    <div class="col-span-1 md:col-span-4">
        <button wire:click='nuevo' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nuevo
        </button>
    </div>
    <div class="col-span-1 md:col-span-8 content-end">
        <input wire:model="busqueda" type="text" name="busqueda" placeholder="Buscar..">
    </div>
    <div class="col-span-12">
        <div class="overflow-x-auto pt-4">
            <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="p-3">Usuario</th>
                        <th class="p-3 text-left">Cartera de estado</th>
                        <th class="p-3 text-left">Norma</th>
                        <th class="p-3 text-left">Descripcion</th>
                        <th class="p-3 text-left">Inicio</th>
                        <th class="p-3 text-left">Fin</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planificaciones as $planificacion)
                    <tr class="bg-blue-200 lg:text-black">
                        <td class="p-3 font-medium capitalize">{{ $planificacion->user->name }}</td>
                        <td class="p-3">{{ $planificacion->portafolio->nombre }}</td>
                        <td class="p-3">{{ $planificacion->nombre }}</td>
                        <td class="p-3 ">{{ $planificacion->descripcion }}</td>
                        <td class="p-3 ">{{ $planificacion->fecha_inicio }}</td>
                        <td class="p-3 ">{{ $planificacion->fecha_fin }}</td>
                        <!-- <td class="p-3">
                            <span class="bg-green-400 text-gray-50 rounded-md px-2">ACTIVE</span>
                        </td> -->
                        <td class="p-3 grid grid-cols-1 md:grid-cols-4">
                            <a href="#" class="col-span-1 md:col-span-2 m-2">
                                <x-feathericon-edit class="text-green-400 hover:text-gray-100" />
                            </a>
                            <a href="#" class="col-span-1 md:col-span-2 m-2">
                                <x-feathericon-trash-2 class="text-red-400 hover:text-gray-100" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $planificaciones->links() }}
        </div>
    </div>
</div>