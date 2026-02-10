<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensualidadUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensualidad_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fechaInicio')->nullable();   
            $table->string('fechaFin')->nullable();   
            $table->string('monto')->nullable();   
            $table->boolean('estado')->default(1);

            $table->integer('mensualidads_id')->nullable()->unsigned();
            $table->foreign('mensualidads_id')->references('id')->on('mensualidads')->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('users_id')->nullable()->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensualidad_usuarios');
    }
}
