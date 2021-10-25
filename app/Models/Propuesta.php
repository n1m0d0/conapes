<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propuesta extends Model
{
    use HasFactory;

    //prioridad
    public const ALTA = 1;
    public const MEDIA = 2;
    public const BAJA = 3;

    //estado
    public const REVISION = 1;
    public const APROBADO = 2;
    public const REPROBADO = 3;

    public function planificacion()
    {
        return $this->belongsTo(Planificacion::class);
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}
