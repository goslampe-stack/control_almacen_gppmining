<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create11RequerimientoInternoPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('requerimiento_personals', function (Blueprint $table){


            $table->integer('destinatarios_id')->nullable()->unsigned()->after('requerimientoCompras_id');
            $table->foreign('destinatarios_id')->references('id')->on('personals')->onUpdate('cascade')->onDelete('cascade');


          
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
            $table->dropColumn('destinatario_id');
         });
    }
}
