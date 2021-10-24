<div class="p-4 grid grid-cols-1 md:grid-cols-12 gap-2">
    <div class="col-span-1 md:col-span-6">
        <input class="w-full" wire:model="busqueda" type="text" name="busqueda" placeholder="Buscar...">
    </div>
    <div class="col-span-1 md:col-span-2">
        <button wire:click='modalCrear' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Buscar
        </button>
    </div> 
    <div class="flex col-span-1 md:col-span-4 justify-end">
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
                    <tr class="bg-blue-200 lg:text-black">
                        <td class="p-3 font-medium capitalize">{{ $planificacion->user->name }}</td>
                        <td class="p-3">{{ $planificacion->portafolio->nombre }}</td>
                        <td class="p-3">{{ $planificacion->nombre }}</td>
                        <td class="p-3 ">{{ $planificacion->descripcion }}</td>
                        <td class="p-3 ">{{ $planificacion->fecha_inicio }}</td>
                        <td class="p-3 ">{{ $planificacion->fecha_fin }}</td>
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
    <x-jet-dialog-modal wire:model="nuevoModal">
        <x-slot name="title">
            Prueba
        </x-slot>
 
        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="portafolio_id" value="portafolio_id" />
                <x-jet-input id="portafolio_id" type="text" class="mt-1 block w-full" wire:model.defer='portafolio_id' />
                <x-jet-input-error for="portafolio_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="nombre" value="nombre" />
                <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer='nombre' />
                <x-jet-input-error for="nombre" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="descripcion" value="descripcion" />
                <x-jet-input id="descripcion" type="text" class="mt-1 block w-full" wire:model.defer='descripcion' />
                <x-jet-input-error for="descripcion" class="mt-2" />
            </div>    
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_inicio" value="fecha_inicio" />
                <x-jet-input id="fecha_inicio" type="date" class="mt-1 block w-full" wire:model.defer='fecha_inicio' />
                <x-jet-input-error for="fecha_inicio" class="mt-2" />
            </div>   
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_fin" value="fecha_fin" />
                <x-jet-input id="fecha_fin" type="date" class="mt-1 block w-full" wire:model.defer='fecha_fin' />
                <x-jet-input-error for="fecha_fin" class="mt-2" />
            </div>             
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('nuevoModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>
 
            <x-jet-danger-button class="ml-2" wire:click='nuevo' wire:loading.attr="disabled">
                Guardar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>