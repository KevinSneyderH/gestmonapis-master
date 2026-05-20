<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persona_materia', function (Blueprint $table) {
            $table->id('idpersona_materia');
            $table->unsignedBigInteger('persona_idpersona');
            $table->unsignedBigInteger('materia_idmateria');
            $table->boolean('activo')->default(true);

            $table->foreign('persona_idpersona')
                  ->references('idpersona')
                  ->on('persona')
                  ->onDelete('cascade');

            $table->foreign('materia_idmateria')
                  ->references('idmateria')
                  ->on('materia')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persona_materia');
    }
};