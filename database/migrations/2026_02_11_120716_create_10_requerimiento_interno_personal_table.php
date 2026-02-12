<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create10RequerimientoInternoPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('requerimiento_personals', function (Blueprint $table){


            $table->integer('destinatario_id')->nullable()->unsigned()->after('requerimientoCompras_id');
            $table->foreign('destinatario_id')->references('id')->on('requerimiento_personals')->onUpdate('cascade')->onDelete('cascade');


          
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
