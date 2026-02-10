<?php

namespace Database\Seeders;

use App\Models\Util;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personals')->delete();
        DB::table('personals')->insert(
            array(
                array(
                    'id' => '1',
                    'nombre' => 'Elmer',
                    'apellidos' => 'Garcia Huaman',
                    'tipo_documento' => 'DNI',
                    'numero_documento' => '953187894',
                    'genero' => 'Masculino',
                    'sucursal_empresas_id' => '1',
                    'tipoPersonals_Id' => '1',
                    'imagen' => Util::getImagenFirmaDigitalDefecto(),
                ),

                array(
                    'id' => '2',
                    'nombre' => 'Levi Roberto',
                    'apellidos' => 'Velasquez Paz',
                    'tipo_documento' => 'DNI',
                    'numero_documento' => '951117894',
                    'genero' => 'Masculino',
                    'sucursal_empresas_id' => '1',
                    'tipoPersonals_Id' => '2',
                    'imagen' => Util::getImagenFirmaDigitalDefecto(),

                ),

                array(
                    'id' => '3',
                    'nombre' => 'Antonio Smith',
                    'apellidos' => 'Aburto Cortez',
                    'tipo_documento' => 'DNI',
                    'numero_documento' => '9531871894',
                    'genero' => 'Masculino',
                    'sucursal_empresas_id' => '1',
                    'tipoPersonals_Id' => '3',
                    'imagen' => Util::getImagenFirmaDigitalDefecto(),

                ),
            )
        );
    }
}
