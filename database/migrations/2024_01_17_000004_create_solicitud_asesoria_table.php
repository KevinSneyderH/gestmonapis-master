<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitud_asesoria', function (Blueprint $table) {
            $table->id('idsolicitud_asesoria');
            $table->unsignedBigInteger('persona_idpersona');
            $table->unsignedBigInteger('materia_idmateria');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->string('estado', 100);

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
        Schema::dropIfExists('solicitud_asesoria');
    }
};