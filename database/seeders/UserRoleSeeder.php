<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->delete();
        DB::table('user_roles')->insert(
            array(
                array(
                    'id' => '1',
                    'role_id' => '1',
                    'user_id' => '1',
                ),

            )
        );
    }
}
