<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursal_empresas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nombre_sucursal')->nullable();
            $table->string('direccion')->nullable();
            $table->string('celular')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('encargado')->nullable();
            $table->string('imagen')->nullable();
            $table->string('identificador')->nullable();
            $table->boolean('estado')->default(1);

            $table->integer('users_id')->nullable()->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('empresas_id')->nullable()->unsigned();
            $table->foreign('empresas_id')->references('id')->on('empresas')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sucursal_empresas');
    }
}
