<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
              $table->increments('id');
            $table->string('name',50);
            $table->string('last_name',150)->nullable();
            $table->string('dni',12)->nullable();
            $table->boolean('gender')->default(1); //1 masculino 0 femenino
            $table->string('phone',12)->nullable();
            $table->double('salary',5)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('empresa_seleccionada')->nullable();
            $table->string('sucursal_empresa_nombre')->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('tipoUsuario')->nullable();
            $table->string('empresas_id')->nullable();
            $table->string('cantidadEmpresas')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(1);
         
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
