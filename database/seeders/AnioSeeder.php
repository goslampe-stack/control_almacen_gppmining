<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AnioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('anios')->delete();
        DB::table('anios')->insert(
            array(
                array(
                    'identificador' => '2019',
                    'anio' => '2019',
                ),
                array(
                    'identificador' => '2020',
                    'anio' => '2020',
                ),
                array(
                    'identificador' => '2021',
                    'anio' => '2021',
                ),
                array(
                    'identificador' => '2022',
                    'anio' => '2022',
                ),
                array(
                    'identificador' => '2023',
                    'anio' => '2023',
                ),
                array(
                    'identificador' => '2024',
                    'anio' => '2024',
                ),
                array(
                    'identificador' => '2025',
                    'anio' => '2025',
                ),

            )
        );
    }
}
