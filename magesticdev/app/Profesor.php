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
        'nombres', 'apellido_paterno','apellido_materno','rfc','numero_trabajador', 'categoria_nivel_id', 'categoria_nivel_2_id',
        'fecha_nacimiento','telefono','grado','abreviatura_grado','email','usuario', 'fecha_alta','grado','genero',
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

    public function getNombres2(){
      return $this->nombres." ".$this->apellido_paterno." ".$this->apellido_materno;
  }

    public function getNombresArchivo(){
      return $this->apellido_paterno.$this->apellido_materno.str_replace(' ', '', $this->nombres);
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

    public function getEdad(){
      return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function getCategoria_1(){
        if($this->categoria_nivel_id)
            return CategoriaNivel::findOrFail($this->categoria_nivel_id)->categoria;
        else
            return "";
    }

    public function getCategoria_2(){
      if($this->categoria_nivel_2_id)
          return CategoriaNivel::findOrFail($this->categoria_nivel_2_id)->categoria;
      else
          return "";
  }

  public function getCatAbr_1(){
    if($this->categoria_nivel_id)
      return CategoriaNivel::findOrFail($this->categoria_nivel_id)->abreviatura;
    else
      return '';
  }

  public function getCatAbr_2(){
    if($this->categoria_nivel_2_id)
      return CategoriaNivel::findOrFail($this->categoria_nivel_2_id)->abreviatura;
    else
      return '';
  }

  public function getCatAbr(){
    if ($this->categoria_nivel_id )
      $cat1 = CategoriaNivel::findOrFail($this->categoria_nivel_id)->abreviatura;
    else
      $cat1 = '';
    if ($this->categoria_nivel_2_id)
      $cat2 = CategoriaNivel::findOrFail($this->categoria_nivel_2_id)->abreviatura;
    else
      $cat2 = '';
    if($cat1 != '' and $cat2 != '')
      return $cat1.', '.$cat2;
    elseif($cat1 == '' )
      return $cat2;
    elseif($cat2 == '' )
      return $cat1;
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

    public function getIdCategoria_1()
    {
        return $this->categoria_nivel_id;
    }

    public function getIdCategoria_2()
    {
        return $this->categoria_nivel_2_id;
    }

    public function getDivision(){
      $div_nombre = '';
      $divisiones = DB::table('profesores_divisiones AS pd')
        ->join('divisions AS d', 'pd.id_division', '=', 'd.id')
        ->select('d.nombre')
        ->where('pd.id_profesor', '=', $this->id)->get();
      foreach($divisiones as $index => $division){
        if($index == 0)
          $div_nombre = $division->nombre;
        else
          $div_nombre = $division->nombre.', '.$div_nombre;
      }
      return $div_nombre;
    }

    public function getDivisionAbr(){
      $div_nombre = '';
      $divisiones = DB::table('profesores_divisiones AS pd')
        ->join('divisions AS d', 'pd.id_division', '=', 'd.id')
        ->select('d.abreviatura')
        ->where('pd.id_profesor', '=', $this->id)->get();
      foreach($divisiones as $index => $division){
        if($index == 0)
          $div_nombre = $division->abreviatura;
        else
          $div_nombre = $division->abreviatura.', '.$div_nombre;
      }
      return $div_nombre;
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
