<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuario_rol', function (Blueprint $table) {
            $table->id('idusuario_rol');
            $table->unsignedBigInteger('rol_idrol');
            $table->unsignedBigInteger('usuario_idusuario');

            $table->foreign('rol_idrol')
                  ->references('idrol')
                  ->on('rol')
                  ->onDelete('cascade');

            $table->foreign('usuario_idusuario')
                  ->references('idusuario')
                  ->on('usuario')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_rol');
    }
};