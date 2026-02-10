<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(
            array(
                array(

                    'id' => '2',
                    'name' => '2',
                    'email' => 'luis12.t20@gmail.com',
                    'password' => bcrypt('975001450'),
                    'current_team_id' => '1',
                    'cantidadEmpresas' => '1',
                    'empresas_id' => '2',
                    'estado' => '1',
                    'tipoUsuario' => 'Programador',


                ),
                array(
                    'id' => '1',
                    'name' => '1',
                    'email' => 'l953187894@gmail.com',
                    'password' => bcrypt('123456'),
                    'current_team_id' => '1',
                    'cantidadEmpresas' => '1',
                    'empresas_id' => '1',
                    'estado' => '1',
                    'tipoUsuario' => 'Programador',

                ),
                array(
                    'id' => '3',
                    'name' => '3',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('123456'),
                    'current_team_id' => '1',
                    'cantidadEmpresas' => '1',
                    'empresas_id' => '3',
                    'estado' => '1',
                    'tipoUsuario' => 'Programador',


                ),
                array(
                    'id' => '4',
                    'name' => 'Pedro',
                    'email' => 'pedro@gmail.com',
                    'password' => bcrypt('123456'),
                    'current_team_id' => '1',
                    'cantidadEmpresas' => '1',
                    'empresas_id' => '4',
                    'estado' => '1',
                    'tipoUsuario' => 'Usuario',

                ),

            )
        );
    }
}
