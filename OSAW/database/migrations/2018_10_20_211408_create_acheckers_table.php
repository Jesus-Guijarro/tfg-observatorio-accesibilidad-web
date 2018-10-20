<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acheckers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_problemas_conocidos');
            $table->integer('num_problemas_potenciales');
            $table->integer('num_problemas_conocidos_a');
            $table->integer('num_problemas_conocidos_aa');
            $table->integer('num_problemas_conocidos_aaa');
            $table->integer('num_problemas_potenciales_a');
            $table->integer('num_problemas_potenciales_aa');
            $table->integer('num_problemas_potenciales_aaa');
            $table->text('datos_problemas');
            $table->date('fecha_test');

            $table->integer('pagina_id')->unsigned()->nullable();
            $table->foreign('pagina_id')->references('id')->on('paginas')->onDelete("set null");

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
        Schema::dropIfExists('acheckers');
    }
}
