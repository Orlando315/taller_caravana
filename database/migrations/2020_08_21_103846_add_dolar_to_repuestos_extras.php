<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDolarToRepuestosExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuestos_extras', function (Blueprint $table) {
          $table->unsignedDecimal('moneda_valor', 12, 2)->nullable()->after('moneda');
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
          $table->dropColumn('moneda_valor');
        });
    }
}
