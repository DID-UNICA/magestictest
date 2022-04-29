<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Coordinacion extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "coordinacions";

    protected $fillable = [
        'nombre_coordinacion', 'abreviatura','coordinador','grado','genero','es_admin','password','comentarios',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function getDescripcion(){
      if($this->genero === 'F')
        return "Coordinadora de ".$this->nombre_coordinacion;
      else
        return "Coordinador de ".$this->nombre_coordinacion;
    }

    public function getNombreFirma(){
      return $this->grado.' '.$this->coordinador;
    }
    
}
