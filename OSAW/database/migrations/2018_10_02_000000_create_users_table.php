<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',20)->unique();
            $table->string('email',40)->unique();
            $table->string('password',60);
            $table->text('avatar')->nullable();
            $table->text('biografia')->nullable();

            $table->integer('rol_id')->unsigned()->nullable();
            $table->foreign('rol_id')->references('id')->on('rols')->onUpdate("cascade")->onDelete("set null");

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        #
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
