<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    public const ACTIVO = 1;
    public const INACTIVO = 2;

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class);
    }

    public function especialista()
    {
        return $this->belongsTo(Especialista::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
