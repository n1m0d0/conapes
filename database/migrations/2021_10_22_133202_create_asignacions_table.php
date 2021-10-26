<?php

use App\Models\Asignacion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('propuesta_id');
            $table->enum('estado', [Asignacion::ACTIVO, Asignacion::INACTIVO])->default(Asignacion::ACTIVO);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('propuesta_id')->references('id')->on('propuestas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignacions');
    }
}
