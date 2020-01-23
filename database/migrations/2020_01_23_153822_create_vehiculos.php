<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_marca_id');
            $table->foreign('vehiculo_marca_id')->references('id')->on('vehiculos_marcas')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_modelo_id');
            $table->foreign('vehiculo_modelo_id')->references('id')->on('vehiculos_modelos')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_anio_id');
            $table->foreign('vehiculo_anio_id')->references('id')->on('vehiculos_anios')->onDelete('cascade');
            $table->string('patentes');
            $table->string('color')->nullable();
            $table->float('km', 10, 2)->nullable();
            $table->string('vin')->nullable();
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
        Schema::dropIfExists('vehiculos');
    }
}
