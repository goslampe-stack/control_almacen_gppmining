<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloRequerimientoPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_requerimiento_personals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cantidad')->nullable();
            $table->string('fecha_ingreso')->nullable();
            $table->string('precio_unitario')->nullable();
            $table->string('requerimientoCompras_id')->nullable();
            
            $table->boolean('estado')->default(1);

            $table->integer('articulos_id')->nullable()->unsigned();
            $table->foreign('articulos_id')->references('id')->on('articulos')->onUpdate('cascade')->onDelete('cascade');


            $table->integer('requerimiento_p_id')->nullable()->unsigned();
            $table->foreign('requerimiento_p_id')->references('id')->on('requerimiento_personals')->onUpdate('cascade')->onDelete('cascade');


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
        Schema::dropIfExists('articulo_requerimiento_personals');
    }
}
