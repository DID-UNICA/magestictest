<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Profesor;
use App\CategoriaNivel;

class ProfesorCategoria extends Model
{
    protected $table = "profesores_categorias";
    protected $fillable = [
        'profesor_id', 'categoria_nivel_id'
    ];

    public function getProfesor(){
      return Profesor::findOrFail($this->profesor_id);
    }


    public function getCategoria(){
      return CategoriaNivel::findOrFail($this->categoria_nivel_id);
    }

}
