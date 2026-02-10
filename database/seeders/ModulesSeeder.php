<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;





class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->delete();
        DB::table('modules')->insert(
            array(
                array(
                    'id' => '1',
                    'name' => 'Principal',
                    'module_key' => 'Dashboard',
                    'module_url' => 'dashboard',
                    'module_icon' => 'home',
                    'module_rank' => '0',
                    'view_sidebar' => '1',
                    'identity' => 'dashboard',
                    'opcion' => 'dashboard',
                ),
                array(
                    'id' => '2',
                    'name' => 'Unidad de medida',
                    'module_key' => 'unidad_medida_management',
                    'module_url' => 'tipo-unidad',
                    'module_icon' => 'user-plus',
                    'module_rank' => '1', //pertenecen  a ingreso
                    'view_sidebar' => '1',
                    'identity' => 'tipo-unidad',
                    'opcion' => 'entrada',

                ),
                array(
                    'id' => '3',
                    'name' => 'Artículo',
                    'module_key' => 'articulo_management',
                    'module_url' => 'articulo',
                    'module_icon' => 'user',
                    'module_rank' => '2', //pertenece a ingres 1
                    'view_sidebar' => '1',
                    'identity' => 'articulo',
                    'opcion' => 'entrada',

                ),
                array(
                    'id' => '4',
                    'name' => 'Requerimiento Personal',
                    'module_key' => 'requerimiento_personal_management',
                    'module_url' => 'requerimiento-personal',
                    'module_icon' => 'image',
                    'module_rank' => '3',
                    'view_sidebar' => '1',
                    'identity' => 'requerimiento-personal',
                    'opcion' => 'entrada',

                ),
                array(
                    'id' => '5',
                    'name' => 'Orden de compra',
                    'module_key' => 'orden_compra_management',
                    'module_url' => 'orden-compra',
                    'module_icon' => 'user-plus',
                    'module_rank' => '4',
                    'view_sidebar' => '1',
                    'identity' => 'orden-compra',
                    'opcion' => 'entrada',

                ),
                array(
                    'id' => '6',
                    'name' => 'Ingresos',
                    'module_key' => 'ingreso_management',
                    'module_url' => 'ingreso',
                    'module_icon' => 'users',
                    'module_rank' => '5',
                    'view_sidebar' => '1',
                    'identity' => 'ingreso',
                    'opcion' => 'entrada',

                ),
                array(
                    'id' => '7',
                    'name' => 'Salidas',
                    'module_key' => 'salida_management',
                    'module_url' => 'salida',
                    'module_icon' => 'speaker',
                    'module_rank' => '6',
                    'view_sidebar' => '1',
                    'identity' => 'salida',
                    'opcion' => 'salida',

                ),
                array(
                    'id' => '8',
                    'name' => 'Kardex',
                    'module_key' => 'kardex_management',
                    'module_url' => 'kardex',
                    'module_icon' => 'credit-card',
                    'module_rank' => '7',
                    'view_sidebar' => '1',
                    'identity' => 'kardex',
                    'opcion' => 'salida',

                ),
                array(
                    'id' => '9',
                    'name' => 'Proveedores',
                    'module_key' => 'proveedor_management',
                    'module_url' => 'proveedor',
                    'module_icon' => 'fa-users',
                    'module_rank' => '8',
                    'view_sidebar' => '1',
                    'identity' => 'proveedor',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '10',
                    'name' => 'Transporte',
                    'module_key' => 'transporte_management',
                    'module_url' => 'transporte',
                    'module_icon' => 'fa-users',
                    'module_rank' => '9',
                    'view_sidebar' => '1',
                    'identity' => 'transporte',
                    'opcion' => 'otros',

                ),

                array(
                    'id' => '11',
                    'name' => 'Personal',
                    'module_key' => 'personal_management',
                    'module_url' => 'personal',
                    'module_icon' => 'fa-users',
                    'module_rank' => '10',
                    'view_sidebar' => '1',
                    'identity' => 'personal',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '12',
                    'name' => 'Gestión de modulos',
                    'module_key' => 'module_management',
                    'module_url' => 'module',
                    'module_icon' => 'fa-box-open',
                    'module_rank' => '11',
                    'view_sidebar' => '1',
                    'identity' => 'module',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '13',
                    'name' => 'Gestión de roles',
                    'module_key' => 'role_management',
                    'module_url' => 'role',
                    'module_icon' => 'fa-box-open',
                    'module_rank' => '12',
                    'view_sidebar' => '1',
                    'identity' => 'role',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '14',
                    'name' => 'Gestión de permisos',
                    'module_key' => 'permission_management',
                    'module_url' => 'permission',
                    'module_icon' => 'fa-users',
                    'module_rank' => '13',
                    'view_sidebar' => '0',
                    'identity' => 'permission',
                    'opcion' => 'otros',


                ),
                array(
                    'id' => '15',
                    'name' => 'Gestión de usuarios',
                    'module_key' => 'user_management',
                    'module_url' => 'usuario',
                    'module_icon' => 'fa-users',
                    'module_rank' => '14',
                    'view_sidebar' => '1',
                    'identity' => 'user',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '16',
                    'name' => 'Gestión Rol Por Modulo',
                    'module_key' => 'role_module_management',
                    'module_url' => 'role-module',
                    'module_icon' => 'fa-truck',
                    'module_rank' => '15',
                    'view_sidebar' => '0',
                    'identity' => 'role_module',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '17',
                    'name' => 'Empresa',
                    'module_key' => 'empresa_management',
                    'module_url' => 'empresa',
                    'module_icon' => 'fa-users',
                    'module_rank' => '16',
                    'view_sidebar' => '1',
                    'identity' => 'empresa',
                    'opcion' => 'otros',

                ),
                array(
                    'id' => '18',
                    'name' => 'Información General',
                    'module_key' => 'informacion_general_management',
                    'module_url' => 'informacion',
                    'module_icon' => 'fa-users',
                    'module_rank' => '17',
                    'view_sidebar' => '1',
                    'identity' => 'informacion',
                    'opcion' => 'empresa',

                ),
                array(
                    'id' => '19',
                    'name' => 'Devoluciones',
                    'module_key' => 'devolucion_management',
                    'module_url' => 'devolucion',
                    'module_icon' => 'speaker',
                    'module_rank' => '18',
                    'view_sidebar' => '1',
                    'identity' => 'devolucion',
                    'opcion' => 'entrada',

                ),

            )
        );
    }
}
