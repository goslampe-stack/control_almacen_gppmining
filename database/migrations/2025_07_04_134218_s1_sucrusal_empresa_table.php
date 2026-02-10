<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class S1SucrusalEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sucursal_empresas', function (Blueprint $table){
            $table->string('tipografia_pdf')->default("Montserrat, sans-serif")->after('identificador');
            $table->string('colorPdf')->default('#000000')->after('tipografia_pdf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sucursal_empresas', function (Blueprint $table){
            $table->dropColumn('tipografia_pdf');
         });
    }
}
