<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacturasFromInsumosToStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insumos', function (Blueprint $table) {
            $table->dropColumn(['factura', 'foto_factura']);
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->string('factura')->nullable()->after('stock');
            $table->string('foto_factura')->nullable()->after('factura');
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
            $table->unsignedInteger('factura')->nullable()->after('descripcion');
            $table->string('foto_factura')->nullable()->after('factura');
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['factura', 'foto_factura']);
        });
    }
}
