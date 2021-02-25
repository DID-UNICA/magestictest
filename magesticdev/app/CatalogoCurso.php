<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogoCurso extends Model
{
protected $table = 'catalogo_cursos';

/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
  'nombre_curso','duracion_curso','coordinacion_id','tipo','presentacion',
  'dirigido','objetivo','contenido','sintesis','metodologia','acreditacion',
  'evaluacion','bibliografia','consecuentes', 'previo','fecha_disenio',
  'clave_curso'
];

    public function getCoordinacion(){
        $coordinacion = Coordinacion::findOrFail(
          $this->coordinacion_id
        )->nombre_coordinacion;
        return $coordinacion;
    }
    
    public function allCoordinacion(){
        $coordinacion = Coordinacion::all();
        return $coordinacion;
    }

    public function getIdCoordinacion()
    {
        return $this->coordinacion_id;
    }
    public function getNumTemas(){
        return TemaSeminario::where('catalogo_id', $this->id)->get()->count();
    }
    public function getTemasSeminario(){
        return TemaSeminario::where('catalogo_id', $this->id)->get();
    }
}
