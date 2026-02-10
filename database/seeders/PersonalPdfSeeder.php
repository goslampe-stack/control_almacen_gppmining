<?php

namespace Database\Seeders;

use App\Models\Util;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalPdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personal_pdfs')->delete();
        DB::table('personal_pdfs')->insert(
            array(
                array(
                    'id' => '1',
                    'tipo_opcion' => Util::$OPCION_REQUERIMIENTO_PERSONAL,
                    'sucursal_empresas_id' => '1',
                    'personals_id' => '1',

                ),
                array(
                    'id' => '2',
                    'tipo_opcion' => 'Orden de compra',
                    'sucursal_empresas_id' => '1',
                    'personals_id' => '2',


                ),
                array(
                    'id' => '3',
                    'tipo_opcion' => 'Ingreso',
                    'sucursal_empresas_id' => '1',
                    'personals_id' => '3',



                ),
                array(
                    'id' => '4',
                    'tipo_opcion' => 'Salida',
                    'sucursal_empresas_id' => '1',
                    'personals_id' => '3',
                ),
                array(
                    'id' => '5',
                    'tipo_opcion' => 'Kardex',
                    'sucursal_empresas_id' => '1',
                    'personals_id' => '3',
                ),



            )
        );
    }
}
