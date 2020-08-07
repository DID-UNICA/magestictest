<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemaSeminarioProfesor extends Model
{
    protected $table = 'temas_seminario_profesor';
    protected $fillable = [
        'id', 'tema_id', 'profesor_id','curso_id'
    ];

    public function getTema(){
        $tema = TemaSeminario::findOrFail($this->tema_id);
        return $tema;

    }

    public function getCurso(){
        $curso = Curso::where('id', $this->curso_id)->get();
        return $curso;
    }

    public function getCatalogoCurso(){
        $curso = Curso::where('id', $this->curso_id)->get();
        $catalogo = CatalogoCurso::where('id', $curso->catalogo_id)->get();
        return $catalogo;
    }

    public function getProfesor(){
        $profesor = Profesor::findOrFail($this->profesor_id);
        return $profesor;
    }

}
