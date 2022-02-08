<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipanteCurso extends Migration
{
    /**
     * Es una tabla intermedia para los cursos y los participantes
     */
    public function up()
    {
        Schema::create('participante_curso', function (Blueprint $table) {
            $table->increments('id')->unique()->start_from(8414);
            $table->boolean('adicional')->nullable();
            $table->boolean('acreditacion')->nullable();
            $table->boolean('asistencia')->nullable();
            $table->boolean('confirmacion')->nullable();
            $table->boolean('pago_curso')->nullable();
            $table->boolean('cancelacion')->nullable();
            $table->boolean('estuvo_en_lista')->nullable();
            $table->Double('monto_pago')->nullable();
            $table->Integer('espera')->nullable();
            $table->string('causa_no_acreditacion')->nullable();
            $table->double('calificacion')->nullable();
            $table->string('comentario')->nullable();
            $table->string('folio_inst')->nullable();
            $table->string('folio_peque')->nullable();
            //TODO Preguntar a la maestra si realmente es necesario y si no se usa quitar, se observa con el participante en alguna evaluacion
            $table->boolean('contesto_hoja_evaluacion')->nullable();
            $table->Integer('curso_id')->unsigned();
            $table->Integer('profesor_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->foreign('profesor_id')->references('id')->on('profesors');

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExist('participante_curso');
    }
}
