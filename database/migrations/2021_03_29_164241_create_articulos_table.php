<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo')->nullable();
            $table->string('articulo')->nullable();

            $table->boolean('estado')->default(1);

            $table->integer('tipo_unidads_id')->nullable()->unsigned();
            $table->foreign('tipo_unidads_id')->references('id')->on('tipo_unidads')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('empresas_id')->nullable()->unsigned();
            $table->foreign('empresas_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('articulos');
    }
}
