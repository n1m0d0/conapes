<?php

use App\Models\Generado;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('propuesta_id');
            $table->unsignedBigInteger('formulario_id');
            $table->tinyText('cabecera');
            $table->tinyText('cuerpo');
            $table->enum('estado', [Generado::ACTIVO, Generado::INACTIVO]);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('propuesta_id')->references('id')->on('propuestas');
            $table->foreign('formulario_id')->references('id')->on('formularios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generados');
    }
}
