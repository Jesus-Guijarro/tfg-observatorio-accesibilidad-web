<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEiiicheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eiiicheckers', function (Blueprint $table) {
            $table->increments('id');
            $table->float('puntuacion')->default(0);
            $table->integer('num_problemas')->default(0);
            $table->integer('num_aciertos')->default(0);
            $table->integer('num_problemas_a')->default(0);
            $table->integer('num_problemas_aa')->default(0);
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
        Schema::dropIfExists('eiiicheckers');
    }
}
