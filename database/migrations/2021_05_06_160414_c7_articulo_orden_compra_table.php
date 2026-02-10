<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class C7ArticuloOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_orden_compras', function (Blueprint $table) {

            $table->string('fecha_salida')->nullable()->after('transportes_id');
            $table->string('cantidad_salida')->nullable()->after('fecha_salida');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulo_orden_compras', function (Blueprint $table) {
            $table->dropColumn('fecha_salida');
        });
    }
}
