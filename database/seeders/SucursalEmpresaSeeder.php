<?php

namespace Database\Seeders;

use App\Models\Util;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sucursal_empresas')->delete();
        DB::table('sucursal_empresas')->insert(
            array(
                array(
                    'id' => '1',
                    'nombre_sucursal' => 'Sucursal Trujillo',
                    'encargado' => 'Jairo Velasquez PAZ',
                    'direccion' => 'Av. Los paujilez Mz. g Lt. 1 Trujillo ',
                    'celular' => '953187894',
                    'empresas_id' => '1',
                    'users_id' => '4',
                    'imagen' => "https://res.cloudinary.com/velasquez-paz/image/upload/v1720139935/exzlwrsjijospsscbpbq.jpg",
                ),

            )
        );
    }
}
