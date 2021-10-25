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
  'nombre_curso','duracion_curso','coordinacion_id','tipo',
  'dirigido','objetivo','contenido', 'antecedentes','fecha_disenio',
  'clave_curso','diplomado_id','num_modulo'
];

    public function getCoordinacion(){
        $coordinacion = Coordinacion::findOrFail(
          $this->coordinacion_id
        )->nombre_coordinacion;
        return $coordinacion;
    }
    
    public function allCoordinacion(){
        $coordinacion = Coordinacion::where('nombre_coordinacion','<>', 'Coordinación Del Centro de Docencia')->get();
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
    public function getDiplomado(){
      return Diplomado::findOrFail($this->diplomado_id);
    }

    public function getNombreClave(){
      return $this->nombre_curso.' ('.$this->clave_curso.')';
    }
}
