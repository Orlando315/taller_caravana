<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAgendamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendamientos', function (Blueprint $table) {
          $table->dropForeign(['vehiculo_id']);
          $table->dropColumn('vehiculo_id');

          $table->unsignedInteger('proceso_id')->nullable()->after('taller');
          $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendamientos', function (Blueprint $table) {
          $table->unsignedInteger('vehiculo_id')->nullable()->after('taller');
          $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');

          $table->dropForeign(['proceso_id']);
          $table->dropColumn('proceso_id');
        });
    }
}
