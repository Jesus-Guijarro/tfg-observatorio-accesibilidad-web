<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_problemas');
            $table->integer('num_advertencias');
            $table->integer('num_caracteristicas');
            $table->integer('num_elem_ARIA');
            $table->integer('num_problemas_contraste');
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
        Schema::dropIfExists('waves');
    }
}
