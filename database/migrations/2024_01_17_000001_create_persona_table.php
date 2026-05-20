<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id('idpersona');
            $table->string('tipoDocumento', 155)->nullable();
            $table->string('numeroDocumento', 155)->nullable()->unique();
            $table->string('nombres', 155)->nullable();
            $table->string('apellidos', 155)->nullable();
            $table->string('email', 155)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persona');
    }
};