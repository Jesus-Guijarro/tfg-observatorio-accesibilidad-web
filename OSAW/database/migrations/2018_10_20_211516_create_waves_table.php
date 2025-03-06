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
            $table->integer('num_problemas')->default(0);
            $table->integer('num_advertencias')->default(0);
            $table->integer('num_caracteristicas')->default(0);
            $table->integer('num_elem_ARIA')->default(0);
            $table->integer('num_problemas_contraste')->default(0);
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
        Schema::dropIfExists('waves');
    }
}
