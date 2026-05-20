<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->id('idrol');
            $table->string('nombre', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol');
    }
};