<?php

namespace App\Http\Livewire;

use App\Models\Sector;
use Livewire\Component;
use App\Models\Documento;
use App\Models\Propuesta;
use Livewire\WithPagination;
use App\Models\Planificacion;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ComponentePropuesta extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $busqueda;
    public $user_id;
    public $planificacion_id;
    public $fecha_ingreso;
    public $prioridad;
    public $sector_id;
    public $archivo;
    public $documento_id;
    public $propuesta_id;
    public $registrarModal = false;
    public $editarModal = false;
    public $eliminarModal = false;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        $sectores = Sector::where('estado', Sector::ACTIVO)->get();
        $documentos = Documento::where('estado', Documento::ACTIVO)->get();
        $planificaciones = Planificacion::where('estado', Planificacion::REGISTRADO)->get();

        $propuestaQuery = Propuesta::query();
        if ($this->busqueda != null) {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('user_id', $this->user_id)->where('estado', Planificacion::ACTIVO)->where('nombre', 'LIKE', "%$this->busqueda%");
            })->where('estado', '!=', Propuesta::INACTIVO);
        } else {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('user_id', $this->user_id)->where('estado', Planificacion::ACTIVO);
            })->where('estado', '!=', Propuesta::INACTIVO);
        }
        $propuestas = $propuestaQuery->orderBy('id', 'DESC')->paginate(4);
        return view('livewire.componente-propuesta', compact('propuestas', 'planificaciones', 'sectores', 'documentos'));
    }

    public function registrar()
    {
        $this->validate([
            'planificacion_id' => 'required',
            'fecha_ingreso' => 'required|date',
            'prioridad' => 'required',
            'sector_id' => 'required',
            'archivo' => 'required|mimes:jpg,bmp,png,pdf|max:5120',
            'documento_id' => 'required'
        ]);

        $propuesta = new Propuesta();
        $propuesta->planificacion_id = $this->planificacion_id;
        $propuesta->fecha_ingreso = $this->fecha_ingreso;
        $propuesta->prioridad = $this->prioridad;
        $propuesta->sector_id = $this->sector_id;
        $propuesta->archivo = $this->archivo->store('public');
        $propuesta->documento_id = $this->documento_id;
        $propuesta->save();

        $planificacion = Planificacion::find($this->planificacion_id);
        $planificacion->estado = Planificacion::ACTIVO;
        $planificacion->save();

        $this->registrarModal = false;
        $this->limpiar();
        $this->mensaje();
    }

    public function editar()
    {
        $this->validate([
            'planificacion_id' => 'required',
            'fecha_ingreso' => 'required|date',
            'prioridad' => 'required',
            'sector_id' => 'required',
            'archivo' => 'required|mimes:jpg,bmp,png,pdf|max:5120',
            'documento_id' => 'required'
        ]);

        $propuesta = Propuesta::find($this->propuesta_id);
        $propuesta->planificacion_id = $this->planificacion_id;
        $propuesta->fecha_ingreso = $this->fecha_ingreso;
        $propuesta->prioridad = $this->prioridad;
        $propuesta->sector_id = $this->sector_id;
        $propuesta->archivo = $this->archivo->store('public');
        $propuesta->documento_id = $this->documento_id;
        $propuesta->save();

        $this->editarModal = false;
        $this->limpiar();
        $this->mensaje();
    }

    public function eliminar()
    {
        $propuesta = Propuesta::find($this->propuesta_id);
        $propuesta->estado = Propuesta::INACTIVO;
        $propuesta->save();

        $planificacion = Planificacion::find($propuesta->planificacion_id);
        $planificacion->estado = Planificacion::REGISTRADO;
        $planificacion->save();

        $this->mensajeEliminacion();
        $this->eliminarModal = false;
    }

    public function modalRegistrar()
    {
        $this->limpiar();
        $this->registrarModal = true;
    }

    public function modalEditar($id)
    {
        $this->limpiar();
        $this->propuesta_id = $id;
        $propuesta = Propuesta::find($this->propuesta_id);
        $this->planificacion_id = $propuesta->planificacion_id;
        $this->fecha_ingreso = $propuesta->fecha_ingreso;
        $this->prioridad = $propuesta->prioridad;
        $this->sector_id = $propuesta->sector_id;
        //$this->archivo = $propuesta->archivo;
        $this->documento_id = $propuesta->documento_id;
        $this->editarModal = true;
    }

    public function modalEliminar($id)
    {
        $this->propuesta_id = $id;
        $this->eliminarModal = true;
    }

    public function limpiar()
    {
        $this->reset(['planificacion_id', 'fecha_ingreso', 'prioridad', 'sector_id', 'archivo', 'documento_id']);
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

    public function descargarArchivo($id)
    {
        $propuesta = Propuesta::find($id);
        return Storage::download($propuesta->archivo);
    }
}
