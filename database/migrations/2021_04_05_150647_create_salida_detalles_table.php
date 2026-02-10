<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fecha_salida')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('cierre_articulos_id')->nullable();
            $table->boolean('estado')->default(1);

            
            $table->integer('salidas_id')->nullable()->unsigned();
            $table->foreign('salidas_id')->references('id')->on('salidas')->onUpdate('cascade')->onDelete('cascade');

          
            $table->integer('articulos_id')->nullable()->unsigned();
            $table->foreign('articulos_id')->references('id')->on('articulos')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('sucursal_empresas_id')->nullable()->unsigned();
            $table->foreign('sucursal_empresas_id')->references('id')->on('sucursal_empresas')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('salida_detalles');
    }
}
