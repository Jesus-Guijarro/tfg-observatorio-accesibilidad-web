<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observatorios', function (Blueprint $table) {
            $table->increments('id');
            $table->float('porcentaje_comprensible');
            $table->float('porcentaje_operable');
            $table->float('porcentaje_perceptible');
            $table->float('porcentaje_robusto');
            $table->integer('num_problemas_comprensible');
            $table->integer('num_problemas_operable');
            $table->integer('num_problemas_perceptible');
            $table->integer('num_problemas_robusto');
            $table->integer('num_advertencias_comprensible');
            $table->integer('num_advertencias_operable');
            $table->integer('num_advertencias_perceptible');
            $table->integer('num_advertencias_robusto');
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
        Schema::dropIfExists('observatorios');
    }
}
