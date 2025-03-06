<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagina_user', function (Blueprint $table) {
            $table->increments('id');
            $table->json('informe');
            $table->date('fecha_test');
            $table->boolean('revisado');
            $table->float('porcentaje_perceptible');
            $table->float('porcentaje_operable');
            $table->float('porcentaje_comprensible');
            $table->float('porcentaje_robusto');
            $table->integer('num_errores_a');
            $table->integer('num_errores_aa');
            $table->integer('num_errores_aaa');

            $table->integer('pagina_id')->unsigned()->nullable();
            $table->foreign('pagina_id')->references('id')->on('paginas')->onUpdate("cascade")->onDelete("set null");

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate("cascade")->onDelete("set null");

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
        Schema::dropIfExists('pagina_user');
    }
}
