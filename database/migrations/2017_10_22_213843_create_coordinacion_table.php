<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('abreviatura')->nullable();
            $table->string('nombre_coordinacion');
            $table->string('coordinador');
            $table->string('grado')->nullable();
						$table->string('genero');
            $table->boolean('es_admin');
            $table->string('password');
            $table->string('comentarios')->nullable();
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
        Schema::dropIfExists('coordinacions');
    }
}
