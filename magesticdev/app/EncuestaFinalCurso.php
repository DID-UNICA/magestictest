<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncuestaFinalCurso extends Model
{
    protected $table = '_evaluacion_final_curso';

    public function getSugerencia(){
        return $this->sug;
    }
}