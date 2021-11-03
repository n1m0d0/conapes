<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;

use Livewire\Component;

class ComponenteCalendario extends Component
{
    public function render()
    {
        $planificaciones = DB::table('planificacions')
            ->select('planificacions.nombre AS title', 'planificacions.fecha_inicio AS start', 'planificacions.fecha_fin AS end')
            ->where('planificacions.estado', '!=', 3)
            ->get();

        $propuestas = DB::table('propuestas')
            ->join('planificacions', 'propuestas.planificacion_id', '=', 'planificacions.id')
            ->select('planificacions.nombre AS title', 'propuestas.fecha_ingreso AS start')
            ->where('propuestas.estado', '!=', 5)
            ->get();

        foreach ($propuestas as $propuesta)
        {
            $propuesta->color = "purple";
        }

        $eventos = $planificaciones->merge($propuestas);
        return view('livewire.componente-calendario', compact('eventos'));
    }
}
