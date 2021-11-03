<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;

use Livewire\Component;

class ComponenteCalendario extends Component
{
    public function render()
    {
        $p = DB::table('planificacions')
            ->select('planificacions.nombre AS title', 'planificacions.fecha_inicio AS start', 'planificacions.fecha_fin AS end')
            ->where('planificacions.estado', '!=', 3)
            ->get();

        $eventos = $p;

        $p2 = DB::table('propuestas')
            ->join('planificacions', 'propuestas.planificacion_id', '=', 'planificacions.id')
            ->select('planificacions.nombre AS title', 'propuestas.fecha_ingreso AS start')
            ->where('propuestas.estado', '!=', 5)
            ->get();

        foreach ($p2 as $eve)
        {
            $eve->color = "purple";
        }

        $eventos = $p->merge($p2);
        return view('livewire.componente-calendario', compact('eventos'));
    }
}
