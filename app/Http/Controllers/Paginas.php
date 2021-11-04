<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Paginas extends Controller
{
    public function planificacion()
    {
        return view('page.planificacion');
    }

    public function propuesta()
    {
        return view('page.propuesta');
    }

    public function especialista()
    {
        return view('page.especialista');
    }

    public function formulario()
    {
        return view('page.formulario');
    }

    public function usuario()
    {
        return view('page.usuario');
    }
}
