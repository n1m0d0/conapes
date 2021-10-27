<?php

namespace App\Http\Livewire;

use App\Models\Formulario;
use App\Models\Generado;
use Livewire\Component;
use App\Models\Propuesta;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ComponenteFormulario extends Component
{
    use WithPagination;

    public $busqueda;
    public $user_id;
    public $propuesta_id;
    public $formulario_id;
    public $cabecera;
    public $cuerpo;
    public $agregarModal = false;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        $propuestaQuery = Propuesta::query();
        if ($this->busqueda != null) {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('estado', 2)->where('nombre', 'LIKE', "%$this->busqueda%");
            })->where('estado', '!=', 5);
        } else {
            $propuestaQuery = $propuestaQuery->whereHas('planificacion', function ($query) {
                $query->where('estado', 2);
            })->where('estado', '!=', 5);
        }
        $propuestas = $propuestaQuery->orderBy('id', 'DESC')->paginate(4);
        $formularios = Formulario::where('estado', 1)->get();
        return view('livewire.componente-formulario', compact('propuestas', 'formularios'));
    }

    public function agregar()
    {
        $this->validate([
            'formulario_id' => 'required',
            'cabecera' => 'required',
            'cuerpo' => 'required'
        ]);
        $generado = new Generado();
        $generado->user_id = $this->user_id;
        $generado->propuesta_id = $this->propuesta_id;
        $generado->formulario_id = $this->formulario_id;
        $generado->cabecera = $this->cabecera;
        $generado->cuerpo = $this->cuerpo;
        $generado->save();

        $this->limpiar();
        $this->mensaje();
        $this->agregarModal = false;
    }

    public function limpiar()
    {
        $this->reset(['formulario_id', 'cabecera', 'cuerpo']);
    }

    public function reiniciar()
    {
        $this->reset(['busqueda']);
    }

    public function modalAgregar($id)
    {
        $this->propuesta_id = $id;
        $this->agregarModal = true;
    }

    public function descargarArchivo($id)
    {
        $propuesta = Propuesta::find($id);
        return Storage::download($propuesta->archivo);
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
