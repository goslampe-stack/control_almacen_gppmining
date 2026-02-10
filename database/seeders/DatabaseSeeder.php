<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermisionsSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(RoleModulesSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(UserRoleSeeder::class);

        /*  
        $this->call(TipoUnidadSeeder::class);
     */
        $this->call(TipoUnidadSeeder::class);
        $this->call(TiendaSeeder::class);
        $this->call(ArticuloSeeder::class);
        $this->call(TransportistaSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(SucursalEmpresaSeeder::class);
        $this->call(TipoPersonalSeeder::class);
        $this->call(PersonalSeeder::class);
        $this->call(PersonalPdfSeeder::class);
    }
}
