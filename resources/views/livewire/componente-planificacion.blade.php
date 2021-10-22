<div class="p-4 grid grid-cols-12">
    <div class="col-span-12">
        <button wire:click='nuevo' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nuevo
        </button>
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
                        <td class="p-3">
                            <a href="#" class="text-gray-500 hover:text-gray-100 mr-2">
                                <i class="material-icons-outlined text-base">visibility</i>
                            </a>
                            <a href="#" class="text-yellow-400 hover:text-gray-100 mx-2">
                                <i class="material-icons-outlined text-base">edit</i>
                            </a>
                            <a href="#" class="text-red-400 hover:text-gray-100 ml-2">
                                <i class="material-icons-round text-base">delete_outline</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>