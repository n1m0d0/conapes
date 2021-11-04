<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Propuesta;
use App\Models\Asignacion;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ComponenteEspecialista extends Component
{
    use WithPagination;
    
    public $user_id;
    public $sector_id;
    public $propuesta_id;
    public $asignacion_id;
    public $busqueda;
    public $agregarModal = false;
    public $eliminarModal = false;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->sector_id = auth()->user()->sector_id;
    }

    public function render()
    {
        $propuestaQuery = Propuesta::query();
        if ($this->busqueda != null) {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('estado', 2)->where('nombre', 'LIKE', "%$this->busqueda%");
            })->where('sector_id', $this->sector_id)->where('estado', '!=', 5);
        } else {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('estado', 2);
            })->where('sector_id', $this->sector_id)->where('estado', '!=', 5);
        }
        $propuestas = $propuestaQuery->orderBy('id', 'DESC')->paginate(4);
        $asignaciones = Asignacion::where('estado', 1)->where('user_id', $this->user_id)->paginate(4);
        return view('livewire.componente-especialista', compact('propuestas', 'asignaciones'));
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

    public function modalAgregar($id)
    {
        $this->propuesta_id = $id;
        $this->agregarModal = true;
    }

    public function modalEliminar($id)
    {
        $this->asignacion_id = $id;
        $this->eliminarModal = true;
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
