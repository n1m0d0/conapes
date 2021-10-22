<?php

namespace App\Http\Livewire;

use App\Models\Planificacion;
use Livewire\Component;

class ComponentePlanificacion extends Component
{

    public $busqueda;

    public function render()
    {
        $planificaciones = Planificacion::query();
        if($this->busqueda != null){
            $planificaciones = $planificaciones->where('nombre', $this->busqueda);
        }
        $planificaciones = $planificaciones->where('estado', 1)->get();
        return view('livewire.componente-planificacion', compact('planificaciones'));
    }

    public function nuevo()
    {

    }
}
