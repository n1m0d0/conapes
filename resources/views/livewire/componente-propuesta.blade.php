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
    <div class="flex col-span-1 md:col-span-4 items-center justify-end">
        <button wire:click='modalRegistrar'
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Registrar
        </button>
    </div>
    <div class="col-span-12">
        <div class="overflow-x-auto pt-4">
            <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr class="uppercase">
                        <th class="p-3 text-left">Cartera de estado</th>
                        <th class="p-3 text-left">Norma</th>
                        <th class="p-3 text-left">Sector</th>
                        <th class="p-3 text-left">Archivo</th>
                        <th class="p-3 text-left">Prioridad</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($propuestas as $propuesta)
                    <tr class="bg-blue-200 text-black">
                        <td class="p-3">{{ $propuesta->planificacion->portafolio->nombre }}</td>
                        <td class="p-3">{{ $propuesta->planificacion->nombre }}</td>
                        <td class="p-3 ">{{ $propuesta->sector->nombre }}</td>
                        <td class="p-3">
                            <a class="flex cursor-pointer text-gray-500 hover:text-gray-100"
                                wire:click="descargarArchivo({{ $propuesta->id }})">
                                <x-feathericon-hard-drive />
                                &nbsp;
                                {{ $propuesta->documento->nombre }}
                            </a>
                        </td>
                        <td class="p-3 ">
                            @if ($propuesta->prioridad == 1)
                            <div
                                class="flex justify-center bg-red-500 text-gray-100 items-center p-1 rounded-lg text-base font-bold">
                                <x-feathericon-alert-triangle /> &nbsp; Alta
                            </div>
                            @else
                            @if ($propuesta->prioridad == 2)
                            <div
                                class="flex justify-center bg-yellow-500 text-gray-100 items-center p-1 rounded-lg text-base font-bold">
                                <x-feathericon-alert-triangle /> &nbsp; Media
                            </div>
                            @else
                            <div
                                class="flex justify-center bg-green-500 text-gray-100 items-center p-1 rounded-lg text-base font-bold">
                                <x-feathericon-alert-triangle /> &nbsp; Baja
                            </div>
                            @endif
                            @endif
                        </td>
                        <td class="p-3 ">
                            @if ($propuesta->estado == 1)
                            REVISION
                            @else
                            @if ($propuesta->estado == 2)
                            APROBADO
                            @else
                            @if ($propuesta->estado == 3)
                            REPROBADO
                            @endif
                            @endif
                            @endif
                        </td>
                        <td class="flex p-3 items-center">
                            <a wire:click='modalEditar({{ $propuesta->id }})' class="cursor-pointer">
                                <x-feathericon-edit class="text-green-500 hover:text-gray-100" />
                            </a>
                            &nbsp;
                            <a wire:click='modalEliminar({{ $propuesta->id }})' class="cursor-pointer">
                                <x-feathericon-trash-2 class="text-red-400 hover:text-gray-100" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $propuestas->links() }}
        </div>
    </div>

    <x-jet-dialog-modal wire:model="registrarModal">
        <x-slot name="title">
            Registrar Propuesta
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="planificacion_id" value="Planificacion" />
                    <select wire:model.defer="planificacion_id"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">Seleccione un opcion</option>
                        @foreach ($planificaciones as $planificacion)
                        <option value="{{ $planificacion->id }}">{{ $planificacion->nombre }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="sector_id" class="mt-2" />
                </div>
                <x-jet-label for="fecha_ingreso" value="Fecha Inicio" />
                <x-jet-input id="fecha_ingreso" type="date" class="mt-1 block w-full"
                    wire:model.defer='fecha_ingreso' />
                <x-jet-input-error for="fecha_ingreso" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="prioridad" value="Prioridad" />
                <select wire:model.defer="prioridad"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    <option class="text-red-400" value="1">Alta</option>
                    <option class="text-yellow-400" value="2">Media</option>
                    <option class="text-green-400" value="3">Baja</option>
                </select>
                <x-jet-input-error for="prioridad" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="sector_id" value="Sectores" />
                <select wire:model.defer="sector_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($sectores as $sector)
                    <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="sector_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="documento_id" value="Documento" />
                <select wire:model.defer="documento_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($documentos as $documento)
                    <option value="{{ $documento->id }}">{{ $documento->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="documento_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="archivo" value="Archivo" />
                <x-jet-input id="archivo" type="file" class="mt-1 block w-full" wire:model.defer='archivo' />
                <x-jet-input-error for="archivo" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('registrarModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='registrar' wire:loading.attr="disabled">
                Guardar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="editarModal">
        <x-slot name="title">
            Editar Propuesta
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fecha_ingreso" value="Fecha Inicio" />
                <x-jet-input id="fecha_ingreso" type="date" class="mt-1 block w-full"
                    wire:model.defer='fecha_ingreso' />
                <x-jet-input-error for="fecha_ingreso" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="prioridad" value="Prioridad" />
                <select wire:model.defer="prioridad"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    <option class="text-red-400" value="1">Alta</option>
                    <option class="text-yellow-400" value="2">Media</option>
                    <option class="text-green-400" value="3">Baja</option>
                </select>
                <x-jet-input-error for="prioridad" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="sector_id" value="Sectores" />
                <select wire:model.defer="sector_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($sectores as $sector)
                    <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="sector_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="documento_id" value="Documento" />
                <select wire:model.defer="documento_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($documentos as $documento)
                    <option value="{{ $documento->id }}">{{ $documento->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="documento_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="archivo" value="Archivo" />
                <x-jet-input id="archivo" type="file" class="mt-1 block w-full" wire:model.defer='archivo' />
                <x-jet-input-error for="archivo" class="mt-2" />
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