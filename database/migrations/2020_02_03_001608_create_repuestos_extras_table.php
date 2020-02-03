<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepuestosExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repuestos_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('repuesto_id');
            $table->foreign('repuesto_id')->references('id')->on('repuestos')->onDelete('cascade');
            $table->unsignedDecimal('costo', 12, 2)->nullable();
            $table->unsignedDecimal('envio1', 12, 2)->nullable();
            $table->unsignedDecimal('envio2', 12, 2)->nullable();
            $table->unsignedDecimal('casilla', 12, 2)->nullable();
            $table->unsignedDecimal('impuestos', 12, 2)->nullable();
            $table->unsignedDecimal('generales', 12, 2)->nullable();
            $table->unsignedDecimal('tramitacion', 12, 2)->nullable();
            $table->unsignedDecimal('moneda', 12, 2)->nullable();
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
        Schema::dropIfExists('repuestos_extras');
    }
}
