<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class C1SolicitudCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitud_cotizacions', function (Blueprint $table){
            $table->string('numero_cotizacion')->nullable()->after('numero_solicitud_cotizacion');
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
            $table->dropColumn('numero_cotizacion');
         });
    }
}
