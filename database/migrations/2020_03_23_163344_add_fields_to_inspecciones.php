<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToInspecciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspecciones', function (Blueprint $table) {
            $table->string('combustible')->nullable()->change();
            $table->boolean('aprobado')->nullable()->after('observacion')->comment('Cliente');
            $table->longText('comentarios')->nullable()->after('aprobado')->comment('Clinte');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspecciones', function (Blueprint $table) {
            $table->dropColumn(['aprobado', 'comentarios']);
            $table->unsignedDecimal('combustible', 15, 2)->nullable()->change();
        });
    }
}
