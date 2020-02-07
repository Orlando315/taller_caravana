<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSituacionesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situaciones_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('situacion_id');
            $table->foreign('situacion_id')->references('id')->on('situaciones')->onDelete('cascade');
            $table->unsignedInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
            $table->unsignedInteger('repuesto_id')->nullable();
            $table->foreign('repuesto_id')->references('id')->on('repuestos')->onDelete('cascade');
            $table->string('type')->comment('insumo | repuesto | horas');
            $table->unsignedDecimal('valor_venta', 12, 2);
            $table->unsignedDecimal('cantidad', 12, 2)->nullable();
            $table->unsignedDecimal('total', 15, 2)->nullable();
            $table->unsignedDecimal('costo', 15, 2)->nullable();
            $table->unsignedDecimal('utilidad', 15, 2)->nullable();
            $table->boolean('descuento_type')->nullable()->comment('True % | False Fijo');
            $table->unsignedDecimal('descuento', 12, 2)->nullable();
            $table->unsignedDecimal('total_descuento', 15, 2)->nullable();
            $table->boolean('status')->nullable()->default(false)->comment('false pendiente | true Completado');
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
        Schema::dropIfExists('situaciones_items');
    }
}
