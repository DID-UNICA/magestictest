<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Division;

class Profesor extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "profesors";
    protected $fillable = [
        'nombres', 'apellido_paterno','apellido_materno','rfc','numero_trabajador', 'categoria_nivel_id',
        'fecha_nacimiento','telefono','grado','abreviatura_grado','email','usuario', 'fecha_alta','grado','comentarios','genero',
        'baja','causa_baja','semblanza_corta','facebook','unam','procedencia','facultad_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNombres(){
        return $this->apellido_paterno." ".$this->apellido_materno." ".$this->nombres;
    }
    public function getFirmanteConstancia(){
      return $this->abreviatura_grado." ".$this->nombres." ".$this->apellido_paterno." ".$this->apellido_materno;
    }
    public function getNombreSinApellidos(){
        return $this->nombres;
    }
    public function getNombresMayus(){
        return mb_strtoupper($this->apellido_paterno." ".$this->apellido_materno." ".$this->nombres);
    }

    public function fechaFormato(){
        $fecha = Carbon::parse($this->fecha_nacimiento)->format('d-m-Y');
        return $fecha;

    }

    public function getCategoria(){
        if($this->categoria_nivel_id)
            return CategoriaNivel::findOrFail($this->categoria_nivel_id)->categoria;
        else
            return "";
    }

    public function allCategoria(){
        $categoria = CategoriaNivel::all();
        return $categoria;
    }

    public function allGrado(){
        $grado = [
            'Licenciatura'=>'Licenciatura',
            'Ingeniería'=>'Ingeniería',
            'Maestría'=>'Maestría',
            'Doctorado'=>'Doctorado',
            'Otro'=>'Otro'
        ];
        return $grado;
    }

    public function getIdCategoria()
    {
        return $this->categoria_nivel_id;
    }

    public function getDivision(){
      $divisiones = DB::table('divisions')
        ->join('carreras', 'carreras.id_division', '=', 'divisions.id')
        ->join('profesores_carreras', 'profesores_carreras.id_carrera', '=','carreras.id')
        ->join('profesors','profesors.id', '=', 'profesores_carreras.id_profesor')
        ->where('profesors.id', '=', $this->id);
      return $divisiones;
    }
    public function getDivisionNombre()
    {
      $divisiones_str = '';
      $divisiones = DB::table('profesors')
        ->join('profesores_divisiones', 'profesores_divisiones.id_profesor', '=', 'profesors.id')
        ->join('divisions', 'divisions.id', '=', 'profesores_divisiones.id_division')
        ->select('divisions.nombre')
        ->where('profesors.id', '=', $this->id)->get();
        foreach($divisiones as $index => $division){
          if($index == 0)
            $divisiones_str = $division->nombre;
          else
            $divisiones_str = $divisiones_str.", ".$division->nombre;
        }
        return $divisiones_str;
    }

//Retorna una colección de carreras
    public function getCarreras()
    {
        $carreras = DB::table('profesors')
          ->join('profesores_carreras', 'profesors.id', '=', 'profesores_carreras.id_profesor')
          ->join('carreras', 'carreras.id', '=', 'profesores_carreras.id_carrera')
          ->select('carreras.nombre')
          ->where('profesors.id', '=', $this->id)
          ->get();
        return $carreras;
    }

//Retorna las carreras como una cadena
    public function getCarrerasPorNombre()
    {
        $carreras = DB::table('profesors')
          ->join('profesores_carreras', 'profesors.id', '=', 'profesores_carreras.id_profesor')
          ->join('carreras', 'carreras.id', '=', 'profesores_carreras.id_carrera')
          ->select('carreras.nombre')
          ->where('profesors.id', '=', $this->id)
          ->get();
        $count = $carreras->count();
        if($count === 0)
          return "Ninguna";
        $carreras_str = "";
        $i = 0;
          foreach($carreras as $carrera){
            if($i === 0)
              $carreras_str = $carrera->nombre;
            elseif($i < $count)
              $carreras_str = $carreras_str.', '.$carrera->nombre;
            $i++;
        }
        return $carreras_str;
    }

//Retorna las divisiones como una cadena
    public function getDivisionesPorNombre()
    {
        $divisiones = DB::table('profesors')
          ->join('profesores_divisiones', 'profesors.id', '=', 'profesores_divisiones.id_profesor')
          ->join('divisions', 'divisions.id', '=', 'profesores_divisiones.id_division')
          ->select('divisions.nombre')
          ->where('profesors.id', '=', $this->id)
          ->get();
        $count = $divisiones->count();
        if($count === 0)
          return "Ninguna";
        $divisiones_str = "";
        $i = 0;
          foreach($divisiones as $division){
            if($i === 0)
              $divisiones_str = $division->nombre;
            elseif($i < $count)
              $divisiones_str = $divisiones_str.', '.$division->nombre;
            $i++;
        }
        return $divisiones_str;
    }

    public function getFacultad()
    {
        $facultad = Facultad::where('id', $this->facultad_id)->get()[0]->nombre;
        return $facultad;
    }
    public function getSugerenciaFinalSeminario($curso_id){
        $participante_curso = ParticipantesCurso::where('curso_id', $curso_id)
            ->where('profesor_id', $this->id)->first();
        if(!$participante_curso){
            return "NULL";
        }
        $encuesta = EncuestaFinalSeminario::where('participante_curso_id', $participante_curso->id)->first();
        if(!$encuesta){
            return "NULL";
        }
        if($encuesta->sug == "Ninguna" or $encuesta->sug == "NINGUNA" or $encuesta->sug == "En blanco"){
            return "NULL";
        }
        return $encuesta->sug;
    }
    public function getSugerenciaFinalCurso($curso_id){
        $participante_curso = ParticipantesCurso::where('curso_id', $curso_id)
            ->where('profesor_id', $this->id)->first();
        if(!$participante_curso){
            return "NULL";
        }
        $encuesta = EncuestaFinalCurso::where('participante_curso_id', $participante_curso->id)->first();
        if(!$encuesta){
            return "NULL";
        }
        if($encuesta->sug == "Ninguna" or $encuesta->sug == "En blanco"){
            return "NULL";
        }
        return $encuesta->sug;
    }
}
