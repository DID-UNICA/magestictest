<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SecretarioApoyo extends Model
{
    use Notifiable;
    protected $table = 'secretario_apoyo';
    protected $fillable = [
        'secretario','comentarios','grado','genero'
    ];

    public function getDescripcion(){
      if($this->genero === 'F')
        return "Secretaria de Apoyo a la Docencia";
      else
        return "Secretario de Apoyo a la Docencia";
    }

    public function getNombreFirma(){
      return $this->grado.' '.$this->secretario;
    }
}
