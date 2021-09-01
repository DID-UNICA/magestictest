<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiplomadosCurso extends Model
{
    protected $table = 'diplomado_curso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num_modulo','diplomado_id','curso_id'];

    function getDiplomado(){
      return Diplomado::findOrFail($this->diplomado_id);
    }

    function getCurso(){
      return Curso::findOrFail($this->curso_id);
    }
}
