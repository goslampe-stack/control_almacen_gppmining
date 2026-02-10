<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloSolicitudCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_solicitud_cotizacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cantidad')->nullable();
            $table->string('fecha_solicitud')->nullable();
            $table->string('orden_de_compras_id')->nullable();

            
            $table->boolean('estado')->default(1);


            $table->integer('solicitudCotizacions_id')->nullable()->unsigned();
            $table->foreign('solicitudCotizacions_id')->references('id')->on('solicitud_cotizacions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('articuloCompras_id')->nullable()->unsigned();
            $table->foreign('articuloCompras_id')->references('id')->on('articulo_requerimiento_compras')->onUpdate('cascade')->onDelete('cascade');


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
        Schema::dropIfExists('articulo_solicitud_cotizacions');
    }
}
