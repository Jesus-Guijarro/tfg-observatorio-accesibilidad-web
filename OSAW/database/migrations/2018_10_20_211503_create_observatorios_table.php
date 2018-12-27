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
            $table->float('porcentaje_comprensible')->default(0);
            $table->float('porcentaje_operable')->default(0);
            $table->float('porcentaje_perceptible')->default(0);
            $table->float('porcentaje_robusto')->default(0);
            $table->integer('num_problemas_comprensible')->default(0);
            $table->integer('num_problemas_operable')->default(0);
            $table->integer('num_problemas_perceptible')->default(0);
            $table->integer('num_problemas_robusto')->default(0);
            $table->integer('num_advertencias_comprensible')->default(0);
            $table->integer('num_advertencias_operable')->default(0);
            $table->integer('num_advertencias_perceptible')->default(0);
            $table->integer('num_advertencias_robusto')->default(0);
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
        Schema::dropIfExists('observatorios');
    }
}
