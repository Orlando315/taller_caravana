<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores_vehiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_marca_id');
            $table->foreign('vehiculo_marca_id')->references('id')->on('vehiculos_marcas')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_modelo_id');
            $table->foreign('vehiculo_modelo_id')->references('id')->on('vehiculos_modelos')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_anio_id');
            $table->foreign('vehiculo_anio_id')->references('id')->on('vehiculos_anios')->onDelete('cascade');
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
        Schema::dropIfExists('proveedores_vehiculos');
    }
}
