<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;

    public const ACTIVO = 1;
    public const INACTIVO = 2;
    
    public function generados()
    {
        return $this->hasMany(Generado::class);
    }
}
