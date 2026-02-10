<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimientoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimiento_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_requerimiento_compra')->nullable();
            $table->string('fecha_requerimiento')->nullable();
            $table->string('solicitudCotizacion_id')->nullable();
            $table->string('descripcion')->nullable();

            $table->boolean('estado')->default(1);

            //$table->integer('inventario_inicials_id')->nullable()->unsigned();
            // $table->foreign('inventario_inicials_id')->references('id')->on('inventario_inicials')->onUpdate('cascade')->onDelete('cascade');


            $table->integer('requerimiento_personals_id')->nullable()->unsigned();
            $table->foreign('requerimiento_personals_id')->references('id')->on('requerimiento_personals')->onUpdate('cascade')->onDelete('cascade');


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
        Schema::dropIfExists('requerimiento_compras');
    }
}
