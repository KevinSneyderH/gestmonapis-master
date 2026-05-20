<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('materia', function (Blueprint $table) {
            $table->id('idmateria'); // Define la clave primaria con auto-incremento
            $table->string('nombre', 255)->nullable();
            $table->timestamps(); // Agrega created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('materia');
    }
};
