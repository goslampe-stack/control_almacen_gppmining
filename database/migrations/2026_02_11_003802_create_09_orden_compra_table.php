<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create09OrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_de_compras', function (Blueprint $table){
            $table->json('cotizacion_proveedor')->nullable()->after('personalpdf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_de_compras', function (Blueprint $table){
            $table->dropColumn('cotizacion_proveedor');
         });
    }
}
