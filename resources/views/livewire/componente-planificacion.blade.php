<div class="p-4 grid grid-cols-1 md:grid-cols-12 gap-2">
    <div class="flex col-span-1 md:col-span-6 items-center">
        <x-feathericon-search class="w-11 p-2 h-full bg-gray-500 text-white rounded-l-lg" />
        <input class="w-full" wire:model="busqueda" type="text" name="busqueda" placeholder="Buscar...">
    </div>
    <div class="flex col-span-1 md:col-span-2 items-center">
        <button wire:click='reiniciar' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Reiniciar
        </button>
    </div>
    <div class="flex col-span-1 md:col-span-4 items-center justify-end gap-2">
        <button wire:click='modalCrear' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nuevo
        </button>
    </div>
    <div class="col-span-12">
        <div class="overflow-x-auto pt-4">
            <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr class="uppercase">
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
                    <tr class="bg-blue-200 text-black">
                        <td class="p-3 font-medium capitalize">{{ $planificacion->user->name }}</td>
                        <td class="p-3">{{ $planificacion->portafolio->nombre }}</td>
                        <td class="p-3">{{ $planificacion->nombre }}</td>
                        <td class="p-3 ">{{ $planificacion->descripcion }}</td>
                        <td class="p-3 ">{{ $planificacion->fecha_inicio }}</td>
                        <td class="p-3 ">{{ $planificacion->fecha_fin }}</td>
                        <td class="flex p-3 items-center">
                            <a wire:click='modalActualizar({{ $planificacion->id }})' class="cursor-pointer">
                                <x-feathericon-edit class="text-green-400 hover:text-gray-100" />
                            </a>
                            &nbsp;
                            <a wire:click='modalEliminar({{ $planificacion->id }})' class="cursor-pointer">
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

    <x-jet-dialog-modal wire:model="nuevoModal">
        <x-slot name="title">
            Nueva Planificacion
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="portafolio_id" value="Portafolio" />
                <select wire:model="portafolio_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($portafolios as $portafolio)
                    <option value="{{ $portafolio->id }}">{{ $portafolio->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="portafolio_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="nombre" value="Nombre de la norma" />
                <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer='nombre' />
                <x-jet-input-error for="nombre" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="descripcion" value="Descripcion" />
                <x-jet-input id="descripcion" type="text" class="mt-1 block w-full" wire:model.defer='descripcion' />
                <x-jet-input-error for="descripcion" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_inicio" value="Fecha Inicio" />
                <x-jet-input id="fecha_inicio" type="date" class="mt-1 block w-full" wire:model.defer='fecha_inicio' />
                <x-jet-input-error for="fecha_inicio" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_fin" value="Fecha Fin" />
                <x-jet-input id="fecha_fin" type="date" class="mt-1 block w-full" wire:model.defer='fecha_fin' />
                <x-jet-input-error for="fecha_fin" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('nuevoModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='nuevo' wire:loading.attr="disabled">
                Guardar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="editarModal">
        <x-slot name="title">
            Editar Planificacion
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="portafolio_id" value="Portafolio" />
                <select wire:model="portafolio_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($portafolios as $portafolio)
                    <option value="{{ $portafolio->id }}">{{ $portafolio->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="portafolio_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="nombre" value="Nombre de la norma" />
                <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer='nombre' />
                <x-jet-input-error for="nombre" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="descripcion" value="Descripcion" />
                <x-jet-input id="descripcion" type="text" class="mt-1 block w-full" wire:model.defer='descripcion' />
                <x-jet-input-error for="descripcion" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_inicio" value="Fecha Inicio" />
                <x-jet-input id="fecha_inicio" type="date" class="mt-1 block w-full" wire:model.defer='fecha_inicio' />
                <x-jet-input-error for="fecha_inicio" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_fin" value="Fecha Fin" />
                <x-jet-input id="fecha_fin" type="date" class="mt-1 block w-full" wire:model.defer='fecha_fin' />
                <x-jet-input-error for="fecha_fin" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('editarModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='editar' wire:loading.attr="disabled">
                Guardar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="eliminarModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-feathericon-alert-circle class="text-red-500 mr-2" />
                Eliminar Planificacion
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="felx col-span-6 sm:col-span-4 items-center">
                <x-feathericon-alert-triangle class="h-20 w-20 text-yellow-500 text-center" />
                <p>
                    Una vez eliminado no se podra recuperar el registro.
                    ¿Esta seguro de que quiere Eliminar el registro?
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('eliminarModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='eliminar' wire:loading.attr="disabled">
                Aceptar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>