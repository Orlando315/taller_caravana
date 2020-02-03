<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repuestos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_marca_id');
            $table->foreign('vehiculo_marca_id')->references('id')->on('vehiculos_marcas')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_modelo_id');
            $table->foreign('vehiculo_modelo_id')->references('id')->on('vehiculos_modelos')->onDelete('cascade');
            $table->string('nro_parte');
            $table->string('nro_oem')->nullable();
            $table->string('marca_oem')->nullable();
            $table->integer('anio');
            $table->string('motor')->nullable();
            $table->string('sistema')->nullable();
            $table->string('componente')->nullable();
            $table->string('foto')->nullable();
            $table->string('procedencia')->comment('locales | nacionales | internacionales');
            $table->unsignedDecimal('envio', 12, 2)->nullable()->comment('locales o internacionales');
            $table->unsignedDecimal('aduana', 12, 2)->nullable()->comment('internacionales');
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
        Schema::dropIfExists('repuestos');
    }
}
