<?php

use App\Models\Planificacion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portafolio_id');
            $table->string('nombre');
            $table->tinyText('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', [Planificacion::ACTIVO, Planificacion::INACTIVO])->default(Planificacion::ACTIVO);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('portafolio_id')->references('id')->on('portafolios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planificacions');
    }
}
