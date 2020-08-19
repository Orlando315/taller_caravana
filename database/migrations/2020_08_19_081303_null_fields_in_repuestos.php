<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullFieldsInRepuestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuestos', function (Blueprint $table) {
            $table->string('nro_parte')->nullable()->change();
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
            $table->string('nro_parte')->nullable(false)->change();
        });
    }
}
