<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persona_carrera', function (Blueprint $table) {
            $table->id('idpersona_carrera');
            $table->unsignedBigInteger('persona_idpersona');
            $table->unsignedBigInteger('carrera_idcarrera');
            
            $table->foreign('persona_idpersona')
                  ->references('idpersona')
                  ->on('persona')
                  ->onDelete('cascade');
                  
            $table->foreign('carrera_idcarrera')
                  ->references('idcarrera')
                  ->on('carrera')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persona_carrera');
    }
};
