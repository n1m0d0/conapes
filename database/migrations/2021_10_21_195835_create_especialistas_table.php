<?php

use App\Models\Especialista;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialistas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sector_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('estado', [Especialista::ACTIVO, Especialista::INACTIVO])->default(Especialista::ACTIVO);
            $table->timestamps();

            $table->foreign('sector_id')->references('id')->on('sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialistas');
    }
}
