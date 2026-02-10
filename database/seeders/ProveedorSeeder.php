<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proveedors')->delete();
        DB::table('proveedors')->insert(
            array(
                array(
                    'id' => '1',
                    'ruc' => '4557878457',
                    'razon_social' => 'Transportes y servicios candi S.A.C ',
                    'direccion' => '',
                    'empresas_id' => '4',

                ),
                array(
                    'id' => '2',
                    'ruc' => '4557878457',
                    'razon_social' => 'Servicios los heraldos S.A.C ',
                    'direccion' => '',
                    'empresas_id' => '4',

                ),
                array(
                    'id' => '3',
                    'ruc' => '4557878457',
                    'razon_social' => 'Contratista y servicios LI S.A.C',
                    'direccion' => '',
                    'empresas_id' => '4',

                ),


            )
        );
    }
}
