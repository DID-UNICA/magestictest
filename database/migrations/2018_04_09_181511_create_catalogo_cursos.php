<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogoCursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_cursos', function (Blueprint $table) {
            $table->increments('id')->unique()->start_from(746);
            $table->string('clave_curso',25)->unique();
            $table->string('nombre_curso',300);
            $table->string('duracion_curso')->nullable();
            $table->string('tipo')->nullable();
            $table->string('institucion')->nullable();
            $table->longText('dirigido')->nullable();
            $table->longText('objetivo')->nullable();
            $table->longText('contenido')->nullable();
            $table->longText('antecedentes')->nullable();
            $table->date('fecha_disenio')->nullable();

            $table->integer('coordinacion_id')->unsigned();
            $table->foreign('coordinacion_id')->references('id')->on('coordinacions');

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
        Schema::dropIfExists('catalogo_cursos');
    }
}
