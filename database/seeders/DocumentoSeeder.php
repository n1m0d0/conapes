<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documento = new Documento();
        $documento->nombre = "Decreto Supremo";
        $documento->save();

        $documento = new Documento();
        $documento->nombre = "Ley";
        $documento->save();
    }
}
