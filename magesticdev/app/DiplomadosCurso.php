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
}
