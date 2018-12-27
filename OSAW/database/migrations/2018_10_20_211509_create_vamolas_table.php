<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVamolasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vamolas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_problemas_conocidos')->default(0);
            $table->integer('num_problemas_potenciales')->default(0);
            $table->integer('num_problemas_conocidos_a')->default(0);
            $table->integer('num_problemas_conocidos_aa')->default(0);
            $table->integer('num_problemas_conocidos_aaa')->default(0);
            $table->integer('num_problemas_potenciales_a')->default(0);
            $table->integer('num_problemas_potenciales_aa')->default(0);
            $table->integer('num_problemas_potenciales_aaa')->default(0);
            $table->text('datos_problemas');
            $table->date('fecha_test');

            $table->integer('pagina_id')->unsigned()->nullable();
            $table->foreign('pagina_id')->references('id')->on('paginas')->onUpdate("cascade")->onDelete("set null");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vamolas');
    }
}
