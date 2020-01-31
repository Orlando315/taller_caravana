<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('vehiculo_id');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->boolean('inmediatamente')->default(false)->comment('Si fue atentido al momento');
            $table->timestamp('fecha')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('agendamientos');
    }
}
