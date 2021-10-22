<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Planificacion;

class ComponentePlanificacion extends Component
{
    use WithPagination;

    public $busqueda;

    public function render()
    {
        $planQuery = Planificacion::query();
        if($this->busqueda != null){
            $planQuery = $planQuery->where('nombre', "LIKE", "%$this->busqueda%");
        }
        $planQuery = $planQuery->where('estado', 1);
        $planificaciones = $planQuery->paginate(4);
        return view('livewire.componente-planificacion', compact('planificaciones'));
    }

    public function nuevo()
    {

    }
}
