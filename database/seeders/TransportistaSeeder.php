<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transportes')->delete();
        DB::table('transportes')->insert(
            array(
                array(
                    'id' => '1',
                    'ruc' => '10735314826',
                    'razon_social' => 'Hermanos soto S.A.C',
                    'direccion' => 'Av. america sur mz. g lt.2',
                    'celular' => '953187894',
                    'empresas_id' => '4',


                ),
                array(
                    'id' => '2',
                    'ruc' => '10805662395',
                    'razon_social' => 'Grupo los heraldos negros S.A.C',
                    'direccion' => 'Av. el pasaje verde mz. g lt.2',
                    'celular' => '953187894',
                    'empresas_id' => '4',


                ),
                array(
                    'id' => '3',
                    'ruc' => '1455454545',
                    'razon_social' => 'Consorcia Minero Nuevo Horizonte S.A.C',
                    'direccion' => 'Av. los paujiles mz. g lt.2',
                    'celular' => '953187894',
                    'empresas_id' => '4',


                ),



            )
        );
    }
}
