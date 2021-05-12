<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Antecedente;

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
  'dirigido','objetivo','contenido', 'antecedentes','fecha_disenio',
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

		public function getAntecedentes(){
			$string = '';
			$antecedentes = Antecedente::where('catalogo_id', $this->id)->get();
			foreach ($antecedentes as $antecedente){
				$antecedente_curso = CatalogoCurso::findOrFail($antecedente->siguiente_catalogo_id);
				//Concatenamos salto de linea para evitardesfasamiento en el formato
				$string = $string.'
'.$antecedente_curso->nombre_curso;
			}
			//Concatenamos salto de linea para evitardesfasamiento en el formato
			return $string.'
'.$this->antecedentes;
		}
}
