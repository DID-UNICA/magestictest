<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Director extends Model
{
    use Notifiable;
    protected $table = 'direccion';
    protected $fillable = [
        'director','comentarios','grado','genero'
    ];

    public function getDescripcion(){
      if($this->genero === 'F')
        return "Directora del Centro de Docencia";
      else
        return "Director del Centro de Docencia";
    }

    public function getNombreFirma(){
      return $this->grado.' '.$this->director;
    }
}
