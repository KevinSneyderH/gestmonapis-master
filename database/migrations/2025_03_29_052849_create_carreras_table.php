<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('carrera', function (Blueprint $table) {
            $table->id('idcarrera'); // Laravel lo interpreta como unsignedBigInteger
            $table->string('nombre', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrera');
    }
};
