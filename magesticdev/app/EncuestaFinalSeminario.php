<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncuestaFinalSeminario extends Model
{
    protected $table = '_evaluacion_final_seminario';

    public function getSugerencia(){
        return $this->sug;
    }
}
