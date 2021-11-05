<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use App\Models\Generado;
use App\Models\Propuesta;
use App\Models\Formulario;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\SimpleType\Jc;

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
            $phpWord->getCompatibility()->setOoxmlVersion(15);
            $phpWord->getSettings()->setThemeFontLang(new Language("ES_ES"));

            $section = $phpWord->addSection();

            //$header = $section->addHeader();
            //$header->addImage(asset('image/NUEVO_LOGO_MPD_2021.png'));

            $fontTitle = [
                "name" => "Tahoma",
                "size" => 11,
                "color" => "000000",
                "italic" => false,
                "bold" => true,
            ];

            $phpWord->addTitleStyle(1, $fontTitle, [ "alignment" => Jc::CENTER ]);
            $section->addTitle($formulario->nombre, 1);
            $section->addTitle("MPD/UDAPE-NI 0701/2021", 1);

            $fontText = [
                "name" => "Tahoma",
                "size" => 11,
                "color" => "000000",
                "italic" => false,
                "bold" => false,
            ];

            $fontTextBold = [
                "name" => "Tahoma",
                "size" => 11,
                "color" => "000000",
                "italic" => false,
                "bold" => true,
            ];

            $textRun = $section->addTextRun([
                "alignment" => Jc::BOTH,
                "lineHeight" => 1, # Quedará muy pegado
            ]);

            $textRun->addTextBreak(4);
            $textRun->addText("Señor Notario de Fé Pública, en el registro de escrituras públicas que corren a su cargo sirvase insertar un ACUERDO TRANSACCIONAL, el cual se rige al tenor de las siguientes cláusulas:", $fontText);
            $textRun->addTextBreak(2);
            $textRun->addText("PRIMERA. (LAS PARTES).- ", $fontTextBold);
            $textRun->addText("Intervienen el presente contrato: Sergio Cortez Colque, boliviano, mayor de edad, hábil por derecho, con cédula de identidad N° 3518509 Oruro, domiciliado en el pasaje 19 y Teniente N° 6495 de la zona de Obrajes de La Paz y; – – Henry Ezequiel Arancibia Nuñez, boliviano, mayor de edad, hábil por derecho, con cédula identidad N° 4043233 Oruro, con domicilio en la calle Ocobaya N° 244 de la zona Villa Fátima de la ciudad La Paz, conforme a las siguientes estipulaciones:", $fontText);
            $textRun->addTextBreak(2);
            $textRun->addText("SEGUNDA. (ANTECEDENTES).- ", $fontTextBold);
            $textRun->addText("En fecha 3 de enero del año 2017, el Sr. Sergio Cortez interpuso una denuncia contra del Sr. Arancibia por el delito de estafa misma que se encuentra en el Ministerio Público con el N° de caso: LPZ1715913 y cuaderno de control jurisdiccional en el Tribunal Departamental de Justicia de la ciudad de La Paz con NUREJ: 20164701. – – El Sr. Sergio Cortez Colque, ha visto por conveniente concluir todas las controversias relacionadas anteriormente, habiendo solicitado al Señor Henry Ezequiel Arancibia Nuñez, arribar al presente acuerdo definitivo precautelando el interés de todas las partes quienes han aceptado la solución conciliatoria y transaccional de este asunto.", $fontText);
            $textRun->addTextBreak(2);
            $textRun->addText("TERCERA. (OBJETO).- ", $fontTextBold);
            $textRun->addText("El presente acuerdo suscrito entre el Sr. Sergio Cortez Colque y el señor Henry Ezequiel Arancibia Nuñez tiene por objeto extinguir de manera amistosa las controversias administrativas y judiciales suscitadas entre ambas partes en relación con el proceso que se halla ventilando en el Juzgado Noveno de Instrucción Cautelar de la ciudad de La Paz, así como la denuncia existente en el Ministerio Público.", $fontText);

            //$textRun->addImage(asset('image/NUEVO_LOGO_MPD_2021.png'));

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
        $this->limpiar();
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
