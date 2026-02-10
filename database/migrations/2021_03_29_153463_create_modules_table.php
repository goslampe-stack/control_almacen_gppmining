<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->unique();
            $table->string('module_key',150)->unique();
            $table->string('module_url',150)->unique();
            $table->string('module_icon',50)->nullable();
            $table->string('identity',50)->nullable();
            $table->string('opcion',50)->nullable();
            $table->integer('module_rank');
            $table->boolean('view_sidebar')->default(0);
            $table->boolean('state')->default(1);

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
        Schema::dropIfExists('modules');
    }
}
