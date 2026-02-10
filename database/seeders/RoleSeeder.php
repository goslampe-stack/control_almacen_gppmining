<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert(
            array(
                array(
                    'id' => '1',
                    'name' => 'Programador',
                    'state' => '1',
                ),
                array(
                    'id' => '2',
                    'name' => 'Administrador',
                    'state' => '1',

                ),
                array(
                    'id' => '3',
                    'name' => 'Super Administrador',
                    'state' => '1',
                ),

            )
        );
    }
}
