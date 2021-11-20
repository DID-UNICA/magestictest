<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncuestaFinalCurso extends Model
{
    protected $table = '_evaluacion_final_curso';

    protected $fillable = [
      'id',
      'p1_1',
      'p1_2',
      'p1_3',
      'p1_4',
      'p1_5',
      'p2_1',
      'p2_2',
      'p2_3',
      'p2_4',
      'p3_1',
      'p3_2',
      'p3_3',
      'p3_4',
      'p7',
      'p8',
      'p9',
      'sug',
      'otros',
      'conocimiento',
      'tematica',
      'horarios',
      'horarioi',
      'participante_curso_id'
  ];
}