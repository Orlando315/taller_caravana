<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos_modelos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_marca_id');
            $table->foreign('vehiculo_marca_id')->references('id')->on('vehiculos_marcas')->onDelete('cascade');
            $table->string('modelo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos_modelos');
    }
}
