<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class C4SalidaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salida_detalles', function (Blueprint $table){
            $table->string('numero_requerimiento')->nullable()->after('cantidad');
            $table->string('fecha_salida_detalle')->nullable()->after('numero_requerimiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salida_detalles', function (Blueprint $table){
            $table->dropColumn('numero_requerimiento');
         });
    }
}
