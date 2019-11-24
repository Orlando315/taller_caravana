<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->comment('Usuario principal');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('added_by')->nullable()->comment('Usuario que lo agrego');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('nombre');
            $table->string('marca');
            $table->unsignedInteger('tipo_id')->nullable()->comment('Usuario que lo agrego');
            $table->foreign('tipo_id')->references('id')->on('insumos_tipos')->onDelete('cascade');
            $table->string('grado');
            $table->unsignedInteger('formato_id')->nullable()->comment('Usuario que lo agrego');
            $table->foreign('formato_id')->references('id')->on('insumos_formatos')->onDelete('cascade');
            $table->string('foto')->nullable();
            $table->string('descripcion');
            $table->unsignedInteger('factura');
            $table->string('foto_factura')->nullable();
            $table->unsignedDecimal('coste', 12, 2);
            $table->unsignedDecimal('venta', 12, 2);
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
        Schema::dropIfExists('insumos');
    }
}
