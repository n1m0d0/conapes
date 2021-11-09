<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Planificacion;
use App\Models\Portafolio;

class ComponentePlanificacion extends Component
{
    use WithPagination;

    public $busqueda;
    public $user_id;
    public $portafolio_id;
    public $nombre;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $nuevoModal = false;
    public $editarModal = false;
    public $eliminarModal = false;
    public $planificacion_id;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        $portafolios = Portafolio::where('estado', Portafolio::ACTIVO)->get();
        $planQuery = Planificacion::query();
        if ($this->busqueda != null) {
            $planQuery = $planQuery->where('nombre', "LIKE", "%$this->busqueda%");
        }
        $planQuery = $planQuery->where('user_id', $this->user_id)->where('estado', Planificacion::REGISTRADO);
        $planificaciones = $planQuery->orderBy('id', 'DESC')->paginate(4);
        return view('livewire.componente-planificacion', compact('planificaciones', 'portafolios'));
    }

    public function nuevo()
    {
        $this->validate([
            'portafolio_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        $planificacion = new Planificacion();
        $planificacion->user_id = $this->user_id;
        $planificacion->portafolio_id = $this->portafolio_id;
        $planificacion->nombre = $this->nombre;
        $planificacion->descripcion = $this->descripcion;
        $planificacion->fecha_inicio = $this->fecha_inicio;
        $planificacion->fecha_fin = $this->fecha_fin;
        $planificacion->save();

        $this->nuevoModal = false;
        $this->limpiar();
        $this->mensaje();
    }

    public function editar()
    {
        $this->validate([
            'portafolio_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);
        $planificacion = Planificacion::find($this->planificacion_id);
        $planificacion->portafolio_id = $this->portafolio_id;
        $planificacion->nombre = $this->nombre;
        $planificacion->descripcion = $this->descripcion;
        $planificacion->fecha_inicio = $this->fecha_inicio;
        $planificacion->fecha_fin = $this->fecha_fin;
        $planificacion->save();

        $this->editarModal = false;
        $this->limpiar();
        $this->mensaje();
    }

    public function eliminar()
    {
        $dato = Planificacion::find($this->planificacion_id);
        $dato->estado = Planificacion::INACTIVO;
        $dato->save();

        $this->mensajeEliminacion();
        $this->eliminarModal = false;
    }

    public function limpiar()
    {
        $this->reset(['portafolio_id', 'nombre', 'descripcion', 'fecha_inicio', 'fecha_fin']);
    }

    public function reiniciar()
    {
        $this->reset(['busqueda']);
    }

    public function modalCrear() 
    {
        $this->limpiar();
        $this->nuevoModal = true;
    }

    public function modalActualizar($id) 
    {
        $this->limpiar();
        $this->planificacion_id = $id;
        $planificacion = Planificacion::find($id);
        $this->portafolio_id = $planificacion->portafolio_id;        
        $this->nombre = $planificacion->nombre;
        $this->descripcion = $planificacion->descripcion;
        $this->fecha_inicio = $planificacion->fecha_inicio;
        $this->fecha_fin = $planificacion->fecha_fin;
        $this->editarModal = true;
    }

    public function modalEliminar($id) 
    {
        $this->planificacion_id = $id;
        $this->eliminarModal = true;
    }

    public function mensaje()
    {
        $this->dispatchBrowserEvent('alert', ['mensaje' => 'Se registro correctamente']);
    }

    public function mensajeEliminacion()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'Se elimino el registro correctamente']);
    }
}
