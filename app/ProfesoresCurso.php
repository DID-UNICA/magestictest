<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProfesoresCurso extends Model
{
    protected $table = 'profesor_curso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'curso_id','profesor_id','tema_seminario_id', 'folio_inst','folio_peque','fecha_envio','fecha_exposicion'];

    public function getProfesor(){
      return Profesor::findOrFail($this->profesor_id);
    }

    public function getFechaImparticion(){

      //arrays utiles
      $meses_array = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
      $dias_semana_array = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
      $fecha = $this->fecha_exposicion;
      if(!$fecha)
        return null;
      if ($fecha[8] == '0'){
        $dia = $fecha[9];
      }
      else{
        $dia = $fecha[8] . $fecha[9];
      }
      if ($fecha[5] == '0'){
        $mes = $fecha[6];
      }
      else{
        $mes = $fecha[5] . $fecha[6];
      }
      $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
      $fecha_cadena = $dia.' de '.$meses_array[$mes-1].' de '.$anio;
      return $fecha_cadena;
    }
}
