<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Planificacion;

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

    public function render()
    {
        $planQuery = Planificacion::query();
        if ($this->busqueda != null) {
            $planQuery = $planQuery->where('nombre', "LIKE", "%$this->busqueda%");
        }
        $planQuery = $planQuery->where('estado', 1);
        $planificaciones = $planQuery->paginate(4);
        return view('livewire.componente-planificacion', compact('planificaciones'));
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

        Planificacion::create([]);

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

        Planificacion::create([]);

        $this->limpiar();
    }

    public function eliminar($id)
    {
        $dato = Planificacion::find($id);
        $dato->estado = Planificacion::INACTIVO;
        $dato->save();
    }

    public function limpiar()
    {
        //$this->reset([]);
        $this->mensaje();
    }

    public function modalCrear() 
    {
        $this->nuevoModal = true;
    }

    public function mensaje()
    {
        $this->dispatchBrowserEvent('alert', ['mensaje' => 'Se registro correctamente']);
    }
}
