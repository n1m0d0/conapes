<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Paginas extends Controller
{
    public function planificacion()
    {
        return view('page.planificacion');
    }
}
