<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloRequerimientoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_requerimiento_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cantidad')->nullable();
            $table->string('fecha_requerimiento')->nullable();
            $table->string('solicitudCotizacion_id')->nullable();

            
            $table->boolean('estado')->default(1);


            $table->integer('requerimientoCompras_id')->nullable()->unsigned();
            $table->foreign('requerimientoCompras_id')->references('id')->on('requerimiento_compras')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('articulo_r_personals_id')->nullable()->unsigned();
            $table->foreign('articulo_r_personals_id')->references('id')->on('articulo_requerimiento_personals')->onUpdate('cascade')->onDelete('cascade');


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
        Schema::dropIfExists('articulo_requerimiento_compras');
    }
}
