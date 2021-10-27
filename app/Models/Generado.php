<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generado extends Model
{
    use HasFactory;

    public const ACTIVO = 1;
    public const INACTIVO = 2;

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class);
    }

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }
}
