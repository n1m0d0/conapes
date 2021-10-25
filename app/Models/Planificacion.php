<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planificacion extends Model
{

    protected $table = 'planificacions';

    protected $fillable = [
        'user_id',
        'planicicacion_id',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin'
    ];

    use HasFactory;

    public const REGISTRADO = 1;
    public const ACTIVO = 2;
    public const INACTIVO = 3;

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function propuestas()
    {
        return $this->hasMany(Propuesta::class);
    }
}
