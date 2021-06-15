<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedRepuestosExtrasFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuestos_extras', function (Blueprint $table) {
            $table->dropColumn(['costo_total', 'impuestos_total', 'generales_total', 'tramitacion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repuestos_extras', function (Blueprint $table) {
            $table->unsignedDecimal('costo_total', 12, 2)->nullable()->after('costo');
            $table->unsignedDecimal('impuestos_total', 12, 2)->nullable()->after('impuestos')->comment('Solo internacional');
            $table->unsignedDecimal('generales_total', 12, 2)->nullable()->after('generales')->comment('Solo internacional');
            $table->unsignedDecimal('tramitacion', 12, 2)->nullable()->after('generales_total');
        });
    }
}
