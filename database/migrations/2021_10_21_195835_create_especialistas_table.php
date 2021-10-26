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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sector_id');
            $table->enum('estado', [Especialista::ACTIVO, Especialista::INACTIVO])->default(Especialista::ACTIVO);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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
