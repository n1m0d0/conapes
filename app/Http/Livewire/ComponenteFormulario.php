<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use App\Models\Generado;
use App\Models\Propuesta;
use App\Models\Formulario;
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
    public $generado_id;
    public $agregarModal = false;
    public $eliminarModal = false;

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

        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        $date = $date->format('d-m-Y');

        $aux = Generado::where('propuesta_id', $this->propuesta_id)->where('formulario_id', $this->formulario_id)->where('estado', Generado::ACTIVO)->get();
        if (!$aux->isEmpty()) {
            $this->limpiar();
            $this->mensajeAlerta();
        } else {
            $formulario = Formulario::find($this->formulario_id);

            $generado = new Generado();
            $generado->user_id = $this->user_id;
            $generado->propuesta_id = $this->propuesta_id;
            $generado->formulario_id = $this->formulario_id;
            $generado->cabecera = $this->cabecera;
            $generado->cuerpo = $this->cuerpo;

            $nombre_archivo = $formulario->nombre . ' ' . $date . '.docx';
            $pathToFile = storage_path('app/public/' . $nombre_archivo);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $properties = $phpWord->getDocInfo();
            $properties->setCreator(auth()->user()->name);
            $properties->setCompany('Ministerio de Planificacion');
            $properties->setTitle($formulario->nombre);

            $section = $phpWord->addSection();

            $description = "Formulario: " . $formulario->nombre;

            $section->addTitle($description);

            $description = "Esto es una prueba $this->cabecera y $this->cuerpo";

            $section->addText($description);

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $objWriter->save($pathToFile);
                //$objWriter->save('helloWorld.docx');
                $generado->archivo = 'public/' . $nombre_archivo;
            } catch (Exception $e) {
            }

            $generado->save();

            $this->limpiar();
            $this->mensaje();
        }
        $this->agregarModal = false;
    }

    public function eliminar()
    {
        $generado = Generado::find($this->generado_id);
        $generado->estado = Generado::INACTIVO;
        $generado->save();

        $this->mensajeEliminacion();
        $this->eliminarModal = false;
    }

    public function modalEliminar($id)
    {
        $this->generado_id = $id;
        $this->eliminarModal = true;
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

    public function descargarFormulario($id)
    {
        $generado = Generado::find($id);
        return Storage::download($generado->archivo);
    }

    public function mensaje()
    {
        $this->dispatchBrowserEvent('alert', ['mensaje' => 'Se registro correctamente']);
    }

    public function mensajeEliminacion()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'Se elimino el registro correctamente']);
    }

    public function mensajeAlerta()
    {
        $this->dispatchBrowserEvent('delete', ['mensaje' => 'Ya se tiene ese Formulario']);
    }
}
