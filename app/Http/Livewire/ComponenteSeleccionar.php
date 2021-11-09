<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Propuesta;
use App\Models\Asignacion;
use Livewire\WithPagination;
use App\Models\Planificacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Assert;

class ComponenteSeleccionar extends Component
{
    use WithPagination;

    public $busqueda;
    public $propuesta_id;
    public $sector_id;
    public $user_id;
    public $asignacion_id;
    public $agregarModal = false;
    public $eliminarModal = false;

    public function render()
    {
        $propuestaQuery = Propuesta::query();
        if ($this->busqueda != null) {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('estado', Planificacion::ACTIVO)->where('nombre', 'LIKE', "%$this->busqueda%");
            })->where('estado', '!=', Propuesta::INACTIVO);
        } else {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('estado', Planificacion::ACTIVO);
            })->where('estado', '!=', Propuesta::INACTIVO);
        }
        $userQuery = User::query();
        if ($this->agregarModal == true)
        {
            $userQuery = $userQuery->where('sector_id', $this->sector_id);
        }
        $users = $userQuery->orderBy('id', 'DESC')->get();
        $propuestas = $propuestaQuery->orderBy('id', 'DESC')->paginate(4);
        return view('livewire.componente-seleccionar', compact('propuestas', 'users'));
    }

    public function modalAgregar($propuesta, $sector)
    {
        $this->propuesta_id = $propuesta;
        $this->sector_id = $sector;        
        $this->agregarModal = true;
    }

    public function modalEliminar($id)
    {
        $asignacion = Asignacion::where('estado', Asignacion::ACTIVO)->where('propuesta_id', $id)->first();
        $this->asignacion_id = $asignacion->id;
        $this->eliminarModal = true;
    }

    public function agregar()
    {
        $propuesta = Propuesta::find($this->propuesta_id);
        if ($propuesta->estado == 1) {
            $asignacion = new Asignacion();
            $asignacion->user_id = $this->user_id;
            $asignacion->propuesta_id = $this->propuesta_id;
            $asignacion->save();

            $propuesta->estado = Propuesta::REVISION;
            $propuesta->save();

            $this->mensaje();
            $this->agregarModal = false;
        } else {
            $this->mensajeAlerta();
            $this->agregarModal = false;
        }

        $this->limpiar();
    }

    public function eliminar()
    {
        $asignacion = Asignacion::find($this->asignacion_id);
        $asignacion->estado = Asignacion::INACTIVO;
        $asignacion->save();

        $propuesta = Propuesta::find($asignacion->propuesta_id);
        $propuesta->estado = Propuesta::REGISTRADO;
        $propuesta->save();

        $this->mensajeEliminacion();
        $this->eliminarModal = false;
    }

    public function limpiar()
    {
        $this->reset(['user_id']);
    }

    public function reiniciar()
    {
        $this->reset(['busqueda']);
    }

    public function mensaje()
    {
        $this->dispatchBrowserEvent('alert', ['mensaje' => 'Se registro correctamente']);
    }

    public function mensajeEliminacion()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'Se elimino el registro correctamente']);
    }

    public function mensajeAlerta()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'Ya se asignada esa propuesta a otro especialista']);
    }

    public function descargarArchivo($id)
    {
        $propuesta = Propuesta::find($id);
        return Storage::download($propuesta->archivo);
    }
}
