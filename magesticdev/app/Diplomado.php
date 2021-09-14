<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Db;
use App\DiplomadosCurso;
use App\Curso;
use Carbon\Carbon;

class Diplomado extends Model
{
	protected $table = 'diplomados';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombre_diplomado'
    ];

    public function getFecha(){
        $cursos = Curso::where('diplomado_id', $this->id)->get();
        if($cursos->isEmpty()){
          return null;
        }
        //Llamar a funcion que ordene los cursos por fecha
        $fecha_inicio = Carbon::now();
        $fecha_fin = Carbon::now();
        foreach($cursos as $curso){
            $tmp = Carbon::parse($curso->fecha_inicio);
            if($fecha_inicio->greaterThanOrEqualTo($tmp)){
                $fecha_inicio = $tmp;
            }
            $tmp = Carbon::parse($curso->fecha_fin);
            if($fecha_fin->lessThan($tmp)){
                $fecha_fin = $tmp;
            }
        }
        $fecha_inicio = $fecha_inicio->format('Y/m/d');
        $fecha_fin = $fecha_fin->format('Y/m/d');
        if ($fecha_inicio[8] == '0'){
            $dia_inicio = $fecha_inicio[9];
        }
        else{
         $dia_inicio = $fecha_inicio[8] . $fecha_inicio[9];
       }
        if($fecha_fin[8] == '0'){
          $dia_fin = $fecha_fin[9];
        }
        else{
         $dia_fin = $fecha_fin[8] . $fecha_fin[9];
        }
         $anio = $fecha_fin[0].$fecha_fin[1].$fecha_fin[2].$fecha_fin[3];
         $mesfin = $fecha_fin[5].$fecha_fin[6];
         $mesini = $fecha_inicio[5].$fecha_inicio[6];
         if ($mesfin == $mesini){
             $mes = $this->nombreMes($mesfin);
             $fecha = $dia_inicio .' al '.$dia_fin.' de '.$mes.' de '.$anio;
             return $fecha;
         }
        else{
            $mesini = $this->nombreMes($mesini);
            $mesfin = $this->nombreMes($mesfin);
            $fecha = $dia_inicio .' de '.$mesini.' al '.$dia_fin.' de '.$mesfin.' de '.$anio;
            return $fecha;
        }
      }
    public function nombreMes($mes){
        if ($mes == '01'){
            $mes = 'enero';
          }
          elseif ($mes == '02') {
            $mes = 'febrero';
          }
          elseif ($mes == '03') {
            $mes = 'marzo';
          }
          elseif ($mes == '04') {
            $mes = 'abril';
          }
          elseif ($mes == '05') {
            $mes = 'mayo';
          }
          elseif ($mes == '06') {
            $mes = 'junio';
          }
          elseif ($mes == '07') {
            $mes = 'julio';
          }
          elseif ($mes == '08') {
            $mes = 'agosto';
          }
          elseif ($mes == '09') {
            $mes = 'septiembre';
          }
          elseif ($mes == '10') {
            $mes = 'octubre';
          }
          elseif ($mes == '11') {
            $mes = 'noviembre';
          }
          elseif ($mes == '12') {
            $mes = 'diciembre';
          }
        return $mes;
    }

    public function getDuracion(){
        $modulos = Curso::where('diplomado_id',$this->id)->get();
        $duracionT = 0;
        foreach($modulos as $modulo){
            $catalogo = $modulo->getCatalogoCurso();
            $tmp = intval($catalogo->duracion_curso);
            $duracionT = $duracionT + $tmp;

        }
        return strval($duracionT);
    }

    public function getTypeId(){
        $id = '';
        if($this->id >=1 && $this->id <=9){
          return '00'.$this->id;
        }
        else if($this->id >=10 && $this->id <=99){
          return '0'.$this->id;
        }
        else {return $this->id;}
  }
}