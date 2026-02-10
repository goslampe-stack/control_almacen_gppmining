<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_personals')->delete();
        DB::table('tipo_personals')->insert(
            array(
                array(
                    'id' => '1',
                    'nombre' => 'Personal logistica',
                    'sucursal_empresas_id' => '1',

                ),
                array(
                    'id' => '2',
                    'nombre' => 'Almacenero',
                    'sucursal_empresas_id' => '1',

                ),
                array(
                    'id' => '3',
                    'nombre' => 'Jefe logística',
                    'sucursal_empresas_id' => '1',



                ),



            )
        );
    }
}
