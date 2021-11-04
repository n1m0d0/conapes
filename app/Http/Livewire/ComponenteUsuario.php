<?php

namespace App\Http\Livewire;

use App\Models\Sector;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ComponenteUsuario extends Component
{
    use WithPagination;

    public $busqueda;
    public $nombre;
    public $correo;
    public $contrasena;
    public $rol;
    public $crearModal = false;
    public $editarModal = false;
    public $eliminarModal = false;
    public $especialidadModal = false; 
    public $user_id;
    public $sector;

    public function render()
    {
        $usuarioQuery = User::query();
        if ($this->busqueda != null) {
            $usuarioQuery = $usuarioQuery->where('name', 'LIKE', "%$this->busqueda%");
        }
        $usuarios = $usuarioQuery->orderBy('id', 'DESC')->paginate(4);
        $roles = DB::table('roles')->where('guard_name', 'web')->get();
        $sectores = Sector::where('estado', Sector::ACTIVO)->get();
        return view('livewire.componente-usuario', compact('usuarios', 'roles', 'sectores'));
    }

    public function reiniciar()
    {
        $this->reset(['busqueda']);
    }

    public function limpiar()
    {
        $this->reset(['nombre', 'correo', 'contrasena', 'rol']);
    }

    public function modalCrear()
    {
        $this->limpiar();
        $this->crearModal = true;
    }

    public function modalEditar($id)
    {
        $this->limpiar();
        $this->user_id = $id;
        $usuario = User::find($id);
        $this->nombre = $usuario->name;
        $this->correo = $usuario->email;
        $this->rol = $usuario->getRoleNames()[0];
        $this->editarModal = true;
    }

    public function modalEliminar($id) 
    {
        $this->user_id = $id;
        $this->eliminarModal = true;
    }

    public function modalEspecialidad($id) 
    {
        $this->user_id = $id;
        $this->especialidadModal = true;
    }

    public function crear()
    {
        $this->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'contrasena' => 'required',
            'rol' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $usuario = new User();
            $usuario->name = $this->nombre;
            $usuario->email = $this->correo;
            $usuario->password = bcrypt($this->contrasena);
            $usuario->save();

            $usuario->assignRole($this->rol);

            DB::commit();

            $this->crearModal = false;
            $this->limpiar();
            $this->mensaje();
        } catch (\Exception $e) {
            DB::rollback();

            $this->crearModal = false;
            $this->limpiar();
            $this->error();
        }
    }

    public function editar()
    {
        $this->validate([
            'nombre' => 'required',
            'correo' => 'email',
            'contrasena' => 'required',
            'rol' => 'required'
        ]);

        
        $usuario = User::find($this->user_id);
        
        DB::beginTransaction();

        try {
            $usuario->removeRole($usuario->getRoleNames()[0]);
            $usuario->name = $this->nombre;
            $usuario->email = $this->correo;
            $usuario->password = bcrypt($this->contrasena);
            $usuario->save();

            $usuario->assignRole($this->rol);

            DB::commit();

            $this->editarModal = false;
            $this->limpiar();
            $this->mensaje();
        } catch (\Exception $e) {
            DB::rollback();

            $this->editarModal = false;
            $this->limpiar();
            $this->error();
        }
    }

    public function eliminar()
    {
        $usuario = User::find($this->user_id);
        $usuario->removeRole($usuario->getRoleNames()[0]);
        $usuario->deleteProfilePhoto();
        $usuario->tokens->each->delete();
        $usuario->delete();

        $this->mensajeEliminacion();
        $this->eliminarModal = false;
    }

    public function especialidad(){
        $this->validate([
            'user_id' => 'required',
            'sector' => 'required'
        ]);

        $usuario = User::find($this->user_id);
        $usuario->sector_id = $this->sector;
        $usuario->save();

        $this->sector = "";
        $this->mensaje();
        $this->especialidadModal = false;
    }

    public function mensaje()
    {
        $this->dispatchBrowserEvent('alert', ['mensaje' => 'Se registro correctamente']);
    }

    public function error()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'El correo ya se encuentra en uso']);
    }

    public function mensajeEliminacion()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'Se elimino el registro correctamente']);
    }
}
