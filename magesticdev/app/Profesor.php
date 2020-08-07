<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'nombres', 'apellido_paterno','apellido_materno','rfc','numero_trabajador','curp','categoria_nivel_id',
        'fecha_nacimiento','telefono','grado','email','usuario', 'fecha_alta','grado','comentarios','genero',
        'baja','causa_baja','semblanza_corta','facebook','unam','procedencia','facultad_id','carrera_id'
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
        $categoria = CategoriaNivel::findOrFail($this->categoria_nivel_id)->categoria;
        return $categoria;
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
            'Doctorado'=>'Doctorado'
        ];
        return $grado;
    }

    public function getIdCategoria()
    {
        return $this->categoria_nivel_id;
    }

    public function getDivisionNombre()
    {
        $division = Division::where('id', Carrera::where('id', $this->carrera_id)->get()[0]->id_division)->get();
        return $division[0]->getNombre();
    }
    public function getCarrera()
    {
        $carrera = Carrera::where('id', $this->carrera_id)->get()[0]->nombre;
        return $carrera;
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
            return "No contestó encuesta";
        }
        $encuesta = EncuestaFinalSeminario::where('participante_curso_id', $participante_curso->id)->first();
        if(!$encuesta){
            return "No contestó encuesta";
        }
        return $encuesta->sug;
    }
    public function getSugerenciaFinalCurso($curso_id){
        $participante_curso = ParticipantesCurso::where('curso_id', $curso_id)
            ->where('profesor_id', $this->id)->first();
        if(!$participante_curso){
            return "No contestó encuesta";
        }
        $encuesta = EncuestaFinalCurso::where('participante_curso_id', $participante_curso->id)->first();
        if(!$encuesta){
            return "No contestó encuesta";
        }
        return $encuesta->sug;
    }
    public function getGrado()
    {
      if ($this->grado == "Licenciatura"){
            $abrev= "Lic.";
      }
      else if ($this->grado == "Ingeniería"){
            $abrev= "Ing."; }
      else if ($this->grado == "Maestría"){
        if($this->genero == "masculino"){
            $abrev="Mtro.";
        }
        else if($this->genero == "femenino"){
            $abrev="Mtra.";
        }
      }
      else if ($this->grado == "Doctorado"){
          if($this->genero == "masculino"){
            $abrev="Dr.";
          }
          else if($this->genero == "femenino"){
            $abrev="Dra.";
          }
      }
      else{
        $abrev="";
      }
      return $abrev;
    }
}
