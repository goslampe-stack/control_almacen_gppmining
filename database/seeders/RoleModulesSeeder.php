<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class 
RoleModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_modules')->delete();
        DB::table('role_modules')->insert(
            array(
                array(
                    'id' => '1',
                    'role_id' => '1',
                    'module_id' => '1',
                ),
                array(
                    'id' => '2',
                    'role_id' => '1',
                    'module_id' => '2',
                ),
                array(
                    'id' => '3',
                    'role_id' => '1',
                    'module_id' => '3',
                ),
                array(
                    'id' => '4',
                    'role_id' => '1',
                    'module_id' => '4',
                ),
                array(
                    'id' => '5',
                    'role_id' => '1',
                    'module_id' => '5',
                ),
                array(
                    'id' => '6',
                    'role_id' => '1',
                    'module_id' => '6',
                ),
                array(
                    'id' => '7',
                    'role_id' => '1',
                    'module_id' => '7',
                ),
                array(
                    'id' => '8',
                    'role_id' => '1',
                    'module_id' => '8',
                ),
                array(
                    'id' => '9',
                    'role_id' => '1',
                    'module_id' => '9',
                ), array(
                    'id' => '10',
                    'role_id' => '1',
                    'module_id' => '10',
                ), array(
                    'id' => '11',
                    'role_id' => '1',
                    'module_id' => '11',
                ), array(
                    'id' => '13',
                    'role_id' => '1',
                    'module_id' => '13',
                ), array(
                    'id' => '14',
                    'role_id' => '1',
                    'module_id' => '14',
                ), array(
                    'id' => '15',
                    'role_id' => '1',
                    'module_id' => '15',
                ), array(
                    'id' => '16',
                    'role_id' => '1',
                    'module_id' => '16',
                ), array(
                    'id' => '17',
                    'role_id' => '1',
                    'module_id' => '17',
                )
                , array(
                    'id' => '18',
                    'role_id' => '1',
                    'module_id' => '18',
                )
                , array(
                    'id' => '19',
                    'role_id' => '1',
                    'module_id' => '19',
                )
            )
        );
    }
}
