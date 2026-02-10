<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class C5ArticuloOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_orden_compras', function (Blueprint $table){

            $table->string('fecha_traslado')->nullable()->after('tipo_documento');

            $table->integer('transportes_id')->nullable()->unsigned()->after('fecha_traslado');
            $table->foreign('transportes_id')->references('id')->on('transportes')->onUpdate('cascade')->onDelete('cascade');


          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulo_orden_compras', function (Blueprint $table){
            $table->dropColumn('transportes_id');
         });
    }
}
