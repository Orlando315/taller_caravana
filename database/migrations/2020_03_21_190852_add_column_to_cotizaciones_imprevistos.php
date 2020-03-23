<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCotizacionesImprevistos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_imprevistos', function (Blueprint $table) {
            $table->string('asumido')->default('taller')->after('monto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizaciones_imprevistos', function (Blueprint $table) {
            $table->dropColumn('asumido');
        });
    }
}
