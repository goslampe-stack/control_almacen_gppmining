<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloDevolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_devolucions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cantidad')->nullable();
            $table->string('comentario')->nullable();

            
            $table->string('fecha_devolucion')->nullable();

            $table->string('tipoDevolucion')->nullable();
            

            $table->integer('articulos_id')->nullable()->unsigned();
            $table->foreign('articulos_id')->references('id')->on('articulos')->onUpdate('cascade')->onDelete('cascade');
            
            
            $table->integer('sucursal_empresas_id')->nullable()->unsigned();
            $table->foreign('sucursal_empresas_id')->references('id')->on('sucursal_empresas')->onUpdate('cascade')->onDelete('cascade');
           
            $table->integer('personals_id')->nullable()->unsigned();
            $table->foreign('personals_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('articulo_devolucions');
    }
}
