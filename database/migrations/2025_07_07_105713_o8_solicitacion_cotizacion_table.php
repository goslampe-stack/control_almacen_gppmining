<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class O8SolicitacionCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('solicitud_cotizacions', function (Blueprint $table){
            $table->json('personalpdf')->nullable()->after('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('solicitud_cotizacions', function (Blueprint $table){
            $table->dropColumn('personalpdf');
         });
    }
}
