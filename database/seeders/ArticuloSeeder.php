<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articulos')->delete();
        DB::table('articulos')->insert(
            array(
                array(
                    'id' => '1',
                    'codigo' => '0001',
                    'articulo' => 'Zapatos',
                    'tipo_unidads_id' => '1',
                    'empresas_id' => '4',
                ),
               
                array(
                    'id' => '2',
                    'codigo' => '0002',
                    'articulo' => 'Zandallas',
                    'tipo_unidads_id' => '1',
                    'empresas_id' => '4',

                ),
               
                array(
                    'id' => '3',
                    'codigo' => '0003',
                    'articulo' => 'cocina',
                    'tipo_unidads_id' => '1',
                    'empresas_id' => '4',

                ),
                array(
                    'id' => '4',
                    'codigo' => '004',
                    'articulo' => 'Carretilla',
                    'tipo_unidads_id' => '1',
                    'empresas_id' => '4',

                ),
                array(
                    'id' => '5',
                    'codigo' => '005',
                    'articulo' => 'Palanas',
                    'tipo_unidads_id' => '1',
                    'empresas_id' => '4',

                ),
               

             
            )
        );
    }
}
