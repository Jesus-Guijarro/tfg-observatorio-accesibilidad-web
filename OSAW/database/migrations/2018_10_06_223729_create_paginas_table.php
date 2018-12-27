<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paginas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('URL');
            $table->text('archivo_HTML')->nullable();
            $table->char('hash',16)->default('default');

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
        Schema::dropIfExists('paginas');
    }
}
