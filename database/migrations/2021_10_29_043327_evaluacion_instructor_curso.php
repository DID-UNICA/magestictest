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
          $table->increments('id')->start_from(6541);
          $table->integer('p1')->nullable();
          $table->integer('p2')->nullable();
          $table->integer('p3')->nullable();
          $table->integer('p4')->nullable();
          $table->integer('p5')->nullable();
          $table->integer('p6')->nullable();
          $table->integer('p7')->nullable();
          $table->integer('p8')->nullable();
          $table->integer('p9')->nullable();
          $table->integer('p10')->nullable();
          $table->integer('p11')->nullable();
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
