<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class C1ArticuloRequerimientoPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_requerimiento_personals', function (Blueprint $table){
            $table->string('tipo_documento')->nullable()->after('precio_unitario');
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
            $table->dropColumn('standbyTime');
         });
    }
}
