<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoTematicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_tematicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_curso',500);
            $table->string('nombres_profesor',200);
            $table->string('apellido_paterno_profesor',200);
            $table->string('apellido_materno_profesor',200)->nullable();
            $table->string('email_profesor',200);
            $table->string('telefono',50)->nullable();
            $table->string('tematica',1500);
            $table->integer('semestre_anio');
            $table->string('semestre_pi',1);
            $table->string('semestre_si',1);
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
        Schema::dropIfExists('historico_tematicas');
    }
}
