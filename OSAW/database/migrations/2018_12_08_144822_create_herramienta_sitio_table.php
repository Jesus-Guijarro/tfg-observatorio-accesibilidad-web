<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHerramientaSitioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('herramienta_sitio', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('herramienta_id')->unsigned()->nullable();
            $table->foreign('herramienta_id')->references('id')->on('herramientas')->onUpdate("cascade")->onDelete("set null");

            $table->integer('sitio_id')->unsigned()->nullable();
            $table->foreign('sitio_id')->references('id')->on('sitios')->onUpdate("cascade")->onDelete("set null");


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
        Schema::dropIfExists('herramienta_sitio');
    }
}
