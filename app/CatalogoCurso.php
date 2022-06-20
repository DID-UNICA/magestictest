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
        $coordinacion = Coordinacion::where('nombre_coordinacion','<>', 'Coordinación Del Centro de Docencia')
          ->where('nombre_coordinacion','<>', 'Área de Gestión y Vinculación')->get();
        return $coordinacion;
    }

    public function getIdCoordinacion(){
        return $this->coordinacion_id;
    }
    public function getNumTemas(){
        return TemaSeminario::where('catalogo_id', $this->id)->get()->count();
    }
    public function getTemasSeminario(){
        return TemaSeminario::where('catalogo_id', $this->id)->get(['id', 'nombre']);
    }
    public function getDiplomado(){
      return Diplomado::findOrFail($this->diplomado_id);
    }

    public function getNombreClave(){
      return $this->nombre_curso.' ('.$this->clave_curso.')';
    }

    public function getContenido_sangria(){
        $conte = $this->contenido;
        $conte_aux = '';
        foreach(preg_split("/\n/", $conte) as $line){
            for ($i=0; $i < strlen($line) && $line[$i] == ' '; $i++) { 
                $line = substr_replace($line, '&nbsp;', $i, 1);
                $i += 5;
            }
            $conte_aux .= $line;
        } 
        return $conte_aux;
    }
}
