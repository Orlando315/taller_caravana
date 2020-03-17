<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRepuestosExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuestos_extras', function (Blueprint $table) {
            $table->string('moneda')->nullable()->change();
            $table->unsignedDecimal('costo_total', 12, 2)->nullable()->after('costo');
            $table->unsignedDecimal('impuestos_total', 12, 2)->nullable()->after('impuestos')->comment('Solo internacional');
            $table->unsignedDecimal('generales_total', 12, 2)->nullable()->after('generales')->comment('Solo internacional');
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
            $table->unsignedDecimal('moneda', 12, 2)->change();
            $table->dropColumn(['costo_total', 'impuestos_total', 'generales_total']);
        });
    }
}
