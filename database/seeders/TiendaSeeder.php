<?php

namespace Database\Seeders;

use App\Models\Util;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->delete();
        DB::table('empresas')->insert(
            array(
                array(
                    'id' => '1',
                    'ruc' => '145545454545',
                    'razon_social' => 'Goslam corporatión S.A.C',
                    'encargado' => 'levi',
                    'celular' => '953187894',
                    'users_id' => '4',
                    'imagen' => Util::getImagenFirmaDigitalDefecto(),
                ),

            )
        );
    }
}
