<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mes')->delete();
        DB::table('mes')->insert(
            array(
                array(
                    'identificador' => '1',
                    'mes' => 'Enero',
                ),
                array(
                    'identificador' => '2',
                    'mes' => 'Febrero',
                ),
                array(
                    'identificador' => '3',
                    'mes' => 'Marzo',
                ),
                array(
                    'identificador' => '4',
                    'mes' => 'Abril',
                ),
                array(
                    'identificador' => '5',
                    'mes' => 'Mayo',
                ),
                array(
                    'identificador' => '6',
                    'mes' => 'Junio',
                ),
                array(
                    'identificador' => '7',
                    'mes' => 'Junlio',
                ),
                array(
                    'identificador' => '8',
                    'mes' => 'Agosto',
                ),
                array(
                    'identificador' => '9',
                    'mes' => 'Septiembre',
                ),
                array(
                    'identificador' => '10',
                    'mes' => 'Octubre',
                ),
                array(
                    'identificador' => '11',
                    'mes' => 'Noviembre',
                ),
                array(
                    'identificador' => '12',
                    'mes' => 'Diciembre',
                )


            )
        );
    }
}
