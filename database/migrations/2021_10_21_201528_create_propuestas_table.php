<?php

use App\Models\Propuesta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planificacion_id');
            $table->date('fecha_ingreso');
            $table->enum('prioridad', [Propuesta::ALTA, Propuesta::MEDIA, Propuesta::BAJA]);
            $table->unsignedBigInteger('sector_id');
            $table->string('archivo');
            $table->unsignedBigInteger('documento_id');
            $table->enum('estado', [Propuesta::REGISTRADO, Propuesta::REVISION, Propuesta::APROBADO, Propuesta::REPROBADO, Propuesta::INACTIVO])->default(Propuesta::REGISTRADO);
            $table->timestamps();

            $table->foreign('planificacion_id')->references('id')->on('planificacions');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('documento_id')->references('id')->on('documentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propuestas');
    }
}
