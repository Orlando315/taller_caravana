<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('taller')->comment('Usuario Admin al que pertenece');
            $table->foreign('taller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('proceso_id');
            $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('cascade');
            $table->unsignedDecimal('combustible', 15, 2)->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('radio')->default(false);
            $table->boolean('antena')->default(false);
            $table->boolean('pisos_delanteros')->default(false);
            $table->boolean('pisos_traseros')->default(false);
            $table->boolean('cinturones')->default(false);
            $table->boolean('tapiz')->default(false);
            $table->boolean('triangulos')->default(false);
            $table->boolean('extintor')->default(false);
            $table->boolean('botiquin')->default(false);
            $table->boolean('gata')->default(false);
            $table->boolean('herramientas')->default(false);
            $table->boolean('neumatico_repuesto')->default(false);
            $table->boolean('luces_altas')->default(false);
            $table->boolean('luces_bajas')->default(false);
            $table->boolean('intermitentes')->default(false);
            $table->boolean('encendedor')->default(false);
            $table->boolean('limpia_parabrisas_delantero')->default(false);
            $table->boolean('limpia_parabrisas_trasero')->default(false);
            $table->boolean('tapa_combustible')->default(false);
            $table->boolean('seguro_ruedas')->default(false);
            $table->boolean('perilla_interior')->default(false);
            $table->boolean('perilla_exterior')->default(false);
            $table->boolean('manuales')->default(false);
            $table->boolean('documentacion')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspecciones');
    }
}
