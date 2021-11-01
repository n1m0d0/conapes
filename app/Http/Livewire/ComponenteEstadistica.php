<?php

namespace App\Http\Livewire;

use App\Models\Portafolio;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ComponenteEstadistica extends Component
{
    public $estado;
    public $cartera;
    public function mount()
    {
        $this->estado = DB::table('propuestas')
            ->select('estado', DB::raw('count(*) AS total'))
            ->groupBy('estado')
            ->get();

        $propuestaQuery = Portafolio::query();
        $propuestaQuery = $propuestaQuery->whereHas('planificaciones', function ($query) {
            $query->where('estado', 2);
        });

        $p = DB::table('planificacions')
            ->join('portafolios', 'planificacions.portafolio_id', '=', 'portafolios.id')           
            ->select('portafolios.nombre', DB::raw('count(*) AS total'))
            ->where('planificacions.estado', 2)
            ->groupBy('nombre')
            ->get();

        $this->cartera = $p;
    }
    public function render()
    {
        return view('livewire.componente-estadistica');
    }
}
