<?php

namespace Database\Seeders;

use App\Models\Portafolio;
use Illuminate\Database\Seeder;

class PortafolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Relaciones Exteriores";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de la Presidencia";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Gobierno";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Defensa";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Planificación del Desarrollo";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Economía y Finanzas Publicas";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Hidrocarburos";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Desarrollo Productivo y Economía Plural";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Obras Públicas Servicios y Vivienda";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Minería y Metalurgia";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Justicia y Transparencia Institucional";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Trabajo Empleo y Previsión Socialas";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Salud y Deportes";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Medio Ambiente y Agua";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Educación";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Desarrollo Rural y Tierras";
        $portafolio->save();

        $portafolio = new Portafolio();
        $portafolio->nombre = "Ministerio de Culturas, Descolonización y Despatriarcalización";
        $portafolio->save();
    }
}
