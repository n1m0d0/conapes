<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Portafolio;

class CreatePortafoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portafolios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('estado', [Portafolio::ACTIVO, Portafolio::INACTIVO])->default(Portafolio::ACTIVO);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portafolios');
    }
}
