<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    public const ACTIVO = 1;
    public const INACTIVO = 2;

    public function propuestas()
    {
        return $this->hasMany(Propuesta::class);
    }
}
