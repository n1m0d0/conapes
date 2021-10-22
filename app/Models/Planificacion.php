<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planificacion extends Model
{
    use HasFactory;

    public const ACTIVO = 1;
    public const INACTIVO = 2;

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
