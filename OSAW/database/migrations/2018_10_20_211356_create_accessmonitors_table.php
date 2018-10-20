<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessmonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessmonitors', function (Blueprint $table) {
            $table->increments('id');
            $table->float('puntuacion');
            $table->integer('num_problemas_a');
            $table->integer('num_problemas_aa');
            $table->integer('num_problemas_aaa');
            $table->integer('num_advertencias_a');
            $table->integer('num_advertencias_aa');
            $table->integer('num_advertencias_aaa');
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
        Schema::dropIfExists('accessmonitors');
    }
}
