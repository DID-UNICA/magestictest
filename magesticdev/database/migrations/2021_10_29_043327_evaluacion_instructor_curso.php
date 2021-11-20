<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EvaluacionInstructorCurso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_evaluacion_instructor_curso', function(Blueprint $table){
          $table->increments('id');
          $table->integer('p1');
          $table->integer('p2');
          $table->integer('p3');
          $table->integer('p4');
          $table->integer('p5');
          $table->integer('p6');
          $table->integer('p7');
          $table->integer('p8');
          $table->integer('p9');
          $table->integer('p10');
          $table->integer('p11');
          $table->integer('participante_id')->unsigned();
          $table->integer('instructor_id')->unsigned();

          $table->foreign('participante_id','participante_id')
                ->references('id')->on('participante_curso');
          $table->foreign('instructor_id','instructor_id')
                ->references('id')->on('profesor_curso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('_evaluacion_instructor_curso');
    }
}
