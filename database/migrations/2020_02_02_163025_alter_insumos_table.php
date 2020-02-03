<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insumos', function (Blueprint $table) {
            $table->dropColumn(['coste', 'venta']);
            $table->unsignedSmallInteger('minimo')->nullable()->after('foto_factura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insumos', function (Blueprint $table) {
            $table->dropColumn(['minimo']);
            $table->unsignedDecimal('coste', 12, 2)->after('foto_factura');
            $table->unsignedDecimal('venta', 12, 2)->after('coste');
        });
    }
}
