<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class C3ArticuloRequerimientoPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_requerimiento_personals', function (Blueprint $table){
            $table->string('serie_documento')->nullable()->after('numero_documento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulo_requerimiento_personals', function (Blueprint $table){
            $table->dropColumn('serie_documento');
         });
    }
}
