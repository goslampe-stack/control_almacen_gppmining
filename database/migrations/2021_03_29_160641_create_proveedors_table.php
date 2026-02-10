<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ruc');
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('referencia')->nullable();
            $table->string('celular')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(1);
            
            $table->integer('empresas_id')->nullable()->unsigned();
            $table->foreign('empresas_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('proveedors');
    }
}
