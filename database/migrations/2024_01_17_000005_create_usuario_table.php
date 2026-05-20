<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('idusuario');
            $table->string('username', 155)->nullable();
            $table->string('password', 255)->nullable();
            $table->unsignedBigInteger('persona_idpersona')->unique();

            $table->foreign('persona_idpersona')
                  ->references('idpersona')
                  ->on('persona')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};