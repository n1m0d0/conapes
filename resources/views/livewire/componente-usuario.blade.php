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
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Correo</th>
                        <th class="p-3 text-left">Rol</th>
                        <th class="p-3 text-left">Registrado</th>
                        <th class="p-3 text-left">Modificado</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                    @if ($usuario->name != "admin")
                    <tr class="bg-blue-200 text-black">
                        <td class="p-3 font-medium capitalize">{{ $usuario->name }}</td>
                        <td class="p-3">{{ $usuario->email }}</td>
                        <td class="p-3">{{ $usuario->getRoleNames()[0] }}</td>
                        <td class="p-3">{{ $usuario->created_at }}</td>
                        <td class="p-3 ">{{ $usuario->updated_at }}</td>
                        <td class="flex p-3 items-center">
                            <a wire:click='modalEditar({{ $usuario->id }})' class="cursor-pointer">
                                <x-feathericon-edit class="text-green-400 hover:text-gray-100" />
                            </a>
                            &nbsp;
                            <a wire:click='modalEliminar({{ $usuario->id }})' class="cursor-pointer">
                                <x-feathericon-trash-2 class="text-red-400 hover:text-gray-100" />
                            </a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            {{ $usuarios->links() }}
        </div>
    </div>

    <x-jet-dialog-modal wire:model="crearModal">
        <x-slot name="title">
            Nuevo Usuario
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="nombre" value="Nombre Completo" />
                <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer='nombre' />
                <x-jet-input-error for="nombre" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="correo" value="Correo" />
                <x-jet-input id="correo" type="text" class="mt-1 block w-full" wire:model.defer='correo' />
                <x-jet-input-error for="correo" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="contrasena" value="Contraseña" />
                <x-jet-input id="contrasena" type="password" class="mt-1 block w-full" wire:model.defer='contrasena' />
                <x-jet-input-error for="contrasena" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="rol" value="Rol" />
                <select wire:model="rol"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($roles as $rol)
                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="rol" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('crearModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-2" wire:click='crear' wire:loading.attr="disabled">
                Guardar
            </x-jet-secondary-button>
        </x-slot>

    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="editarModal">
        <x-slot name="title">
            Editar Uusuario
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="nombre" value="Nombre Completo" />
                <x-jet-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer='nombre' />
                <x-jet-input-error for="nombre" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="correo" value="Correo" />
                <x-jet-input id="correo" type="text" class="mt-1 block w-full" wire:model.defer='correo' />
                <x-jet-input-error for="correo" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="contrasena" value="Contraseña" />
                <x-jet-input id="contrasena" type="password" class="mt-1 block w-full" wire:model.defer='contrasena' />
                <x-jet-input-error for="contrasena" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="rol" value="Rol" />
                <select wire:model="rol"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione un opcion</option>
                    @foreach ($roles as $rol)
                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="rol" class="mt-2" />
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
                Eliminar Usuario
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