<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
              $table->increments('id');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('celular')->nullable();
            $table->string('direccion')->nullable();
            $table->string('referencia')->nullable();
            $table->string('genero')->nullable();
            $table->string('fecha_nacimiento')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(1);

            $table->integer('sucursal_empresas_id')->nullable()->unsigned();
            $table->foreign('sucursal_empresas_id')->references('id')->on('sucursal_empresas')->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('tipoPersonals_Id')->nullable()->unsigned();
            $table->foreign('tipoPersonals_Id')->references('id')->on('tipo_personals')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('users_id')->nullable()->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('personals');
    }
}
