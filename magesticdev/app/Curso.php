<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

set_time_limit(120);

class Curso extends Model
{
    protected $table = 'cursos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','semestre_anio','semestre_pi','semestre_si','fecha_inicio','fecha_fin','hora_inicio','hora_fin','dias_semana',
        'numero_sesiones','sesiones','acreditacion','costo','cupo_maximo','cupo_minimo','catalogo_id','salon_id', 'sgc', 'fecha_envio_constancia', 'fecha_envio_reconocimiento'
    ];

    public function getTypeId(){
        $countTaller = 1;
        $countCurso = 1;
        $countSeminario = 1;
        $countEvento = 1;
        $countCursoTaller = 1;
        

        $cursos=Curso::all();
        $catalogoCursos = CatalogoCurso::all();
        foreach($cursos as $curso){
            $catalogoCurso=CatalogoCurso::find($curso->catalogo_id);
            if($catalogoCurso->id==$this->catalogo_id){
                if($catalogoCurso->tipo == "T"){
                    return $countTaller;
                }elseif($catalogoCurso->tipo == "C"){
                    return $countCurso;
                }elseif($catalogoCurso->tipo == "S"){
                    return $countSeminario;
                }elseif($catalogoCurso->tipo == "E"){
                    return $countEvento;
                }elseif($catalogoCurso->tipo == "CT"){
                    return $countCursoTaller;
                }else{
                    return "1";
                }
            }else{
                if($catalogoCurso->tipo == "T"){
                    $countTaller++;
                }elseif($catalogoCurso->tipo == "C"){
                    $countCurso++;
                }elseif($catalogoCurso->tipo == "S"){
                    $countSeminario++;
                }elseif($catalogoCurso->tipo == "E"){
                    $countEvento++;
                }elseif($catalogoCurso->tipo == "CT"){
                    $countCursoTaller++;
                }
            }



        }
    }
    public function getSGC(){
        return $this->sgc;
    }
    public function getCatalogoCurso(){
      $catalogo = CatalogoCurso::find($this->catalogo_id);
      return $catalogo;
    }
    public function getCupoMax(){
        return $this->cupo_maximo;
    }
    public function getCupoMin(){
        return $this->cupo_minimo;
    }
    public function getHoraInicio(){
        return $this->hora_inicio;
    }
    public function getHoraFin(){
        return $this->hora_fin;
    }
    public function getFechaFin(){
        return substr($this->fecha_fin,8).'/'.substr($this->fecha_fin,5,2).'/'.substr($this->fecha_fin,0,4);
    }
    //TODO:Arreglar este método, para obtener toda la fecha con carbon lista
    public function translate_month($month){
        if ($month == '01'){
            $month = 'enero';
        } elseif ($month == '02') {
            $month = 'febrero';
        } elseif ($month == '03') {
            $month = 'marzo';
        } elseif ($month == '04') {
            $month = 'abril';
        } elseif ($month == '05') {
            $month = 'mayo';
        } elseif ($month == '06') {
            $month = 'junio';
        } elseif ($month == '07') {
            $month = 'julio';
        } elseif ($month == '08') {
            $month = 'agosto';
        } elseif ($month == '09') {
            $month = 'septiembre';
        } elseif ($month == '10') {
            $month = 'octubre';
        } elseif ($month == '11') {
            $month = 'noviembre';
        } elseif ($month == '12') {
            $month = 'diciembre';
        }
        return $month;
    }
    public function getFechaInicio(){
        return substr($this->fecha_inicio,8).'/'.substr($this->fecha_inicio,5,2).'/'.substr($this->fecha_inicio,0,4);
    }

    public function getFecha(){
        
        $sesiones_array = explode(',' , $this->sesiones);
        //zona horaria para Carbon
        $tz='America/Mexico_City';

        //arrays utiles
        $meses_array = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $dias_semana_array = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');

        //se consiguen en Carbon las fechas de inicio y fin del curso además del auxiliar
        $fecha_inicio = $this->fecha_inicio;
        $fecha_fin = $this->fecha_fin;
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
        $anio_fin = $fecha_fin[0].$fecha_fin[1].$fecha_fin[2].$fecha_fin[3];
        $mes_fin = $fecha_fin[5].$fecha_fin[6];
        $anio_inicio = $fecha_inicio[0].$fecha_inicio[1].$fecha_inicio[2].$fecha_inicio[3];
        $mes_inicio = $fecha_inicio[5].$fecha_inicio[6];
        $auxYear = (int)$anio_inicio;
        $auxMonth = (int)$mes_inicio;
      
        $fecha_inicio = Carbon::createFromDate((int)$anio_inicio, (int)$mes_inicio, (int)$dia_inicio, $tz);
        $fecha_fin = Carbon::createFromDate((int)$anio_fin, (int)$mes_fin, (int)$dia_fin, $tz);
        $fecha_aux = Carbon::createFromDate((int)$anio_inicio, (int)$mes_inicio, (int)$dia_inicio, $tz);

        //se llena el array de los dias que se imparte el curso 
        //eg:[1,3,5] para un curso de lunes, miercoles y viernes
        $dias_curso_array = array();
        foreach ($dias_semana_array as $diaSemana) {
            if (substr_count($this->dias_semana, $diaSemana) > 0){
                array_push($dias_curso_array, array_search($diaSemana, $dias_semana_array)+1);

             }


        }
        $hayIntervalo = 0;
        //aqui se obtiene el posible intervalo de dias en una semana
        if (sizeof($dias_curso_array) >= 3) {
            $y = 0;
            for ($x = 0; $x < sizeof($dias_curso_array) && $hayIntervalo == 0; $x++) { 
                if ($dias_curso_array[($x+1) % sizeof($dias_curso_array)] - $dias_curso_array[$x] == 1) {
                    $y = $x + 1;
                    while ($dias_curso_array[($y+1) % sizeof($dias_curso_array)] - $dias_curso_array[$y] == 1) {
                        $y++;
                    }
                    if ($y - $x > 3) {
                        $hayIntervalo = $y - $x;
                    }
                }
            }
            $c = 0;
            $fecha_aux_i = Carbon::createFromDate((int)$anio_inicio, (int)$mes_inicio, (int)$dia_inicio, $tz);
            for ($s=0; $s < count($sesiones_array); $s++) { 
                $fecha_s = Carbon::createFromDate((int)substr($sesiones_array[$s],0,4), (int)substr($sesiones_array[$s],5,2), (int)substr($sesiones_array[$s],8), $tz);
                if ($fecha_aux_i->diffInDays($fecha_s) == 1) {
                    $c++;
                }else{$c = 0;}
                $fecha_aux_i = Carbon::createFromDate((int)substr($sesiones_array[$s],0,4), (int)substr($sesiones_array[$s],5,2), (int)substr($sesiones_array[$s],8), $tz);
            }
            if ($c < 4) {
                $hayIntervalo = 0;
            }
        }

        if(sizeof($dias_curso_array) > 0) {
        //ajustes para empatar fecha_inicio y fecha_fin con un dia de imparticion de curso
            while (!in_array(($fecha_inicio->dayOfWeek+7)%7, $dias_curso_array)) {
                $fecha_inicio->addDay();
            }
            while (!in_array(($fecha_fin->dayOfWeek+7)%7, $dias_curso_array)) {
                $fecha_fin->subDay();
            }

            if (strlen($this->sesiones)>0) {
                if (count($sesiones_array) == 1) {
                    $fecha_cadena = 'El día '.(int)substr($this->sesiones,8).' de '.$meses_array[((int)substr($this->sesiones,5,2))-1].' de '.substr($this->sesiones,0,4);
                }else{
                    $fecha_cadena = 'Los días '.(int)substr($sesiones_array[0],8);
                    for ($i=1; $i < count($sesiones_array)-1; $i++) { 
                        if (substr($sesiones_array[$i],0,4) != substr($sesiones_array[$i-1],0,4)) {
                            $fecha_cadena .= ' de '.$meses_array[((int)substr($sesiones_array[$i-1],5,2))-1].' de '.substr($sesiones_array[$i-1],0,4).'. '.(int)substr($sesiones_array[$i],8);
                        }elseif (substr($sesiones_array[$i],5,2) != substr($sesiones_array[$i-1],5,2)) {
                            $fecha_cadena .= ' de '.$meses_array[((int)substr($sesiones_array[$i-1],5,2))-1].'; '.(int)substr($sesiones_array[$i],8);
                        }else{
                            $fecha_cadena .= ', '.(int)substr($sesiones_array[$i],8);
                        }
                    }
                    $i = count($sesiones_array)-1;
                    if (substr($sesiones_array[$i],0,4) != substr($sesiones_array[$i-1],0,4)) {
                        $fecha_cadena .= ' de '.$meses_array[((int)substr($sesiones_array[$i-1],5,2))-1].' de '.substr($sesiones_array[$i-1],0,4).'. ';
                    }elseif (substr($sesiones_array[$i],5,2) != substr($sesiones_array[$i-1],5,2)) {
                        $fecha_cadena .= ' de '.$meses_array[((int)substr($sesiones_array[$i-1],5,2))-1].'; ';
                    }
                    $fecha_cadena .= ' y '.(int)substr($sesiones_array[$i],8).' de '.$meses_array[((int)substr($sesiones_array[$i],5,2))-1].' de '.substr($sesiones_array[$i],0,4).'.';
                }
            }
            else{
            
                //La magia
                //variable de retorno
                if ($fecha_inicio->diffInDays($fecha_fin) != 0){
                    $fecha_cadena = 'Los días ';
                    for (; $fecha_aux->diffInDays($fecha_fin) != 0; $fecha_aux->addDay()) {
                        if (in_array(($fecha_aux->dayOfWeek+7)%7, $dias_curso_array)){
                            if ($fecha_aux->year != $auxYear) {
                                $fecha_cadena .= ' de '.$meses_array[$auxMonth-1].' de '.(string)$auxYear.'. ';
                                $auxYear = $fecha_aux->year;
                                $auxMonth = $fecha_aux->month;
                                $fecha_cadena .= (string)$fecha_aux->day;
                            }
                            elseif ($fecha_aux->month != $auxMonth) {
                                $fecha_cadena .= ' de '.$meses_array[$auxMonth-1].'; ';
                                $auxMonth = $fecha_aux->month;
                                $fecha_cadena .= (string)$fecha_aux->day;
                            }else{
                                if ($fecha_aux->diffInDays($fecha_inicio) == 0){
                                    $fecha_cadena .= (string)$fecha_aux->day;
                                }else{
                                        $fecha_cadena .= ', '.(string)$fecha_aux->day;
                                }
                            }
                        }
                    }
                }else{
                    $fecha_cadena = 'El día '.$fecha_inicio->day;
                }


                //fianlizacion de la cadena
                if (in_array(($fecha_aux->dayOfWeek+7)%7, $dias_curso_array) && $fecha_inicio->diffInDays($fecha_fin) != 0){
                    $fecha_cadena .= ' y '.(string)$fecha_aux->day;
                }
                $fecha_cadena .= ' de '.$meses_array[$auxMonth-1].' de '.(string)$auxYear;
            }

            //Si la cadena tiene más de 90 caracteres se cambia el formato
            if (strlen($fecha_cadena) > 120 || $hayIntervalo > 1) {
                if ($anio_inicio == $anio_fin) {
                    if ($mes_inicio == $mes_fin) {
                        $fecha_cadena = 'Del '.$dia_inicio .' al '.$dia_fin.' de '.$meses_array[(int)$mes_fin-1].' de '.$anio_fin;      
                    }else{
                        $fecha_cadena = 'Del '.$dia_inicio.' de '.$meses_array[(int)$mes_inicio-1].' al '.$dia_fin.' de '.$meses_array[(int)$mes_fin-1].' de '.$anio_fin;   
                    }
                }else{
                    $fecha_cadena = 'Del '.$dia_inicio.' de '.$meses_array[(int)$mes_inicio-1].' de '.$anio_inicio.' al '.$dia_fin.' de '.$meses_array[(int)$mes_fin-1].' de '.$anio_fin;   
                }
            }
            return $fecha_cadena;
        }else{
            return $this->sesiones;
        }

    }

    public function getFecha_sinLeyenda(){
        return str_replace('El día ', '', str_replace('Los días ', '', $this->getFecha()));
    }

    public function getTipoCadena(){
        $catalogoCurso=CatalogoCurso::find($this->catalogo_id);
        $tipoStr="curso";
        if($catalogoCurso->tipo == "C"){
            $tipoStr = "curso";
        } elseif($catalogoCurso->tipo == "T"){
            $tipoStr = "taller";
        } elseif($catalogoCurso->tipo == "F"){
            $tipoStr = "foro";
        } elseif($catalogoCurso->tipo == "S"){
            $tipoStr = "seminario";
        } elseif($catalogoCurso->tipo == "CT"){
            $tipoStr = "curso - taller";
        } elseif($catalogoCurso->tipo == "E"){
            $tipoStr = "evento";
        }else{
            $tipoStr = "curso";
        }
        return $tipoStr;
    }
    public function getTipoCadenaUpper(){
        $catalogoCurso=CatalogoCurso::find($this->catalogo_id);
        if($catalogoCurso->tipo == "C"){
            $tipoStr = "Curso";
        } elseif($catalogoCurso->tipo == "T"){
           $tipoStr = "Taller";
        } elseif($catalogoCurso->tipo == "F"){
            $tipoStr = "Foro";
        } elseif($catalogoCurso->tipo == "S"){
            $tipoStr = "Seminario";
        } elseif($catalogoCurso->tipo == "CT"){
            $tipoStr = "Curso - taller";
        } elseif($catalogoCurso->tipo == "E"){
            $tipoStr = "Evento";
        } elseif($catalogoCurso->tipo == "D"){
            $tipoStr = "Módulo de Diplomado";
        }else{
            $tipoStr = "Curso";
        }
        return $tipoStr;
    }
    public function getContenido(){
        $catalogoCurso=CatalogoCurso::find($this->catalogo_id);
        $catalogoCurso->contenido;
        $contenidos=array();
        $cadena = '';
        for($i=0;$i<strlen($catalogoCurso->contenido);$i++)
        {
            if ($catalogoCurso->contenido[$i]=='-' and $i!=0){
                array_push($contenidos, $cadena);
                $cadena = '';
                $cadena = $cadena.$catalogoCurso->contenido[$i];
            }
            else{
                $cadena = $cadena.$catalogoCurso->contenido[$i];
            }
        }
        array_push($contenidos, $cadena);
        return $contenidos;
    }
    public function getNombreCurso(){
        $thisCatalogo = CatalogoCurso::findOrFail($this->catalogo_id);
        return $thisCatalogo->nombre_curso.' ('.$thisCatalogo->clave_curso.')';
    }
    public function getClave(){
        $thisCatalogo = CatalogoCurso::findOrFail($this->catalogo_id);
        return $thisCatalogo->clave_curso;
    }
    public function getNombreCursoSinClave(){
        $thisCatalogo = CatalogoCurso::findOrFail($this->catalogo_id);
        return $thisCatalogo->nombre_curso;
    }

    //TODO Optimizar este metodo y su padre
    public function getInteresados($tematicas){
        $interesados_collection = array();
        foreach($tematicas as $tematica){
            $encuestascursos = EncuestaFinalCurso::whereRaw("lower(unaccent(otros)) LIKE lower(unaccent('%".$tematica."%'))")->get();
            foreach($encuestascursos as $encuestacurso){
                $interesados = DB::table('_evaluacion_final_curso')
                            ->join('participante_curso', '_evaluacion_final_curso.participante_curso_id', '=', 'participante_curso.id')
                            ->select('participante_curso.id')
                            ->where('_evaluacion_final_curso.id', '=', $encuestacurso->id)
                            ->get();
                if($interesados->isEmpty())
                    continue;
                else
                    array_push($interesados_collection, $interesados);
            }
        }
        if (empty($interesados_collection))
            return 0; //No hubo interesados con esas tematicas
        return $interesados_collection;
    }

    public function getDuracion(){
        $thisCatalogo = CatalogoCurso::findOrFail($this->catalogo_id);
        return $thisCatalogo->duracion_curso;
    }


    public function getSemestre(){
        return $this->semestre_anio."-".$this->semestre_pi." ".$this->semestre_si." ";
    }

    public function getSalon(){
        $salon = Salon::findOrFail($this->salon_id)->sede;
        return $salon;
    }

    public function getInstanciaProfesores(){
       $profesor = Profesor::join('profesor_curso', 'profesors.id', '=', 'profesor_curso.profesor_id')
       ->join('cursos', 'cursos.id', '=', 'profesor_curso.curso_id')
       ->where('cursos.id', '=', $this->id)
       ->select('profesors.nombres', 'profesors.apellido_paterno', 'profesors.apellido_materno', 'profesors.semblanza_corta', 'profesors.abreviatura_grado')
       ->get();
        return $profesor;
    }
    public function getProfesores(){
        $profesoresCurso = ProfesoresCurso::where('curso_id',$this->id)->get();

        $cadena="";

        if ( count($profesoresCurso) == 1 ){
            $profesor=Profesor::find($profesoresCurso[0]->profesor_id);
            $cadena.=$profesor->nombres." ";
            $cadena.=$profesor->apellido_paterno." ";
            $cadena.=$profesor->apellido_materno;
            return $cadena;
        }
        foreach($profesoresCurso as $profesorCurso){
            $profesor=Profesor::find($profesorCurso->profesor_id);
            $cadena.=$profesor->nombres." ";
            $cadena.=$profesor->apellido_paterno." ";
            $cadena.=$profesor->apellido_materno."/";
        }
        $cadena= substr($cadena, 0, -1);
        return $cadena;
    }

    public function getProfesoresInst(){
        $profesoresCurso = ProfesoresCurso::where('curso_id',$this->id)->get();

        $cadena="";

        if ( count($profesoresCurso) == 1 ){
            $profesor=Profesor::find($profesoresCurso[0]->profesor_id);
            $cadena.=$profesor->nombres." ";
            $cadena.=$profesor->apellido_paterno." ";
            $cadena.=$profesor->apellido_materno;
            return $cadena;
        }
        foreach($profesoresCurso as $profesorCurso){
            $profesor=Profesor::find($profesorCurso->profesor_id);
            $cadena.=$profesor->nombres." ";
            $cadena.=$profesor->apellido_paterno." ";
            $cadena.=$profesor->apellido_materno."\n";
        }
        $cadena= substr($cadena, 0, -1);
        return $cadena;
    }

    public function getNumProfesoresInst(){
        $profesoresCurso = ProfesoresCurso::where('curso_id',$this->id)->get();        
        return count($profesoresCurso);
    }

    public function getProfesoresArray(){
        $profesoresCurso = ProfesoresCurso::where('curso_id',$this->id)->get();
        $cadena = "";
        $profesores = array();
        foreach($profesoresCurso as $profesorCurso){
            $profesor=Profesor::find($profesorCurso->profesor_id);
            $cadena.=$profesor->nombres." ";
            $cadena.=$profesor->apellido_paterno." ";
            $cadena.=$profesor->apellido_materno;
            $profesores[$profesor->id] = $cadena;
        }
        return $profesores;
    }
    public function getInstructores(){
        $instructores = Profesor::join('profesor_curso', 'profesors.id', '=', 'profesor_curso.profesor_id')
        ->join('cursos', 'cursos.id', '=', 'profesor_curso.curso_id')
        ->where('cursos.id', '=', $this->id)
        ->get();
        return $instructores;
    }
    public function getProfesoresCurso(){
      return ProfesoresCurso::where('curso_id', $this->id)->get();
    }

    public function getTemasInstrsSeminario(){
      $temas = array();
      $tmps = $this->getCatalogoCurso()->getTemasSeminario();
      foreach($tmps as $tmp){
        $instructores = ProfesoresCurso::where('curso_id', $this->id)
          ->where('tema_seminario_id', $tmp->id)->get();
        $pretemas = ["nombre" => $tmp->nombre, "id"=> $tmp->id, "instructor"=> 'Sin asignar'];
        if(!$instructores->isEmpty()){
          foreach($instructores as $index => $instructor){
            if($index === 0)
              $pretemas["instructor"] = $instructor->getProfesor()->getNombres2();
            else
              $pretemas["instructor"] = $pretemas["instructor"].', '.$instructor->getProfesor()->getNombres2();
          }
        }
        array_push($temas, $pretemas);
      }
      return $temas;
    }

    public function getParticipantes(){
        $profesor = Profesor::join('participante_curso', 'profesors.id', '=', 'participante_curso.profesor_id')
        ->join('cursos', 'cursos.id', '=', 'participante_curso.curso_id')
        ->where('cursos.id', '=', $this->id)
        ->select('profesors.*')
        ->get();
        return $profesor;
    }

    public function getId(){
        return $this->id;
    }
    public function getIdCatalogo(){
        return $this->catalogo_id;
    }

    public function getIdSalon(){

        return $this->salon_id;
    }
    public function getInstitucion(){
        $catcurso = CatalogoCurso::find($this->catalogo_id);
        return $catcurso->institucion;
    }
    
    public function getTipo(){
        $catcurso = CatalogoCurso::find($this->catalogo_id);
        return $catcurso->tipo;
    }
    public function getCoordinacionId(){
        $catcurso = CatalogoCurso::find($this->catalogo_id);
        return $catcurso->coordinacion_id;
    }

    public function getDiplomado(){
      return Diplomado::find($this->diplomado_id);
    }

    public function allNombreCurso(){
        $nombre = CatalogoCurso::all('nombre_curso','id');
        return $nombre;
    }
    public function allProfesor(){
        $profesors = Profesor::all();
        return $profesors;
    }
    public function allSalon(){
        $salon = Salon::all();
        return $salon;
    }
    public function getFechaEnvioConstancia(){
        return substr($this->fecha_envio_constancia,8).'/'.substr($this->fecha_envio_constancia,5,2).'/'.substr($this->fecha_envio_constancia,0,4);
    }
    public function getFechaEnvioReconocimiento(){
        return substr($this->fecha_envio_reconocimiento,8).'/'.substr($this->fecha_envio_reconocimiento,5,2).'/'.substr($this->fecha_envio_reconocimiento,0,4);
    }

}

