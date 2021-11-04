<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sector = new Sector();
        $sector->nombre = "Salud";
        $sector->save();

        $sector = new Sector();
        $sector->nombre = "Tecnologia";
        $sector->save();

        $sector = new Sector();
        $sector->nombre = "Economia";
        $sector->save();
    }
}
