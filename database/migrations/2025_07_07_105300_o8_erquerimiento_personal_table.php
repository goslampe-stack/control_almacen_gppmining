<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class O8ErquerimientoPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('requerimiento_personals', function (Blueprint $table){
            $table->json('personalpdf')->nullable()->after('requerimientoCompras_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('requerimiento_personals', function (Blueprint $table){
            $table->dropColumn('personalpdf');
         });
    }
}
