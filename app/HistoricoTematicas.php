<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoTematicas extends Model
{
    protected $table = 'historico_tematicas';

    protected $fillable = [
      'id',
      'nombre_curso',
      'nombres_profesor',
      'apellido_paterno_profesor',
      'apellido_materno_profesor',
      'email_profesor',
      'telefono',
      'tematica',
      'semestre_anio',
      'semestre_pi',
      'semestre_si',
  ];
    public function getNombresMayus(){
     return mb_strtoupper($this->apellido_paterno_profesor." ".$this->apellido_materno_profesor." ".$this->nombres_profesor); 
    }
}