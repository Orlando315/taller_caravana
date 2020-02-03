<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['minimo']);
            $table->unsignedInteger('proveedor_id')->nullable()->after('id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->unsignedDecimal('coste', 12, 2)->nullable()->after('insumo_id');
            $table->unsignedDecimal('venta', 12, 2)->nullable()->after('coste');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
            $table->dropColumn(['proveedor_id', 'coste', 'venta']);
            $table->unsignedSmallInteger('minimo')->nullable()->after('stock');
        });
    }
}
