<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuestos', function (Blueprint $table) {
            $table->unsignedInteger('motor')->nullable()->change();
            $table->dropColumn('aduana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repuestos', function (Blueprint $table) {
            $table->string('motor')->nullable()->change();
            $table->unsignedDecimal('aduana', 12, 2)->nullable()->after('envio')->comment('internacionales');
        });
    }
}
