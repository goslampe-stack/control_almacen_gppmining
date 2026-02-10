<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenDeComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_de_compras', function (Blueprint $table) {
              $table->increments('id');
            $table->string('numero_orden_compra')->nullable();
            $table->string('fecha_pedido')->nullable();
            $table->string('fecha_estimada_pago')->nullable();
            $table->string('terminos_de_entrega')->nullable();
            $table->string('tipo_docuento')->nullable(); //ruc-boleta      
            $table->string('numero_documento')->nullable();   //ruc-boleta      
            $table->string('ingresos_id')->nullable();
            $table->boolean('estado')->default(1);

            //$table->integer('inventario_inicials_id')->nullable()->unsigned();
           // $table->foreign('inventario_inicials_id')->references('id')->on('inventario_inicials')->onUpdate('cascade')->onDelete('cascade');
            

            $table->integer('solicitud_cotizacions_id')->nullable()->unsigned();
            $table->foreign('solicitud_cotizacions_id')->references('id')->on('solicitud_cotizacions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('proveedors_id')->nullable()->unsigned();
            $table->foreign('proveedors_id')->references('id')->on('proveedors')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('sucursal_empresas_id')->nullable()->unsigned();
            $table->foreign('sucursal_empresas_id')->references('id')->on('sucursal_empresas')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('users_id')->nullable()->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('elaboradoPor_id')->nullable()->unsigned();
            $table->foreign('elaboradoPor_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');
           
            $table->integer('alamacenadoPor_id')->nullable()->unsigned();
            $table->foreign('alamacenadoPor_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');


            
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
        Schema::dropIfExists('orden_de_compras');
    }
}
