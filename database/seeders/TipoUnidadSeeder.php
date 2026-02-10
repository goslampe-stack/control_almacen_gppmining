<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_unidads')->delete();
        DB::table('tipo_unidads')->insert(
            array(
                array(
                    'id' => '1',
                    'nombre' => 'Unidades',
                    'empresas_id' => '4',

                ),
                array(
                    'id' => '2',
                    'nombre' => 'Metros',
                    'empresas_id' => '4',

                ),
                array(
                    'id' => '3',
                    'nombre' => 'Centimertos',
                    'empresas_id' => '4',


                ),



            )
        );
    }
}
