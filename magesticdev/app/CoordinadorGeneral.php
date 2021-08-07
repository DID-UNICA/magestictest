<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class CoordinadorGeneral extends Model
{
    use Notifiable;

    protected $table = "coordinador_general";
    protected $fillable = [
        'coordinador','comentarios','grado','genero'
    ];

    public function getDescripcion(){
      if($this->genero === 'F')
        return "Coordinadora del Centro de Docencia";
      else
        return "Coordinador del Centro de Docencia";
    }

    public function getNombreFirma(){
      return $this->grado.' '.$this->coordinador;
    }
}
