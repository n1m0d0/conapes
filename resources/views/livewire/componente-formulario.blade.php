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
                        <th class="p-3 text-left">Formularios</th>
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
                            <ul class="">
                                @foreach ($propuesta->generados as $generado)
                                @if ($generado->estado == 1)
                                <li class="flex items-center pt-2">
                                    <a wire:click='descargarFormulario({{ $generado->id }})'
                                        class="cursor-pointer text-gray-600 hover:text-gray-100">
                                        {{ $generado->formulario->nombre }}
                                    </a>
                                    &nbsp;
                                    <a wire:click='modalEliminar({{ $generado->id }})' class="cursor-pointer">
                                        <x-feathericon-trash-2 class="text-red-400 hover:text-gray-100" />
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </td>
                        <td class="flex p-3 justify-center items-center">
                            <a wire:click='modalAgregar({{ $propuesta->id }})' class="cursor-pointer">
                                <x-feathericon-folder-plus class="text-yellow-400 hover:text-gray-100" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $propuestas->links() }}
        </div>
    </div>

    <x-jet-dialog-modal wire:model="agregarModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                Agregar Formulario
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="felx col-span-6 sm:col-span-4 items-center">
                <x-jet-label for="formulario_id" value="Formulario" />
                <select wire:model="formulario_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($formularios as $formulario)
                    <option value="{{ $formulario->id }}">{{ $formulario->nombre }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="formulario_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="cabecera" value="Cabecera" />
                <x-jet-input id="cabecera" type="text" class="mt-1 block w-full" wire:model.defer='cabecera' />
                <x-jet-input-error for="cabecera" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="cuerpo" value="Cuerpo" />
                <x-jet-input id="cuerpo" type="text" class="mt-1 block w-full" wire:model.defer='cuerpo' />
                <x-jet-input-error for="cuerpo" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('agregarModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='agregar' wire:loading.attr="disabled">
                Aceptar
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