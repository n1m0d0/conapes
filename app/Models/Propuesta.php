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
    public const REGISTRADO = 1;
    public const REVISION = 2;
    public const APROBADO = 3;
    public const REPROBADO = 4;
    public const INACTIVO = 5;

    public function planificacion()
    {
        return $this->belongsTo(Planificacion::class);
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function asignacion()
    {
        return $this->hasMany(Asignacion::class);
    }
}
