<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('serie_documento')->nullable();
            $table->string('serie_guia_remitente')->nullable();
            $table->string('numero_documento_guia_remitente')->nullable();
            $table->string('serie_guia_transportista')->nullable();
            $table->string('numero_documento_guia_transportista')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('precio_unitario')->nullable();
            
            $table->string('fecha_ingreso')->nullable();
            $table->string('fecha_traslado')->nullable();

            $table->boolean('estado')->default(1);
            

            $table->integer('articulos_orden_id')->nullable()->unsigned();
            $table->foreign('articulos_orden_id')->references('id')->on('articulo_orden_compras')->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('transportes_id')->nullable()->unsigned();
            $table->foreign('transportes_id')->references('id')->on('transportes')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('ingresos_id')->nullable()->unsigned();
            $table->foreign('ingresos_id')->references('id')->on('ingresos')->onUpdate('cascade')->onDelete('cascade');
           
            $table->integer('orden_de_compras_id')->nullable()->unsigned();
            $table->foreign('orden_de_compras_id')->references('id')->on('orden_de_compras')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('articulo_ingresos');
    }
}
