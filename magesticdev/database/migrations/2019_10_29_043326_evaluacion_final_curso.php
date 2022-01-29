<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EvaluacionFinalCurso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_evaluacion_final_curso', function (Blueprint $table) {
            $table->increments('id');
            //1. DESARROLLO DEL CURSO
            $table->integer('p1_1')->nullable();
            $table->integer('p1_2')->nullable();
            $table->integer('p1_3')->nullable();
            $table->integer('p1_4')->nullable();
            $table->integer('p1_5')->nullable();
            //2. AUTOEVALUACION
            $table->integer('p2_1')->nullable();
            $table->integer('p2_2')->nullable();
            $table->integer('p2_3')->nullable();
            $table->integer('p2_4')->nullable();
            //3. COORDINACION DEL CURSO
            $table->integer('p3_1')->nullable();
            $table->integer('p3_2')->nullable();
            $table->integer('p3_3')->nullable();
            $table->integer('p3_4')->nullable();
            //7.¿RECOMENDARÍA EL CURSO A OTROS PROFESORES?
            $table->integer('p7')->nullable();
            //8. ¿CÓMO SE ENTERÓ DEL CURSO/SEMINARIO?
            $table->string('p8',300)->nullable();
            //Lo mejor del curso fue / Lo que me aportó el seminario fue:
            $table->string('p9',500)->nullable();
            //Sugerencias y recomendaciones:	
            $table->string('sug',1500)->nullable();
            //¿Qué otros cursos, talleres, seminarios o temáticos le gustaría que se impartiesen o tomasen en cuenta para próximas actividades?
            $table->string('otros',300)->nullable();
            //ÁREA DE CONOCIMIENTO 
            $table->string('conocimiento',300)->nullable();
            //Temáticas:	
            $table->string('tematica',300)->nullable();
            //¿En qué horarios le gustaría que se impartiesen los cursos, talleres, seminarios o diplomados?
            //Horarios Semestrales:
            $table->string('horarios',100)->nullable();
            //Horarios Intersemestrales:
            $table->string('horarioi',100)->nullable();
            $table->integer('participante_curso_id')->unsigned();
            $table->foreign('participante_curso_id','participante_curso_id')
                  ->references('id')->on('participante_curso');
          });
      }
  
      /**
       * Reverse the migrations.
       *
       * @return void
       */
      public function down()
      {
          Schema::dropIfExists('_evaluacion_final_curso');
      }
}
