<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('user_id')->nullable()->comment('Usuario del cliente');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nombres', 70);
            $table->string('apellidos', 70);
            $table->string('email')->nullable()->unique();
            $table->string('rut', 20)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('telefono', 20);
            $table->boolean('status')->nullable()->default(true);
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
        Schema::dropIfExists('clientes');
    }
}
