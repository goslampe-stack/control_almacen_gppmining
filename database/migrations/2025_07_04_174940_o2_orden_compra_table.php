<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class O2OrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('orden_de_compras', function (Blueprint $table){
            $table->json('personalpdf')->nullable()->after('descripcion_solicitamos');
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
            $table->dropColumn('personalpdf');
         });
    }
}
