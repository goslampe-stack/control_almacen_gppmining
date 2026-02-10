<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimientoPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimiento_personals', function (Blueprint $table) {
             $table->increments('id');
            $table->string('numero_requerimiento');
            $table->string('fecha_pedido');
            $table->string('descripcion');
            $table->string('orden_compra_id')->nullable();
            $table->string('requerimientoCompras_id')->nullable();
            $table->boolean('estado')->default(1);
            $table->integer('personals_id')->nullable()->unsigned();
            $table->foreign('personals_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('requerimiento_personals');
    }
}
