<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_ingreso')->nullable();
            $table->string('fecha_ingreso')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('tipo_docuento')->nullable(); //ruc-boleta      
            $table->string('numero_documento')->nullable();

            $table->string('guia_transportista')->nullable();
            $table->string('guia_remision')->nullable();

            $table->boolean('estado')->default(1);

            $table->integer('transportes_id')->nullable()->unsigned();
            $table->foreign('transportes_id')->references('id')->on('transportes')->onUpdate('cascade')->onDelete('cascade');


            $table->integer('orden_de_compras_id')->nullable()->unsigned();
            $table->foreign('orden_de_compras_id')->references('id')->on('orden_de_compras')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('personals_id')->nullable()->unsigned();
            $table->foreign('personals_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');


            $table->integer('jefeLogistica_id')->nullable()->unsigned();
            $table->foreign('jefeLogistica_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');
           
            $table->integer('almacenero_id')->nullable()->unsigned();
            $table->foreign('almacenero_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');





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
        Schema::dropIfExists('ingresos');
    }
}
