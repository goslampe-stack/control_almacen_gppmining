<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class PermisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('permissions')->insert(
            array(
                array(
                    'id' => '1',
                    'name' => 'Module Create',
                    'type' => 'module',
                    'permission_key' => 'module-create',
                ),
                array(
                    'id' => '2',
                    'name' => 'Module View',
                    'type' => 'module',
                    'permission_key' => 'module-list',
                ),
                array(
                    'id' => '3',
                    'name' => 'Module Delete',
                    'type' => 'module',
                    'permission_key' => 'module-delete',
                ),
                array(
                    'id' => '4',
                    'name' => 'Module Edit',
                    'type' => 'module',
                    'permission_key' => 'module-edit',
                ),
                array(
                    'id' => '5',
                    'name' => 'Role View',
                    'type' => 'role',
                    'permission_key' => 'role-list',
                ),
                array(
                    'id' => '6',
                    'name' => 'Role Create',
                    'type' => 'role',
                    'permission_key' => 'role-create',
                ),
                array(
                    'id' => '7',
                    'name' => 'Permission Asign',
                    'type' => 'permission',
                    'permission_key' => 'permission-asign',
                ),
                array(
                    'id' => '8',
                    'name' => 'Permission Create',
                    'type' => 'permission',
                    'permission_key' => 'permission-create',
                ),
                array(
                    'id' => '9',
                    'name' => 'Permission Views',
                    'type' => 'permission',
                    'permission_key' => 'permission-list',
                ),
                array(
                    'id' => '10',
                    'name' => 'Permission Edit',
                    'type' => 'permission',
                    'permission_key' => 'permission-edit',
                ),
                array(
                    'id' => '11',
                    'name' => 'Permission Delete',
                    'type' => 'permission',
                    'permission_key' => 'permission-delete',
                ),
                array(
                    'id' => '12',
                    'name' => 'Usuario Lista',
                    'type' => 'user',
                    'permission_key' => 'user-list',
                ),
                array(
                    'id' => '13',
                    'name' => 'Usuario Crear',
                    'type' => 'user',
                    'permission_key' => 'user-create',
                ),
                array(
                    'id' => '14',
                    'name' => 'Usuario Editar',
                    'type' => 'user',
                    'permission_key' => 'user-edit',
                ),
                array(
                    'id' => '15',
                    'name' => 'Usuario Eliminar',
                    'type' => 'user',
                    'permission_key' => 'user-delete',
                ),
                //Unidad Medida
                array(
                    'id' => '16',
                    'name' => 'Unidad Medida Lista',
                    'type' => 'tipo-unidad',
                    'permission_key' => 'tipo-unidad-list',
                ),
                array(
                    'id' => '17',
                    'name' => 'Unidad Medida Crear',
                    'type' => 'tipo-unidad',
                    'permission_key' => 'tipo-unidad-create',
                ),
                array(
                    'id' => '18',
                    'name' => 'Unidad Medida Editar',
                    'type' => 'tipo-unidad',
                    'permission_key' => 'tipo-unidad-edit',
                ),
                array(
                    'id' => '19',
                    'name' => 'Unidad Medida Eliminar',
                    'type' => 'tipo-unidad',
                    'permission_key' => 'tipo-unidad-delete',
                ),
                //Articulo
                array(
                    'id' => '20',
                    'name' => 'Articulo Lista',
                    'type' => 'articulo',
                    'permission_key' => 'articulo-list',
                ),
                array(
                    'id' => '21',
                    'name' => 'Articulo Crear',
                    'type' => 'articulo',
                    'permission_key' => 'articulo-create',
                ),
                array(
                    'id' => '22',
                    'name' => 'Articulo Editar',
                    'type' => 'articulo',
                    'permission_key' => 'articulo-edit',
                ),
                array(
                    'id' => '23',
                    'name' => 'Articulo Eliminar',
                    'type' => 'articulo',
                    'permission_key' => 'articulo-delete',
                ),
                //requerimiento-personal
                array(
                    'id' => '24',
                    'name' => 'Requerimiento Personal Lista',
                    'type' => 'requerimiento-personal',
                    'permission_key' => 'requerimiento-personal-list',
                ),
                array(
                    'id' => '25',
                    'name' => 'Requerimiento Personal Crear',
                    'type' => 'requerimiento-personal',
                    'permission_key' => 'requerimiento-personal-create',
                ),
                array(
                    'id' => '26',
                    'name' => 'Requerimiento Personal Editar',
                    'type' => 'requerimiento-personal',
                    'permission_key' => 'requerimiento-personal-edit',
                ),
                array(
                    'id' => '27',
                    'name' => 'Requerimiento Personal Eliminar',
                    'type' => 'requerimiento-personal',
                    'permission_key' => 'requerimiento-personal-delete',
                ),
                //Orden De Compra
                array(
                    'id' => '28',
                    'name' => 'Orden De Compra Lista',
                    'type' => 'orden-compra',
                    'permission_key' => 'orden-compra-list',
                ),
                array(
                    'id' => '29',
                    'name' => 'Orden De Compra Crear',
                    'type' => 'orden-compra',
                    'permission_key' => 'orden-compra-create',
                ),
                array(
                    'id' => '30',
                    'name' => 'Orden De Compra Editar',
                    'type' => 'orden-compra',
                    'permission_key' => 'orden-compra-edit',
                ),
                array(
                    'id' => '31',
                    'name' => 'Orden De Compra Eliminar',
                    'type' => 'orden-compra',
                    'permission_key' => 'orden-compra-delete',
                ),
                //liquidacion
                array(
                    'id' => '32',
                    'name' => 'Ingreso Lista',
                    'type' => 'ingreso',
                    'permission_key' => 'ingreso-list',
                ),
                array(
                    'id' => '33',
                    'name' => 'Ingreso Crear',
                    'type' => 'ingreso',
                    'permission_key' => 'ingreso-create',
                ),
                array(
                    'id' => '34',
                    'name' => 'Ingreso Editar',
                    'type' => 'ingreso',
                    'permission_key' => 'ingreso-edit',
                ),
                array(
                    'id' => '35',
                    'name' => 'Ingreso  Eliminar',
                    'type' => 'ingreso',
                    'permission_key' => 'ingreso-delete',
                ),
                //Salidas
                array(
                    'id' => '36',
                    'name' => 'Salida  Lista',
                    'type' => 'salida',
                    'permission_key' => 'salida-list',
                ),
                array(
                    'id' => '37',
                    'name' => 'Salida Crear',
                    'type' => 'salida',
                    'permission_key' => 'salida-create',
                ),
                array(
                    'id' => '38',
                    'name' => 'Salida Editar',
                    'type' => 'salida',
                    'permission_key' => 'salida-edit',
                ),
                array(
                    'id' => '39',
                    'name' => 'Salida Eliminar',
                    'type' => 'salida',
                    'permission_key' => 'salida-delete',

                ),
                /* Role */
                array(
                    'id' => '40',
                    'name' => 'Rol modulo Eliminar',
                    'type' => 'role_module',
                    'permission_key' => 'role_module-delete',
                ),
                array(
                    'id' => '41',
                    'name' => 'Rol modulo creare',
                    'type' => 'role_module',
                    'permission_key' => 'role_module-create',
                ),
                array(
                    'id' => '42',
                    'name' => 'Rol modulo list',
                    'type' => 'role_module',
                    'permission_key' => 'role_module-list',
                ),
                array(
                    'id' => '43',
                    'name' => 'Rol modulo update',
                    'type' => 'role_module',
                    'permission_key' => 'role_module-update',
                ),
                /* Princiaal */
                array(
                    'id' => '44',
                    'name' => 'Principal',
                    'type' => 'dashboard',
                    'permission_key' => 'dashboard-list',
                ),
                /* requerimiento-personal */
                array(
                    'id' => '45',
                    'name' => 'requerimiento-personal profile',
                    'type' => 'requerimiento-personal',
                    'permission_key' => 'requerimiento-personal-profile',
                ),
                /* Kardex */
                array(
                    'id' => '46',
                    'name' => 'Kardex Lista',
                    'type' => 'kardex',
                    'permission_key' => 'kardex-list',
                ),
                array(
                    'id' => '47',
                    'name' => 'Kardex Crear',
                    'type' => 'kardex',
                    'permission_key' => 'kardex-create',
                ), array(
                    'id' => '48',
                    'name' => 'Kardex Editar',
                    'type' => 'kardex',
                    'permission_key' => 'kardex-edit',
                ), array(
                    'id' => '49',
                    'name' => 'Kardex Eliminar',
                    'type' => 'kardex',
                    'permission_key' => 'kardex-delete',
                ),
                /* Proveedor */
                array(
                    'id' => '50',
                    'name' => 'Proveedor Crear',
                    'type' => 'proveedor',
                    'permission_key' => 'proveedor-create',
                ), array(
                    'id' => '51',
                    'name' => 'Proveedor Editar',
                    'type' => 'proveedor',
                    'permission_key' => 'proveedor-edit',
                ), array(
                    'id' => '52',
                    'name' => 'Proveedor Eliminar',
                    'type' => 'proveedor',
                    'permission_key' => 'proveedor-delete',
                ), array(
                    'id' => '53',
                    'name' => 'Proveedor Lista',
                    'type' => 'proveedor',
                    'permission_key' => 'proveedor-list',
                ),
                /* Transporte */
                array(
                    'id' => '54',
                    'name' => 'Transporte Crear',
                    'type' => 'transporte',
                    'permission_key' => 'transporte-create',
                ), array(
                    'id' => '55',
                    'name' => 'Transporte  Editar',
                    'type' => 'transporte',
                    'permission_key' => 'transporte-edit',
                ), array(
                    'id' => '56',
                    'name' => 'Transporte  Eliminar',
                    'type' => 'transporte',
                    'permission_key' => 'transporte-delete',
                ), array(
                    'id' => '57',
                    'name' => 'Transporte  Lista',
                    'type' => 'transporte',
                    'permission_key' => 'transporte-list',
                ),
                /* Personal */
                array(
                    'id' => '58',
                    'name' => 'Personal Crear',
                    'type' => 'personal',
                    'permission_key' => 'personal-create',
                ), array(
                    'id' => '59',
                    'name' => 'Personal  Editar',
                    'type' => 'personal',
                    'permission_key' => 'personal-edit',
                ), array(
                    'id' => '60',
                    'name' => 'Personal  Eliminar',
                    'type' => 'personal',
                    'permission_key' => 'personal-delete',
                ), array(
                    'id' => '61',
                    'name' => 'Personal  Lista',
                    'type' => 'personal',
                    'permission_key' => 'personal-list',
                ),
                /* Empresa */
                array(
                    'id' => '62',
                    'name' => 'Empresa Crear',
                    'type' => 'empresa',
                    'permission_key' => 'empresa-create',
                ), array(
                    'id' => '63',
                    'name' => 'Empresa  Editar',
                    'type' => 'empresa',
                    'permission_key' => 'empresa-edit',
                ), array(
                    'id' => '64',
                    'name' => 'Empresa  Eliminar',
                    'type' => 'empresa',
                    'permission_key' => 'empresa-delete',
                ), array(
                    'id' => '65',
                    'name' => 'Empresa  Lista',
                    'type' => 'empresa',
                    'permission_key' => 'empresa-list',
                ),
                 //Salidas
                 array(
                    'id' => '66',
                    'name' => 'Devolucion  Lista',
                    'type' => 'devolucion',
                    'permission_key' => 'devolucion-list',
                ),
                array(
                    'id' => '67',
                    'name' => 'Devolucion Crear',
                    'type' => 'devolucion',
                    'permission_key' => 'devolucion-create',
                ),
                array(
                    'id' => '68',
                    'name' => 'Devolucion Editar',
                    'type' => 'devolucion',
                    'permission_key' => 'devolucion-edit',
                ),
                array(
                    'id' => '69',
                    'name' => 'Devolucion Eliminar',
                    'type' => 'devolucion',
                    'permission_key' => 'devolucion-delete',

                ),
              
            )
        );
    }
}
