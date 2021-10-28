<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ComponenteEstadistica extends Component
{
    public $propuestas;
    public function mount()
    {
        $this->propuestas = DB::table('propuestas')
        ->select('estado', DB::raw('count(*) AS total'))
        ->groupBy('estado')
        ->get();
    }
    public function render()
    {
        
        return view('livewire.componente-estadistica');
    }
}
