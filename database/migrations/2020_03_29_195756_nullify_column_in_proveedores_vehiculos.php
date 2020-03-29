<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullifyColumnInProveedoresVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proveedores_vehiculos', function (Blueprint $table) {
            $table->unsignedInteger('vehiculo_modelo_id')->nullable()->change();
            $table->unsignedInteger('vehiculo_anio_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proveedores_vehiculos', function (Blueprint $table) {
            $table->unsignedInteger('vehiculo_modelo_id')->nullable(false)->change();
            $table->unsignedInteger('vehiculo_anio_id')->nullable(false)->change();
        });
    }
}
