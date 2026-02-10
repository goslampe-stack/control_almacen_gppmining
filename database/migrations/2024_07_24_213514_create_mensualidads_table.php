<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensualidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensualidads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->nullable();   
            $table->string('monto')->nullable();   
            $table->string('orden')->nullable();   
            $table->string('descripcion')->nullable();   
            $table->boolean('estado')->default(1);

          
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
        Schema::dropIfExists('mensualidads');
    }
}
