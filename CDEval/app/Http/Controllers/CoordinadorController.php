<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session; 
use App\Curso;
use App\CatalogoCurso;
use App\Profesor;
use App\ProfesoresCurso;
use App\EvaluacionXCurso;
use App\Coordinacion;
use Illuminate\Support\Facades\Storage;
use Mail;
use PDF;
use DB; 

class CoordinadorController extends Controller
{

    /**
     * Función que retorna a la vista de super usuario
     * @return Vista super usuario
     */
    public function index(){

        $coordinaciones = Coordinacion::all();

        return view('pages.superadmin')
            ->with("coordinaciones",$coordinaciones); //Route -> coordinador
    }

    /**
     * Función en estado beta
     */
    public function searchCursos(Request $request){      
        if ($request->type == "nombre") {
            $catalogos_res = CatalogoCurso::select('id')->where('nombre_curso','ILIKE','%'.$request->pattern.'%')->get();
            $res_busqueda = Curso::whereIn('catalogo_id', $catalogos_res)
                ->get();
            return view('pages.cursos')->with("cursos",$res_busqueda);
            
        }elseif ($request->type == "instructor"){
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $profesores = Profesor::select('id')->where('nombres','ILIKE','%'.$word.'%')
                ->orWhere('apellido_paterno','ILIKE','%'.$word.'%')
                ->orWhere('apellido_materno','ILIKE','%'.$word.'%')
                ->get();
            }
            $curso_prof = ProfesoresCurso::select('curso_id')->whereIn('profesor_id', $profesores)->get();
            $res_busqueda = Curso::whereIn('id',$curso_prof)->get();
            return view('pages.cursos')->with("cursos",$res_busqueda);
        }
    }

    /**
     * Función encargada de redirigir a la página de cursos con los datos de todos los cursos
     * @param $encargado_id: id del curso, $message: mensaje a mostrar en pantalla
     * @return La vista pages.cursos con sus datos necesarios
     */
    public function cursosCoordinaciones($encargado_id,$message){
        $coordinaciones = Coordinacion::all();

        $catalogo_curso = DB::table('catalogo_cursos')
            ->where('coordinacion_id',$encargado_id)
            ->get();

        $cursos = array();
        foreach($catalogo_curso as $catalogo){
            $cursosDatos = DB::table('cursos')
                ->where('catalogo_id',$catalogo->id)
                ->get();
            foreach($cursosDatos as $curso){
                $datos = array();
                $profesores = array();
                $profesores_curso = DB::table('profesor_curso')
                    ->where('curso_id',$curso->id)
                    ->get();
                foreach($profesores_curso as $profesor_curso){
                    $profesor = DB::table('profesors')
                        ->where('id',$profesor_curso->profesor_id)
                        ->get();
                    array_push($profesores,$profesor);
                }
                array_push($datos,$curso);
                array_push($datos,$catalogo);
                array_push($datos,$profesores);
                array_push($cursos,$datos);
            }
        }        
        return view("pages.cursos")
            ->with("cursos",$cursos)
            ->with("coordinaciones",$coordinaciones)
            ->with('encargado_id',$encargado_id)
            ->with('message',$message);
    }



    public function searchCursosCoordinaciones(Request $request){

    }
    
    /**
     * Función encargada de retornar la vista de sesiones
     * @return La vista pages.sesiones
     */
    public function sesiones(){
        $evaluacion = EvaluacionXCurso::all();
        $coordinaciones = Coordinacion::all();
        //return $evaluacion;
        return view('pages.sesiones')
        ->with("coordinaciones",$coordinaciones);
    }

    /**
     * Función encargada de retornar la vista de globales
     * @return La vista pages.globales
     */
    public function globales(){
        $coordinaciones = Coordinacion::all();
        return view('pages.globales')
        ->with("coordinaciones",$coordinaciones);
    }
    
    /**
     * Función encargada de retornar a la vista pages.instructores
     * @return La vista pages.instructores
     */
    public function instructores(){
        return view("pages.instructores");
    }

    /**
     * Función encargada de retornar la descarga del pdf de la vista Evaluacion_area.pdf
     * @return La descarga del pdf Evaluacion_area
     */
    public function area_pdf(){
        $pdf = PDF::loadView('pages.area');
        return $pdf->download('Evaluacion_area.pdf');
    }

    /**
     * Función encargada activadora para obtener el pdf con las evaluaciones de todos los cursos de cierta fecha
     * @param $request:fecha ingresada por el usuario
     * @return Lo retornado por la función enviarVista
     */
    public function enviarGlobal(Request $request){
        //Obtenemos la fecha elegida por el usuario
        $fecha = $request->get('semestre');
        $semestre = explode('-',$fecha);

        //Obtenemos los cursos correspondientes al semestre elegido por el usuario
        $cursos = DB::table('cursos')
            ->where([['cursos.semestre_anio',$semestre[0]],['cursos.semestre_pi',$semestre[1]]])
            ->get();

        //Indicamos la vista a observar
        $lugar = "pages.reporte_final_global";

        return $this->enviarVista($fecha, $cursos, "", $lugar,0,'elegir.fecha');
    }

    /**
     * Funcion encargada de retornar ya sea el reporte de evaluaciones globales o por area en vista o formato pdf
     * @param $request (fecha y coordinación elegidas por el usuario), $cursos: cursos obtenidos por la función activadora,
     * $lugar: vista final, $pdf variable booleana que indica si se quiere o no el pdf, $inicio: ruta que mandó a llamar la función
     * @return Dependiendo del caso ya sea la vista seleccionada o el pdf de la vista seleccionada
     */
    public function enviarVista($request, $cursos, $nombreCoordinacion, $lugar, $pdf, $inicio){

        //Obtenemos todos los coordinadores
        $coordinaciones = Coordinacion::all();

        $evaluacionesCursos = array();

        $nombresCursos = array();
        $inscritos = 0;
        $acreditaron = 0;
        $capacidad_total = 0;
        $asistieron = 0;

        //Usado para la seccion 2 de evaluacion_global
        foreach($cursos as $curso){

            //Aumentamos la capacidad total de todos los cursos
            $capacidad_total += intval($curso->cupo_maximo);
            $catalogo = DB::table('catalogo_cursos')
                ->where('id',$curso->catalogo_id)
                ->get();

            //Obtenemos los nombres de los cursos
            array_push($nombresCursos,$catalogo[0]->nombre_curso);

            //Las evaluaciones finales de los cursos
            $eval = DB::table('_evaluacion_final_curso')
                ->where('curso_id',$curso->id)
                ->get();
            
            //Las evaluaciones finales de los seminarios
            $eval2 = DB::table('_evaluacion_final_seminario')
                ->where('curso_id',$curso->id)
                ->get();

            //Obtenemos los participantes de los cursos
            $participantes = DB::table('participante_curso')
                ->where('curso_id',$curso->id)
                ->get();

            //Necesario para el factor de acreditacion
            foreach($participantes as $participante){
                if($participante->acreditacion == 1){
                    //Aumentamos la cantidad de acreditaciones
                    $acreditaron++;
                }
                if($participante->asistencia == 1){
                    //Aumentamos la cantidad de asistencia
                    $asistieron++;
                }
            }

            //Aumentamos la cantidad de inscritos
            $inscritos += sizeof($participantes);

            //Si hay evaluacions finales de cursos los incluimos en el arreglo de evaluacionesCursos
            if(sizeof($eval)>0){
                array_push($evaluacionesCursos,$eval);
            }
            //Si hay evaluacions finales de seminarios los incluimos en el arreglo de evaluacionesCursos
            if(sizeof($eval2)>0){
                array_push($evaluacionesCursos,$eval2);
            }
        }

        if(sizeof($evaluacionesCursos)==0){
            return redirect()->route($inicio,['Curso no ha sido evaluado']);
        }

        $DP=0;
        $DH=0;
        $CO=0;
        $DI=0;
        $Otros=0;
        $DPtematica = array();
        $DHtematica = array();
        $COtematica = array();
        $DItematica = array();
        $Otrostematica = array();
        //Obtenemos la cantidad de participantes de cada division y las tematcias solicitadas por cada division
        foreach($evaluacionesCursos as $evals)
            foreach($evals as $evaluacion){
                $array = explode(',',$evaluacion->conocimiento);
                foreach($array as $elem){
                    if($elem[2] == 1 || $elem[1] == 1){
                        $DP++;
                        array_push($DPtematica,$evaluacion->tematica);
                    }else if($elem[2] == 2 || $elem[1] == 2){
                        $DH++;
                        array_push($DHtematica,$evaluacion->tematica);
                    }else if($elem[2] == 3 || $elem[1] == 3){
                        $CO++;
                        array_push($COtematica,$evaluacion->tematica);
                    }else if($elem[2] == 4 || $elem[1] == 4){
                        $DI++;
                        array_push($DItematica,$evaluacion->tematica);
                    }else if($elem[2] == 5 || $elem[1] == 5){
                        $Otros++;
                        array_push($Otrostematica,$evaluacion->tematica);
                    }
                }
		    }
		
        $alumnos = 0;
        $contestaron = 0;
        $recomendaciones = 0;
        $alumnosRecomendaron = 0;
        $positivas = 0;
        $preguntas = 0;
        $respuestasContenido = 0;
        $respuestasCoordinacion = 0;
        $horariosCurso = array();
        $profesoresRecontratar = array();
        $curso_recomendaron = 0;
        $desempenioProfesor = 0;
        $evaluacionProfesor = 0;

        foreach($evaluacionesCursos as $curso){
            $curso_id = $curso[0]->curso_id;
            $profesores = DB::table('profesor_curso')
                ->where('curso_id',$curso_id)
                ->get();

            $acreditaronCurso = 0;
            $alumno_curso = 0;
            $recomendaciones_curso = 0;
            $alumnos_recomendaron_curso = 0;
            $positivas_curso = 0;
            $preguntas_curso = 0;

            foreach($curso as $evaluacion){

                $alumno_curso++;

                //Obtenemos los datos del alumno
                $alumno = DB::table('participante_curso')
                    ->where('id',$evaluacion->participante_curso_id)
                    ->get();
                
                //Obtenemos numero de acreditacion de los usuarios
                if(intval($alumno[0]->acreditacion) == 1){
                    $acreditaronCurso++;
                }

                //Obtenemos y guardamos los horarios pedidos por cada usuario
                $horarios = array($evaluacion->horarios,$evaluacion->horarioi);
                array_push($horariosCurso,$horarios);

                $contestaron++;

                //Necesario para obtener el factor de recomendacion
                //En este caso necesitamos obtener el factor de recomendacion general (recomendaciones) y el individual de cada curso (recomendaciones_curso)
                if($evaluacion->p7 == 1){
                    $recomendaciones_curso++;
                    $alumnos_recomendaron_curso++;
                    $recomendaciones++;
                    $alumnosRecomendaron++;
                }else if($evaluacion->p7 == 0){
                    $alumnos_recomendaron_curso++;
                    $alumnosRecomendaron++;
                }

                //Obtenemos la cantidad de preguntas positivas del curso valor >= 60
                //De las preguntas 1_1 a 1_5 obtenemmos las evaluaciones del contenido del curso
                if($evaluacion->p1_1 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasContenido += $evaluacion->p1_1;
                    if($evaluacion->p1_1 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p1_2 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasContenido+= $evaluacion->p1_2;
                    if($evaluacion->p1_2 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p1_3 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasContenido+= $evaluacion->p1_3;
                    if($evaluacion->p1_3 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p1_4 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasContenido+= $evaluacion->p1_4;
                    if($evaluacion->p1_4 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p1_5 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasContenido+= $evaluacion->p1_5;
                    if($evaluacion->p1_5 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
    
                if($evaluacion->p2_1 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    if($evaluacion->p2_1 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p2_2 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    if($evaluacion->p2_2 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p2_3 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    if($evaluacion->p2_3 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p2_4 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    if($evaluacion->p2_4 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
    
                //De las preguntas 3_1 a 3_4 obtenemos el puntaje dado a la coordinacion
                if($evaluacion->p3_1 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasCoordinacion += $evaluacion->p3_1;
                    if($evaluacion->p3_1 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p3_2 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasCoordinacion += $evaluacion->p3_2;
                    if($evaluacion->p3_2 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p3_3 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasCoordinacion += $evaluacion->p3_3;
                    if($evaluacion->p3_3 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p3_4 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $respuestasCoordinacion += $evaluacion->p3_4;
                    if($evaluacion->p3_4 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
    
                //De la 4_1 a la 4_11 obtenemos la evaluacion del primer instructor
                //Queremos tanto el desempeño del instructor del curso como la cantidad de preguntas positivas del instructor
                if($evaluacion->p4_1 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_1;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_1 == 1){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_2 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_2;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_2 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_3 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_3;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_3 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_4 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_4;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_4 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_5 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_5;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_5 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_6 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_6;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_6 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_7 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_7;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_7 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_8 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_8;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_8 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_9 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_9;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_9 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_10 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_10;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_10 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p4_11 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p4_11;
                    $evaluacionProfesor++;
                    if($evaluacion->p4_11 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
    
                //De la 5_1 a la 5_11 obtenemos la evaluacion del segundo instructor
                //Queremos tanto el desempeño del instructor del curso como la cantidad de preguntas positivas del instructor
                if($evaluacion->p5_1 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_1;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_1 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_2 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_2;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_2 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_3 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_3;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_3 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_4 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_4;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_4 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_5 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_5;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_5 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_6 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_6;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_6 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_7 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_7;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_7 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_8 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_8;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_8 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_9 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_9;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_9 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_10 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_10;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_10 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p5_11 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p5_11;
                    $evaluacionProfesor++;
                    if($evaluacion->p5_11 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
    
                //De la 6_1 a la 6_11 obtenemos la evaluacion del tercer instructor
                //Queremos tanto el desempeño del instructor del curso como la cantidad de preguntas positivas del instructor
                if($evaluacion->p6_1 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_1;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_1 == 1){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_2 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_2;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_2 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_3 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_3;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_3 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_4 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_4;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_4 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_5 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_5;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_5 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_6 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_6;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_6 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_7 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_7;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_7 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_8 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    if($evaluacion->p6_8 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_9 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_9;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_9 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_10 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_10;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_10 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
                if($evaluacion->p6_11 >= 20){
                    $preguntas++;
                    $preguntas_curso++;
                    $desempenioProfesor += $evaluacion->p6_11;
                    $evaluacionProfesor++;
                    if($evaluacion->p6_11 > 60){
                        $positivas++;
                        $positivas_curso++;
                    }
                }
            }

            if($preguntas_curso == 0){
                $preguntas_curso = 1;
            }
            if($alumno_curso == 0){
                $alumno_curso = 1;
            }
            if($recomendaciones_curso == 0){
                $recomendaciones_curso = 1;
            }

            //Obtenemos factor de calidad del curso iterado, su factor de acreditacion y de recomendacion
            $factor_calidad_curso = ($positivas_curso*100)/$preguntas_curso;
            $factora_acreditacion = ($acreditaronCurso*100)/$alumno_curso;
            $factor_recomendacion_curso = ($alumnos_recomendaron_curso*100)/$recomendaciones_curso;

            //Si un curso obtiene calificacion >= 80 en cada uno de los tres factores sus profesores se vuelven a contratar
            if($factor_calidad_curso >= 80 && $factora_acreditacion >= 80 && $factor_recomendacion_curso >= 80){
                //Obtenemos los datos de los profesores del curso
                foreach($profesores as $profesors){
                    $profesor = DB::table('profesors')
                        ->where('id',$profesors->profesor_id)
                        ->get();
                    $inList = False;
                    //Buscamos no repetir profesores en la lista
                    foreach($profesoresRecontratar as $profesores){
                        if($profesores->id == $profesor[0]->id){
                            $inList = True;
                            break;
                        }
                    }
                    //Guardamos los profesores en una lista a retornar
                    if($inList == false){
                        array_push($profesoresRecontratar,$profesor[0]);
                    }
                }
            }

        }


        $factor_acreditacion = 0;
        $factor_calidad = 0;
        $promedio_coordinacion = 0;
        $promedio_contenido = 0;
        $factor_recomendacion = 0;
        $factor_instructor = 0;
        $factor_ocupacion = 0;

        //Obtenemos los factores de recomendacion
        //Necesario evitar la division entre cero, es posible pedir ver resumen de una fecha sin cursos
        if($alumnosRecomendaron != 0){
            $factor_recomendacion = round($recomendaciones*100 / $alumnosRecomendaron,2);
        }
        if($inscritos != 0){
            $factor_acreditacion = round($acreditaron*100 / $inscritos,2);
        }
        if($preguntas != 0){
            $factor_calidad = round($positivas*100 / $preguntas,2);
        }
        if($contestaron != 0){
            $promedio_coordinacion = round($respuestasCoordinacion / ($contestaron*4),2);
            $promedio_contenido = round($respuestasContenido / ($contestaron*5),2);
        }
        if($evaluacionProfesor != 0){
            $factor_instructor = round($desempenioProfesor / $evaluacionProfesor,2);
        }
        if($capacidad_total != 0){
            $factor_ocupacion = round((($inscritos*100)-1) / $capacidad_total,2);
        }

        $aritmetico = [0,0,0,0];
        if(strcmp($nombreCoordinacion,"")==0){
            $aritmetico = $this->calculaAritmetico($cursos);
            //return $this->calculaAritmetico($cursos);
        }else{
            $aritmetico = $this->calculaAritmeticoArea($cursos, $nombreCoordinacion);
        }

        //Si el usuario indico descargar un pdf se procedera a realizarlo
        if($pdf == 1){
            //Retornamos la funcion que permite la descarga del pdf
            return $this->descargarPDF($nombresCursos,$request,$acreditaron,$inscritos,$contestaron,$factor_ocupacion,$factor_recomendacion,$factor_acreditacion,$factor_calidad,$DP,$DH,$CO,$DI,$Otros,$DPtematica,$DItematica,$COtematica,$DHtematica,$Otrostematica,$coordinaciones,$horariosCurso,$promedio_coordinacion,$promedio_contenido,$profesoresRecontratar,$factor_instructor,$asistieron,$nombreCoordinacion,$lugar,$aritmetico[0],$aritmetico[1],$aritmetico[2],$aritmetico[3]);
        }

        //Retornamos la vista correspondiente (seleccionados por fecah o seleccionados por fecha y coordinacion) con los datos calculados
        return view($lugar)
            ->with('nombres',$nombresCursos)
            ->with('periodo',$request)
            ->with('acreditaron',$acreditaron)
            ->with('inscritos',$inscritos)
            ->with('contestaron',$contestaron)
            ->with('factor_ocupacion',$factor_ocupacion)
            ->with('factor_ocupacion',$factor_ocupacion)
            ->with('factor_recomendacion',$factor_recomendacion)
            ->with('factor_acreditacion',$factor_acreditacion)
            ->with('positivas',$factor_calidad)
            ->with('DP',$DP)
            ->with('DH',$DH)
            ->with('CO',$CO)
            ->with('DI',$DI)
            ->with('Otros',$Otros)
            ->with('DPtematicas',$DPtematica)
            ->with('DItematicas',$DItematica)
            ->with('COtematicas',$COtematica)
            ->with('DHtematicas',$DHtematica)
            ->with('Otrostematicas',$Otrostematica)
            ->with('coordinaciones',$coordinaciones)
            ->with('horarios',$horariosCurso)
            ->with('coordinacion',$promedio_coordinacion)
            ->with('contenido',$promedio_contenido)
            ->with('profesors',$profesoresRecontratar)
            ->with('instructor',$factor_instructor)
            ->with('asistencia',$asistieron)
            ->with('nombreCoordinacion',$nombreCoordinacion)
            ->with('aritmetico_contenido',$aritmetico[0])
            ->with('aritmetico_instructor',$aritmetico[1])
            ->with('aritmetico_coordinacion',$aritmetico[2])
            ->with('aritmetico_recomendacion',$aritmetico[3]);
    }

    /**
     * Función encargada de obtener los cálculos aritméticos de la evaluación global
     * @param $cursos: cursos obtenidos según la selecion del usuario
     * @return Los cálculos aritméticos
     */
    public function calculaAritmetico($cursos){
        //Obtenemos la fecha seleccionada
        $semestre_anio = $cursos[0]->semestre_anio;
        $semestre_pi = $cursos[0]->semestre_pi;

        $coordinaciones = Coordinacion::all();
        $catalogo_coordinaciones = array();

        //Obtenemos los cursos de cada coordinación de la fecha seleccionada
        foreach($coordinaciones as $coordinacion){
            $cursos = DB::table('cursos')
                ->join('catalogo_cursos','cursos.catalogo_id','=','catalogo_cursos.id')
                ->select('cursos.id','catalogo_cursos.nombre_curso','catalogo_cursos.tipo')
                ->where([['catalogo_cursos.coordinacion_id',$coordinacion->id],['cursos.semestre_anio',$semestre_anio],['cursos.semestre_pi',$semestre_pi]])
                ->get();
            
            if(sizeof($cursos)>0){
                array_push($catalogo_coordinaciones,$cursos);
            }
        }

        $contenido_promedio = 0;
        $instructor_promedio = 0;
        $coordinacion_promedio = 0;
        $factor_recomendacion_promedio = 0;
        $tam_coordinacion = 0;

        //Empezamos a iterar cada coordinación
        foreach($catalogo_coordinaciones as $coordinacion){

            $contenido_curso = 0;
            $instructor_curso_1 = 0;
            $instructor_curso_2 = 0;
            $instructor_curso_3 = 0;
            $coordinacion_curso = 0;
            $factor_recomendacion_curso = 0;
            $tam = 0;
            $tam2 = 0;
            $tam3 = 0;

            $tam_coordinacion++;

            //Empezamos a iterar los cursos de cada coordinación
            foreach($coordinacion as $curso){
                $evals = 0;
                //Obtenemos las evaluaciones
                if(strcmp($curso->tipo,'S')==0){
                    $evals = DB::table('_evaluacion_final_seminario')
                        ->where('curso_id',$curso->id)
                        ->get();
                }else{
                    $evals = DB::table('_evaluacion_final_curso')
                        ->where('curso_id',$curso->id)
                        ->get();   
                }

                $tam += sizeof($evals);

                //Iteramos las evaluaciones y acumulamos sus valores
                foreach($evals as $eval){

                    $contenido_curso += $eval->p1_1;
                    $contenido_curso += $eval->p1_2;
                    $contenido_curso += $eval->p1_3;
                    $contenido_curso += $eval->p1_4;
                    $contenido_curso += $eval->p1_5;

                    $coordinacion_curso += $eval->p3_1;
                    $coordinacion_curso += $eval->p3_2;
                    $coordinacion_curso += $eval->p3_3;
                    $coordinacion_curso += $eval->p3_4;

                    $instructor_curso_1 += $eval->p4_1;
                    $instructor_curso_1 += $eval->p4_2;
                    $instructor_curso_1 += $eval->p4_3;
                    $instructor_curso_1 += $eval->p4_4;
                    $instructor_curso_1 += $eval->p4_5;
                    $instructor_curso_1 += $eval->p4_6;
                    $instructor_curso_1 += $eval->p4_7;
                    $instructor_curso_1 += $eval->p4_8;
                    $instructor_curso_1 += $eval->p4_9;
                    $instructor_curso_1 += $eval->p4_10;
                    $instructor_curso_1 += $eval->p4_11;

                    //En caso de tener de que se haya evaluado un segundo instructor acumulamos sus calificaciones
                    if($eval->p5_1 >= 20){
                        $tam2++;
                        $instructor_curso_2 += $eval->p5_1;
                        $instructor_curso_2 += $eval->p5_2;
                        $instructor_curso_2 += $eval->p5_3;
                        $instructor_curso_2 += $eval->p5_4;
                        $instructor_curso_2 += $eval->p5_5;
                        $instructor_curso_2 += $eval->p5_6;
                        $instructor_curso_2 += $eval->p5_7;
                        $instructor_curso_2 += $eval->p5_8;
                        $instructor_curso_2 += $eval->p5_9;
                        $instructor_curso_2 += $eval->p5_10;
                        $instructor_curso_2 += $eval->p5_11; 
                    }

                    //En caso de tener de que se haya evaluado un tercer instructor acumulamos sus calificaciones
                    if($eval->p6_1 >= 20){
                        $tam3++;
                        $instructor_curso_3 += $eval->p6_1;
                        $instructor_curso_3 += $eval->p6_2;
                        $instructor_curso_3 += $eval->p6_3;
                        $instructor_curso_3 += $eval->p6_4;
                        $instructor_curso_3 += $eval->p6_5;
                        $instructor_curso_3 += $eval->p6_6;
                        $instructor_curso_3 += $eval->p6_7;
                        $instructor_curso_3 += $eval->p6_8;
                        $instructor_curso_3 += $eval->p6_9;
                        $instructor_curso_3 += $eval->p6_10;
                        $instructor_curso_3 += $eval->p6_11; 
                    }

                    //incrementamos el número de profesores que recomendaron el curso
                    if(intval($eval->p7) == 1){
                        $factor_recomendacion_curso++;
                    }
                }
            }

            //Serie de pasos necesarios para obtener el promedio de la coordinación de cada variable
            $divisor = 1;
            if($tam2 != 0){
                $divisor = 2;
            }else{
                $tam2 = 1;
            }
            if($tam3 != 0){
                $divisor = 3;
            }else{
                $tam3 = 1;
            }

            $contenido_promedio += $contenido_curso/($tam*5);
            $instructor_promedio += (($instructor_curso_1/($tam*11))+($instructor_curso_2/($tam2*11))+($instructor_curso_3/($tam3*11)))/$divisor;
            $coordinacion_promedio += $coordinacion_curso/($tam*4);
            $factor_recomendacion_promedio += ($factor_recomendacion_curso*100/$tam);

        }

        //Obtenemos el promedio de todas las coordinaciones
        $factor_contenido_aritmetico = round($contenido_promedio / $tam_coordinacion,2);
        $factor_instructor_aritmetico = round($instructor_promedio / $tam_coordinacion,2);
        $factor_coordinacion_aritmetico = round($coordinacion_promedio / $tam_coordinacion,2);
        $factor_recomendacion_aritmetico = round($factor_recomendacion_promedio / $tam_coordinacion,2);

        $aritmetico = [$factor_contenido_aritmetico,$factor_instructor_aritmetico,$factor_coordinacion_aritmetico,$factor_recomendacion_aritmetico];
        return $aritmetico;

    }

    /**
     * Función encargada de obtener los cálculos aritméticos de la evaluación por área
     * @param $cursos: cursos obtenidos según la selecion del usuario
     * @return Los cálculos aritméticos
     */
    public function calculaAritmeticoArea($cursos, $nombreCoordinacion){

        $contenido_promedio = 0;
        $instructor_promedio = 0;
        $coordinacion_promedio = 0;
        $factor_recomendacion_promedio = 0;
        $tam_coordinacion = 0;
        
        //Iteramos cada curso del área seleccionada
        foreach($cursos as $curso){
            $tam_coordinacion++;
            //Obtenemos el catálogo y evaluaciones de dichos cursos
            $catalogo_curso = DB::table('catalogo_cursos')
                ->where('id',$curso->catalogo_id)
                ->get();
            if(strcmp($catalogo_curso[0]->tipo,'S') == 0)
                $evals = DB::table('_evaluacion_final_seminario')
                    ->where('curso_id',$curso->id)
                    ->get();
            else            
                $evals = DB::table('_evaluacion_final_curso')
                    ->where('curso_id',$curso->id)
                    ->get();    

            $tam_curso = 0;
            $contenido_curso = 0;
            $instructor_1 = 0;
            $coordinacion_curso = 0;
            $factor_recomendacion_curso = 0;
            $tam2 = 0;
            $tam3 = 0;
            $instructor_2 = 0;
            $instructor_3 = 0;

            //Iteramos las evaluaciones de cada curso y acumulamos las calificaciones de cada rubro
            foreach($evals as $eval){
                $tam_curso++;
                $contenido_curso += $eval->p1_1;
                $contenido_curso += $eval->p1_2;
                $contenido_curso += $eval->p1_3;
                $contenido_curso += $eval->p1_4;
                $contenido_curso += $eval->p1_5;

                $coordinacion_curso += $eval->p3_1;
                $coordinacion_curso += $eval->p3_2;
                $coordinacion_curso += $eval->p3_3;
                $coordinacion_curso += $eval->p3_4; 

                $instructor_1 += $eval->p4_1;
                $instructor_1 += $eval->p4_2;
                $instructor_1 += $eval->p4_3;
                $instructor_1 += $eval->p4_4;
                $instructor_1 += $eval->p4_5;
                $instructor_1 += $eval->p4_6; 
                $instructor_1 += $eval->p4_7; 
                $instructor_1 += $eval->p4_8; 
                $instructor_1 += $eval->p4_9; 
                $instructor_1 += $eval->p4_10;
                $instructor_1 += $eval->p4_11;

                //Si hay dos profesores acumulamos la evaluación del segundo
                if($eval->p5_1>=20){
                    $tam2++;
                    $instructor_2 += $eval->p5_1;
                    $instructor_2 += $eval->p5_2;
                    $instructor_2 += $eval->p5_3;
                    $instructor_2 += $eval->p5_4;
                    $instructor_2 += $eval->p5_5;
                    $instructor_2 += $eval->p5_6; 
                    $instructor_2 += $eval->p5_7; 
                    $instructor_2 += $eval->p5_8; 
                    $instructor_2 += $eval->p5_9; 
                    $instructor_2 += $eval->p5_10;
                    $instructor_2 += $eval->p5_11;
                }

                //Si hay tres profesores acumulamos la evaluación del tecero
                if($eval->p6_1>=20){
                    $tam3++;
                    $instructor_3 += $eval->p6_1;
                    $instructor_3 += $eval->p6_2;
                    $instructor_3 += $eval->p6_3;
                    $instructor_3 += $eval->p6_4;
                    $instructor_3 += $eval->p6_5;
                    $instructor_3 += $eval->p6_6; 
                    $instructor_3 += $eval->p6_7; 
                    $instructor_3 += $eval->p6_8; 
                    $instructor_3 += $eval->p6_9; 
                    $instructor_3 += $eval->p6_10;
                    $instructor_3 += $eval->p6_11;
                }

                if(intval($eval->p7) == 1){
                    $factor_recomendacion_curso++;
                }

            }

            //Serie de pasos necesarios para obtener el promedio por curso
            $divisor = 1;
            if($tam2 == 0){
                $tam2 = 1;
            }else{
                $divisor = 2;
            }
            if($tam3 == 0){
                $tam3 = 1;
            }else{
                $divisor = 3;
            }

            $contenido_promedio += round($contenido_curso/($tam_curso*5),2);
            $coordinacion_promedio += round($coordinacion_curso/($tam_curso*4),2);
            $instructor_promedio += round((($instructor_1/($tam_curso*11))+($instructor_2/($tam2*11))+($instructor_3/($tam3*11)))/$divisor,2);
            $factor_recomendacion_promedio += round(($factor_recomendacion_curso*100)/$tam_curso,2);

        }

        //Serie de pasos necesarios para obtener el promedio de toda el área
        $factor_contenido_aritmetico = round($contenido_promedio / $tam_coordinacion,2);
        $factor_instructor_aritmetico = round($instructor_promedio / $tam_coordinacion,2);
        $factor_coordinacion_aritmetico = round($coordinacion_promedio / $tam_coordinacion,2);
        $factor_recomendacion_aritmetico = round($factor_recomendacion_promedio / $tam_coordinacion,2);

        $aritmetico = [$factor_contenido_aritmetico,$factor_instructor_aritmetico,$factor_coordinacion_aritmetico,$factor_recomendacion_aritmetico];
        return $aritmetico;

    }

    /**
     * Función encargada de retornar la vista donde el usuario va a elegir la fecha del historial
     * @param $message: mensaje de error al usuario (en caso de haberlo)
     * @return La vista con los datos necesarios para que el usuario elija la fecha
     */
    public function elegirFecha($message){
        //Obtenemos todos los cursos y todas las coordinaciones
        $coordinaciones = Coordinacion::all();
        $cursos = DB::table('cursos')
            ->get();
            
        //Buscamos Obtener las fechas de todos los cursos
        $fechas = array();
        foreach($cursos as $curso){
            $fecha = strval($curso->semestre_anio).'-'.strval($curso->semestre_pi);
            $inList = false;
            //Iteramos los cursos para buscar su fecha
            foreach($fechas as $fechaIn){
                //Si las fechas coinciden indicamos que no se debe de ingresar el curso al arreglo
                if(strcmp($fechaIn,$fecha)==0){
                    $inList = True;
                    break;
                }
            }
            //Si no hubieron coincidencias ingresamos la fecha del curso al arreglo las fechas en que se darán los cursos
            if($inList == false){
                array_push($fechas,$fecha);
            }
        }

        //return $coordinaciones;

        return view('pages.global_fecha')
            ->with('coordinaciones',$coordinaciones)
            ->with('fechas',$fechas)
            ->with('message',$message);
    }

    /**
     * Función que se encarga de retornar la vista donde el usario elije fecha y área
     * @param $message: mensaje de error (en caso de haberlo)
     * @return La vista donde el usuario elijirá coordinación y fecha de la que quiere el historial
     */
    public function elegirFechaCoordinacion($message){
        //Obtenemos todos los cursos y todas las coordinaciones
        $coordinaciones = Coordinacion::all();
        $cursos = DB::table('cursos')
            ->get();

        //Buscamos Obtener las fechas de todos los cursos
        $fechas = array();
        foreach($cursos as $curso){
            //Si las fechas coinciden indicamos que no se debe de ingresar el curso al arreglo
            $fecha = strval($curso->semestre_anio).'-'.strval($curso->semestre_pi);
            $inList = false;
            foreach($fechas as $fechaIn){
                if(strcmp($fechaIn,$fecha)==0){
                    $inList = True;
                    break;
                }
            }
            //Si no hubieron coincidencias ingresamos la fecha del curso al arreglo las fechas en que se darán los cursos
            if($inList == false){
                array_push($fechas,$fecha);
            }
        }
        return view('pages.global_coordinacion')
            ->with('coordinaciones',$coordinaciones)
            ->with('fechas',$fechas)
            ->with('message',$message);
    }

    /**
     * Función activadora de enviarVista donde se obtienen los cursos de la fecha y área elegida
     * @param $request: fecha y área elegidas por el usuario
     * @return Lo retornado por la función enviarVista
     */
    public function enviarCoordinacion(Request $request){

        //Obtenemos la fecha y la coordinacion seleccionadas por el usuario
        $semestre = $request->get('semestre');
        $fecha = explode('-',$semestre);
        $coordinacion = $request->get('coordinacion');
        $coordinaciones = DB::table('coordinacions')
            ->where('abreviatura',$coordinacion)
            ->get();

        //Buscamos los cursos de dicha coordinacion
        $catalogs = DB::table('catalogo_cursos')
            ->where('coordinacion_id',$coordinaciones[0]->id)
            ->get();

        //return $request->get('periodo');
        //Buscamos los cursos de dicha fecha
        $cursosFecha = DB::table('cursos')
            ->where([['semestre_anio',$fecha[0]],['semestre_pi',$fecha[1]],['semestre_si',$request->get('periodo')]])
            ->get();

        $cursos = array();
        
        //Buscamos los cursos que coinciden en fecha y coordinacion
        foreach($catalogs as $catalogo){
            foreach($cursosFecha as $curso){
                if($curso->catalogo_id == $catalogo->id){
                    array_push($cursos,$curso);
                    break;
                }
            }
        }

        //Pasamos el nombre de la coordinacion y la vista a retornar
        $nombreCoordinacion = $coordinaciones[0]->nombre_coordinacion;
        $lugar = "pages.reporte_final_area";

        return $this->enviarVista($semestre, $cursos, $nombreCoordinacion, $lugar,0,'elegir.coordinacion');
        
    }

    /**
     * Función activadora de la vista enviarVista que obtiene los datos globales de los cursos de cierta fecha
     * @param $fecha escogida por el usuario
     * @return Lo retornado por la función enviarVista
     */
    public function globalPDF($fecha){
        //Obtenemos la fecha seleccionada por el usuario
        $semestre = explode('-',$fecha);
        //Obtenemos los cursos de dicha fecha
        $cursos = DB::table('cursos')
            ->where([['cursos.semestre_anio',$semestre[0]],['cursos.semestre_pi',$semestre[1]]])
            ->get();
        //Procedemos a obtener todos los datos e indicamos que queremos pasarlo a pdf
        $lugar = "pages.reporte_final_global";

        return $this->enviarVista($fecha, $cursos, "", $lugar,1,'');
    }

    /**
     * Función activadora de la vista enviarVista que obtiene los datos globales de los cursos de cierta fecha y coordinación
     * @param $fecha escogida por el usuario, $coordinación: coordinación elegida por el usuario (id)
     * @return Lo retornado por la función enviarVista
     */
    public function areaPDF($fecha,$coordinacion){

        //Obtenemos la fecha ingresada por el usuario
        $semestre = $fecha;

        $fechaRec = explode('-',$semestre);

        //Obtenemos la coordinacion ingresada por el usuario
        $coordinacion = $coordinacion;
        $coordinaciones = DB::table('coordinacions')
            ->where('nombre_coordinacion',$coordinacion)
            ->get();

        //Obtenemos los cursos que corresponden a la coordinacion indicada
        $catalogs = DB::table('catalogo_cursos')
            ->where('coordinacion_id',$coordinaciones[0]->id)
            ->get();
        //Obtenemos los cursos que corresponden a la fecha indicada
        $cursosFecha = DB::table('cursos')
            ->where([['semestre_anio',$fechaRec[0]],['semestre_pi',$fechaRec[1]]])
            ->get();

        $cursos = array();
        
        //Buscamos los cursos que coinciden en fecha y coordinacion
        foreach($catalogs as $catalogo){
            foreach($cursosFecha as $curso){
                if($curso->catalogo_id == $catalogo->id){
                    array_push($cursos,$curso);
                    break;
                }
            }
        }

        //Procedemos a calcular los datos e indicamos que queremos descargar el pdf
        $nombreCoordinacion = $coordinaciones[0]->nombre_coordinacion;
        $lugar = "pages.reporte_final_area";

        return $this->enviarVista($semestre, $cursos, $nombreCoordinacion, $lugar,1,'');
    }


    /**
     * Función encargada de retornar la descarga del pdf de los reportes finales de área y global
     * @param Todos los datos necesarios para generar el reporte 
     * @return La descarga del pdf
     */
    public function descargarPDF($nombres,$periodo,$acreditaron,$inscritos,$contestaron,$factor_ocupacion,$factor_recomendacion,$factor_acreditacion,$positivas,$DP,$DH,$CO,$DI,$Otros,$DPtematicas,$DItematicas,$COtematicas,$DHtematicas,$Otrostematicas,$coordinaciones,$horarios,$coordinacion,$contenido,$profesors,$instructor,$asistencia,$nombreCoordinacion,$lugar,$factor_contenido_aritmetico,$factor_instructor_aritmetico,$factor_coordinacion_aritmetico,$factor_recomendacion_aritmetico){
        $coordinaciones = Coordinacion::all();

        $envio = 'pages.global';
        $envioPDF = 'global_'.$periodo;
        if(strcmp($lugar,'pages.reporte_final_area') == 0){
            $envio = 'pages.area';
            $envioPDF = 'area_'.$nombreCoordinacion.'_periodo';
        }
        //Obtenemos el pdf con los datos calculados
        $pdf = PDF::loadView($envio,array('nombres'=>$nombres,'periodo'=>$periodo,'acreditaron'=>$acreditaron,'inscritos'=>$inscritos,'contestaron'=>$contestaron,'factor_ocupacion'=>$factor_ocupacion,'factor_recomendacion'=>$factor_recomendacion,'factor_acreditacion'=>$factor_acreditacion,'positivas'=>$positivas,'DP'=>$DP,'DH'=>$DH,'CO'=>$CO,'DI'=>$DI,'Otros'=>$Otros,'DPtematicas'=>$DPtematicas,'DItematicas'=>$DItematicas,'COtematicas'=>$COtematicas,'DHtematicas'=>$DHtematicas,'Otrostematicas'=>$Otrostematicas,'coordinaciones'=>$coordinaciones,'horarios'=>$horarios,'coordinacion'=>$coordinacion,'contenido'=>$contenido,'profesors'=>$profesors,'instructor'=>$instructor,'asistencia'=>$asistencia,'nombreCoordinacion'=>$nombreCoordinacion,'aritmetico_contenido'=>$factor_contenido_aritmetico,'aritmetico_instructor'=>$factor_instructor_aritmetico,'aritmetico_coordinacion'=>$factor_coordinacion_aritmetico,'aritmetico_recomendacion'=>$factor_recomendacion_aritmetico));	

        //Retornamos la descarga del pdf
        return $pdf->download($envioPDF.'.pdf');
    }

    /**
     * Función encargada de obtener el reporte final de un curso
     * @param $curso: curso elegido por el uduario, $pdf: si se quiere o no un pdf, $encargado_id: coordinación
     * @return Vista o descarga del reporte según lo elegido por el usuario
     */
    public function globalFinal($curso_id,$pdf,$encargado_id){

        $coordinaciones = Coordinacion::all();

		$correo = new EvaluacionController(); 
		$evals = 0;

        $catalogoCurso_id = DB::table('cursos')
            ->where('id',$curso_id)
            ->get('catalogo_id');

        $catalogoCurso = DB::table('catalogo_cursos')
            ->where('id',$catalogoCurso_id[0]->catalogo_id)
            ->get('tipo');

		//Checamos si el usuario desea los reportes de los cursos o de los seminarios
		if(strcmp($catalogoCurso[0]->tipo,'S')==0){
            $evals = DB::table('_evaluacion_final_seminario')
			    ->where("curso_id",$curso_id)
                ->get();

		}else{
			$evals = DB::table('_evaluacion_final_curso')
			    ->where("curso_id",$curso_id)
                ->get();
        }

        if(sizeof($evals) == 0){
            return redirect()->route('cursos.coordinacion',[$encargado_id,'Cursos no han sido calificado']);
        }

        $contestaron = sizeof($evals);

		//Obtenemos el id de los instructores de los cursos
		$instructores = DB::table('profesor_curso')
			->where('curso_id',$curso_id)
			->get();

		//Obtenemos los datos de los instructores de cada curso
		$nombreInstructor = array();
		foreach($instructores as $instructorCurso){
			$instructor = DB::table('profesors')
				->where('id',$instructorCurso->profesor_id)
				->get();
			array_push($nombreInstructor,$instructor[0]);
		}

		//Obtenemos el cupo maximo del curso en cuestion
		$curso_ocupacion = DB::table("cursos")
			->where("id",$curso_id)
			->value("cupo_maximo");

		//Obtenemos los participantes del curso
		$participantes = DB::table('participante_curso')
			->where('curso_id',$curso_id)
			->get();

		//Obtenemos el curso?
		$curso = DB::table('cursos')
			->where('id',$curso_id)
			->get();

		//Obtenemos los datos del curso
		$catalogo_curso = DB::table('catalogo_cursos')
			->where('id',$curso[0]->catalogo_id)
			->get();

		//Obtenemos el salon donde se imparte el curso
		$salon = DB::table('salons')
			->where('id',$curso[0]->salon_id)
			->get();

		//Obtenemos el factor de recomendación y de asistencia
		$recomendaciones = 0;
        $factor = 0;
		$alumnos = 0;

        foreach($evals as $array){
			//Si la pregunta 7 vale uno es curso es recomendado
            if($array->p7 == 1){
                $recomendaciones = $recomendaciones + 1;
                $alumnos = $alumnos + 1;
            }else if($array->p7 == 0){
                $alumnos = $alumnos + 1;
            }
		}
		
		//Obtenemos el factor de recomendacion
        if($alumnos == 0){
            $factor = round(($recomendaciones * 100) / 1,2);
        }else
        {
            $factor = round(($recomendaciones * 100) / $alumnos,2);
		}

		//Obtenemos el factor de acreditación y la asistencia
		$acreditado = 0;
		$factor_acreditacion = 0;
		$alumnos = 0;
		$asistieron = 0;
		foreach($participantes as $participante){
			$alumnos = $alumnos + 1;
			if($participante->acreditacion == 1){
				$acreditado = $acreditado + 1;
			}
			if($participante->asistencia == 1){
				$asistieron++;
			}
		}

		//Obtenemos el factor de acreditacion 
		if($alumnos == 0){
			$factor_acreditacion = round(($acreditado * 100) / 1,2);
		}else
		{
			$factor_acreditacion = round(($acreditado * 100) / $alumnos,2);
		}

		//Obtenemos el factor de ocupacion
		$ocupacion = ($alumnos*100)/$curso_ocupacion;

		//Obtenemos la cantidad de integrantes de cada area
		$DP=0;
        $DH=0;
        $CO=0;
        $DI=0;
        $Otros=0;
        foreach($evals as $evaluacion){
            $array = explode(',',$evaluacion->conocimiento);
            foreach($array as $elem){
                if($elem[2] == 1 || $elem[1] == 1){
					//Aumentamos numero integrante Division Pedagogia
					$DP++;
                }else if($elem[2] == 2 || $elem[1] == 2){
					//Aumentamos numero integrantes division desarrollo humano
                    $DH++;
                }else if($elem[2] == 3 || $elem[1] == 3){
					//Aumentamos numero integrante Division de computo
                    $CO++;
                }else if($elem[2] == 4 || $elem[1] == 4){
					//Aumentamos numero integrante Division de disciplina
                    $DI++;
                }else if($elem[2] == 5 || $elem[1] == 5){
					//Aumentamos numero integrante externo
                    $Otros++;
                }
            }
		}
		
		$preguntas = 0;
		$positivas = 0;
		$respuestasContenido = 0;
		$respuestasCoordinacion = 0;
		$respuestasInstructores1 = 0;
		$respuestasInstructores2 = 0;
		$respuestasInstructores3 = 0;
		$alumnos = 0;
		$alumnos_eval_instructor1 = 0;
		$alumnos_eval_instructor2 = 0;
		$alumnos_eval_instructor3 = 0;
		$promedios1 = array();
		$promedios2 = array();
		$promedios3 = array();
		$respuesta_individual1 = 0;
		$respuesta_individual2 = 0;
		$respuesta_individual3 = 0;

		//Bucle necesario para obtener el numero de preguntas positivas, evaluaciones de cada uno de los instructores y los factores de calidad de contenido, de calidad de la coordinacion, y los factores de calidad de los instructores
		foreach($evals as $evaluacion){
			//Aumentamos el numero de alumnos que respondieron el cuestionario
			$alumnos++;
			//Desde 1_1 a 1_5 obtenemos el factor de calidad del contenido ($respuestasContenido/$alumnos*5) valor >= 60
			if($evaluacion->p1_1 >= 20){
				$preguntas++;
				$respuestasContenido += $evaluacion->p1_1;
				if($evaluacion->p1_1 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p1_2 >= 20){
				$preguntas++;
				$respuestasContenido+= $evaluacion->p1_2;
				if($evaluacion->p1_2 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p1_3 >= 20){
				$preguntas++;
				$respuestasContenido+= $evaluacion->p1_3;
				if($evaluacion->p1_3 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p1_4 >= 20){
				$preguntas++;
				$respuestasContenido+= $evaluacion->p1_4;
				if($evaluacion->p1_4 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p1_5 >= 20){
				$preguntas++;
				$respuestasContenido+= $evaluacion->p1_5;
				if($evaluacion->p1_5 > 60){
					$positivas++;
				}
			}

			if($evaluacion->p2_1 >= 20){
				$preguntas++;
				if($evaluacion->p2_1 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p2_2 >= 20){
				$preguntas++;
				if($evaluacion->p2_2 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p2_3 >= 20){
				$preguntas++;
				if($evaluacion->p2_3 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p2_4 >= 20){
				$preguntas++;
				if($evaluacion->p2_4 > 60){
					$positivas++;
				}
			}

			//Desde 1_1 a 1_5 obtenemos el factor de calidad de la coordinacion ($respuestasCoordinacion/$alumnos*4)
			if($evaluacion->p3_1 >= 20){
				$preguntas++;
				$respuestasCoordinacion += $evaluacion->p3_1;
				if($evaluacion->p3_1 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p3_2 >= 20){
				$preguntas++;
				$respuestasCoordinacion += $evaluacion->p3_2;
				if($evaluacion->p3_2 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p3_3 >= 20){
				$preguntas++;
				$respuestasCoordinacion += $evaluacion->p3_3;
				if($evaluacion->p3_3 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p3_4 >= 20){
				$preguntas++;
				$respuestasCoordinacion += $evaluacion->p3_4;
				if($evaluacion->p3_4 > 60){
					$positivas++;
				}
			}

			//Las preguntas correspondientes al primer instructor
			if($evaluacion->p4_1 >= 20){
				$alumnos_eval_instructor1++;
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_1;
				$respuesta_individual1+= $evaluacion->p4_1;
				if($evaluacion->p4_1 == 1){
					$positivas++;
				}
			}
			if($evaluacion->p4_2 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_2;
				$respuesta_individual1+= $evaluacion->p4_2;
				if($evaluacion->p4_2 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_3 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_3;
				$respuesta_individual1+= $evaluacion->p4_3;
				if($evaluacion->p4_3 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_4 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_4;
				$respuesta_individual1+= $evaluacion->p4_4;
				if($evaluacion->p4_4 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_5 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_5;
				$respuesta_individual1+= $evaluacion->p4_5;
				if($evaluacion->p4_5 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_6 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_6;
				$respuesta_individual1+= $evaluacion->p4_6;
				if($evaluacion->p4_6 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_7 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_7;
				$respuesta_individual1+= $evaluacion->p4_7;
				if($evaluacion->p4_7 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_8 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_8;
				$respuesta_individual1+= $evaluacion->p4_8;
				if($evaluacion->p4_8 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_9 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_9;
				$respuesta_individual1+= $evaluacion->p4_9;
				if($evaluacion->p4_9 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p4_10 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_10;
				$respuesta_individual1+= $evaluacion->p4_10;
				if($evaluacion->p4_10 > 60){
					$positivas++;
				}
			}
			//Queremos obtener todas las evaluaciones para luego comparar promedio, minimo y maximo del instructor
			if($evaluacion->p4_11 >= 20){
				$preguntas++;
				$respuestasInstructores1+= $evaluacion->p4_11;
				$respuesta_individual1+= $evaluacion->p4_11;
				array_push($promedios1, round($respuesta_individual1/11,2));
				$respuesta_individual1 = 0;
				if($evaluacion->p4_11 > 60){
					$positivas++;
				}
			}

			//Las preguntas correspondientes al segundo instructor
			if($evaluacion->p5_1 >= 20){
				$alumnos_eval_instructor2++;
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_1;
				$respuesta_individual2+= $evaluacion->p5_1;
				if($evaluacion->p5_1 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_2 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_2;
				$respuesta_individual2+= $evaluacion->p5_2;
				if($evaluacion->p5_2 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_3 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_3;
				$respuesta_individual2+= $evaluacion->p5_3;
				if($evaluacion->p5_3 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_4 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_4;
				$respuesta_individual2+= $evaluacion->p5_4;
				if($evaluacion->p5_4 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_5 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_5;
				$respuesta_individual2+= $evaluacion->p5_5;
				if($evaluacion->p5_5 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_6 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_6;
				$respuesta_individual2+= $evaluacion->p5_6;
				if($evaluacion->p5_6 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_7 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_7;
				$respuesta_individual2+= $evaluacion->p5_7;
				if($evaluacion->p5_7 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_8 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_8;
				$respuesta_individual2+= $evaluacion->p5_8;
				if($evaluacion->p5_8 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_9 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_9;
				$respuesta_individual2+= $evaluacion->p5_9;
				if($evaluacion->p5_9 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p5_10 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_10;
				$respuesta_individual2+= $evaluacion->p5_10;
				if($evaluacion->p5_10 > 60){
					$positivas++;
				}
			}
			//Queremos obtener todas las evaluaciones para luego comparar promedio, minimo y maximo del instructor
			if($evaluacion->p5_11 >= 20){
				$preguntas++;
				$respuestasInstructores2+= $evaluacion->p5_11;
				$respuesta_individual2+= $evaluacion->p5_11;
				array_push($promedios2, round($respuesta_individual2/11,2));
				$respuesta_individual2 = 0;
				if($evaluacion->p5_11 > 60){
					$positivas++;
				}
			}
			
			//Las preguntas correspondientes al tercer instructor
			if($evaluacion->p6_1 >= 20){
				$alumnos_eval_instructor3++;
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_1;
				$respuesta_individual3+= $evaluacion->p6_1;
				if($evaluacion->p6_1 == 1){
					$positivas++;
				}
			}
			if($evaluacion->p6_2 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_2;
				$respuesta_individual3+= $evaluacion->p6_2;
				if($evaluacion->p6_2 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_3 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_3;
				$respuesta_individual3+= $evaluacion->p6_3;
				if($evaluacion->p6_3 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_4 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_4;
				$respuesta_individual3+= $evaluacion->p6_4;
				if($evaluacion->p6_4 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_5 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_5;
				$respuesta_individual3+= $evaluacion->p6_5;
				if($evaluacion->p6_5 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_6 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_6;
				$respuesta_individual3+= $evaluacion->p6_6;
				if($evaluacion->p6_6 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_7 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_7;
				$respuesta_individual3+= $evaluacion->p6_7;
				if($evaluacion->p6_7 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_8 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_8;
				$respuesta_individual3+= $evaluacion->p6_8;
				if($evaluacion->p6_8 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_9 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_9;
				$respuesta_individual3+= $evaluacion->p6_9;
				if($evaluacion->p6_9 > 60){
					$positivas++;
				}
			}
			if($evaluacion->p6_10 >= 20){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_10;
				$respuesta_individual3+= $evaluacion->p6_10;
				if($evaluacion->p6_10 > 60){
					$positivas++;
				}
			}

			//Queremos obtener todas las evaluaciones para luego comparar promedio, minimo y maximo del instructor
			if($evaluacion->p6_11 >= 50){
				$preguntas++;
				$respuestasInstructores3+= $evaluacion->p6_11;
				$respuesta_individual3+= $evaluacion->p6_11;
				array_push($promedios3, round($respuesta_individual3/11,2));
				$respuesta_individual3 = 0;
				if($evaluacion->p6_11 > 60){
					$positivas++;
				}
			}

		}

		//Obtenemos la evaluacion minima y maxima del primer instructor
		$minimo1 = 0;
		$maximo1 = 0;

		foreach($promedios1 as $promedio){
			if($minimo1 == 0){
				$minimo1 = $promedio;
			}
			if($promedio < $minimo1){
				$minimo1 = $promedio;
			}
			if($promedio > $maximo1){
				$maximo1 = $promedio;
			}
		}

		//Obtenemos la evaluacion minima y maxima del segundo instructor
		$minimo2 = 0;
		$maximo2 = 0;

		foreach($promedios2 as $promedio){
			if($minimo2 == 0){
				$minimo2 = $promedio;
			}
			if($promedio < $minimo2){
				$minimo2 = $promedio;
			}
			if($promedio > $maximo2){
				$maximo2 = $promedio;
			}
		}

		//Obtenemos la evaluacion minima y maxima del tercer instructor
		$minimo3 = 0;
		$maximo3 = 0;

		foreach($promedios3 as $promedio){
			if($minimo3 == 0){
				$minimo3 = $promedio;
			}
			if($promedio < $minimo3){
				$minimo3 = $promedio;
			}
			if($promedio > $maximo3){
				$maximo3 = $promedio;
			}
		}

		//Checamos el numero de instructores del curso para ver a cual de los view enviar
        $envio = 0;
        $envioPDF = 0;
        $nombre = 0;

        if($minimo3 != 0){
            $envio = 'pages.reporte_final_curso3';
            $envioPDF = 'pages.validacion_3';
        }else if($minimo2 != 0){
            $envio = 'pages.reporte_final_curso2';
            $envioPDF = 'pages.validacion_2';
        }else{
            $envio = 'pages.reporte_final_curso1';
            $envioPDF = 'pages.validacion_1';
        }

		if(strcmp($catalogoCurso[0]->tipo,'S')==0){
            $nombre = 'SEMINARIO';
			if($minimo3 != 0){
                //$envio = 'pages.reporte_final_seminario_instructores_3';
                $envioPDF = 'pages.validacion_seminario_3';
			}else if($minimo2 != 0){
                //$envio = 'pages.reporte_final_seminario_instructores_2';
                $envioPDF = 'pages.validacion_seminario_2';
			}else{
                //$envio = 'pages.reporte_final_seminario_instructores_1';
                $envioPDF = 'pages.validacion_seminario_1';
			}
		}else{
            $nombre = 'CURSO';
			if($minimo3 != 0){
                //$envio = 'pages.reporte_final_curso3';
                $envioPDF = 'pages.validacion_3';
			}else if($minimo2 != 0){
                //$envio = 'pages.reporte_final_curso2';
                $envioPDF = 'pages.validacion_2';
			}else{
                //$envio = 'pages.reporte_final_curso1';
                $envioPDF = 'pages.validacion_1';
			}
		}

		//En caso de no haber alumnos ni preguntas (se pide el resumen de un curso no evaluado anteriormente) pasamos su valor a 1 para evitar division by zero exception
		if($alumnos == 0){
			$alumnos = 1;
		}
		
		if($preguntas == 0){
			$preguntas = 1;
		}

		$factor_instructor1 = 0;

		//Si hay un instructor obtenemos su factor
		if($alumnos_eval_instructor1 != 0){
			$factor_instructor1 = round($respuestasInstructores1 / ($alumnos_eval_instructor1*11),2);
		}

		$factor_instructor2 = 0;

		//Si hay dos instructores obtenemos su factor
		if($alumnos_eval_instructor2 != 0){
			$factor_instructor2 = round($respuestasInstructores2 / ($alumnos_eval_instructor2*11),2);
		}

		$factor_instructor3 = 0;

		//Si hay tres instructores obtenemos su factor
		if($alumnos_eval_instructor3 != 0){
			$factor_instructor3 = round($respuestasInstructores3 / ($alumnos_eval_instructor3*11),2);
		}

		//Obtenemos los factores de respuestas positivas, contenido y coordinacion
		$factor_respuestas_positivas = round($positivas*100 / $preguntas, 2);
		$factor_contenido = round($respuestasContenido / ($alumnos*5),2);
		$factor_coordinacion = round($respuestasCoordinacion / ($alumnos*4),2);

		//Obtenemos el numero de horas a partir del numero de sesiones y las horas de cada sesion
		$horas_inicio = explode(':',$curso[0]->hora_inicio);
		$horas_fin = explode(':',$curso[0]->hora_fin);

		$inicio = intval($horas_inicio[0]) + floatval($horas_inicio[1]/100);
		$fin = intval($horas_fin[0]) + floatval($horas_fin[1]/100);

		$numero_horas = floatval($curso[0]->numero_sesiones) * ($fin-$inicio);

        $catalogo_curso = DB::table('catalogo_cursos')
            ->where('id',$curso[0]->catalogo_id)
            ->get();

        if($pdf == 1){
            $nombre = $nombre.'_'.$catalogo_curso[0]->nombre_curso.'_'.$curso[0]->semestre_anio.'_'.$curso[0]->semestre_pi.'_'.$curso[0]->semestre_si.'.pdf';
            $pdf = PDF::loadView($envioPDF,array('evals'=>$evals,'curso_id'=>$curso_id,'catalogoCurso_id'=>$catalogoCurso_id,'participantes'=>$participantes,'factor_acreditacion'=>$factor_acreditacion,'factor'=>$factor,'alumnos'=>$alumnos,'DP'=>$DP,'DH'=>$DH,'CO'=>$CO,'DI'=>$DI,'Otros'=>$Otros,'ocupacion'=>$ocupacion,'positivas'=>$factor_respuestas_positivas,'contenido'=>$factor_contenido,'factor_coordinacion'=>$factor_coordinacion,'curso'=>$curso[0],'salon'=>$salon[0],'acreditaron'=>$acreditado,'coordinaciones'=>array(),'instructor'=>$factor_instructor1,'minimo'=>$minimo1,'maximo'=>$maximo1,'instructor2'=>$factor_instructor2,'minimo2'=>$minimo2,'maximo2'=>$maximo2,'instructor3'=>$factor_instructor3,'minimo3'=>$minimo3,'maximo3'=>$maximo3,'numero_horas'=>$numero_horas,'asistieron'=>$asistieron,'nombreInstructor'=>$nombreInstructor,'coordinaciones'=>$coordinaciones,'catalogo'=>$catalogo_curso[0],'contestaron'=>$contestaron));	
            return $pdf->download($nombre);
        }

        return view($envio)
            ->with('evals',$evals)
            ->with('curso_id',$curso_id)
            ->with('catalogoCurso_id',$catalogoCurso_id)
            ->with('participantes',$participantes)
            ->with('factor_acreditacion',$factor_acreditacion)
            ->with('factor',$factor)
            ->with('alumnos',$alumnos)
            ->with('DP',$DP)
            ->with('DH',$DH)
            ->with('CO',$CO)
            ->with('DI',$DI)
            ->with('Otros',$Otros)
            ->with('ocupacion',$ocupacion)
            ->with('positivas',$factor_respuestas_positivas)
            ->with('contenido',$factor_contenido)
            ->with('factor_coordinacion',$factor_coordinacion)
            ->with('curso',$curso[0])
            ->with('salon',$salon[0])
            ->with('acreditaron',$acreditado)
            ->with('coordinaciones',array())
            ->with('instructor',$factor_instructor1)
            ->with('minimo',$minimo1)
            ->with('maximo',$maximo1)
            ->with('instructor2',$factor_instructor2)
            ->with('minimo2',$minimo2)
            ->with('maximo2',$maximo2)
            ->with('instructor3',$factor_instructor3)
            ->with('minimo3',$minimo3)
            ->with('maximo3',$maximo3)
            ->with('numero_horas',$numero_horas)
            ->with('asistieron',$asistieron)
            ->with('nombreInstructor',$nombreInstructor)
            ->with('coordinaciones',$coordinaciones)
            ->with('encargado_id',$encargado_id)
            ->with('contestaron',$contestaron)
            ->with('catalogo',$catalogo_curso)
            ->with('nombre',$nombre);
		

    }
    
    /**
     * Función encargada de obtener el reporte de sesion de un curso
     * @param $curso: curso elegido por el uduario, $pdf: si se quiere o no un pdf, $encargado_id: coordinación
     * @return Vista o descarga del reporte según lo elegido por el usuario
     */
    public function globalSesion($curso_id,$pdf,$encargado_id){

        $curso = DB::table('cursos')
            ->where('id',$curso_id)
            ->get();

        $catalogo_curso = DB::table('catalogo_cursos')
            ->where('id',$curso[0]->catalogo_id)
            ->get();

        $coordinaciones = Coordinacion::all();   
        $enviopdf = 0;
        $final = 0;
        $evaluaciones = 0;
        

        if(strcmp($catalogo_curso[0]->tipo,'S')==0){
            $evaluaciones = DB::table('_evaluacion_x_seminario')
                ->where('curso_id',$curso_id)
                ->get();
            $lugar = "pages.resumen_x_session_seminario";
            $enviopdf = "pages.resumen_x_sesion_seminario_pdf";
            $final = 'seminario';
        }else{
            $evaluaciones = DB::table('_evaluacion_x_curso')
                ->where('curso_id',$curso_id)
                ->get();
                $lugar = "pages.resumen_x_sesion_curso";
                $enviopdf = "pages.resumen_x_sesion_pdf";
                $final = 'curso';
        }
        
        if(sizeof($evaluaciones)==0){
            return redirect()->route('cursos.coordinacion',[$encargado_id,'Curso no ha sido evaluado']);
        }
        
        $profesors = array();
        $Datos = array();

        foreach($evaluaciones as $eval){
            $participante = DB::table('participante_curso')
                ->where('id',$eval->participante_curso_id)
                ->get();

            $profesor = DB::table('profesors')
                ->where('id',$participante[0]->profesor_id)
                ->get();
            $tupla = [$profesor[0],$eval];
            array_push($Datos,$tupla);
        }

        $curso = Curso::find($curso_id);

        if($pdf == 1 && $enviopdf != '0'){
            $pdf = PDF::loadView($enviopdf,array('evaluaciones'=>$Datos,'curso_id'=>$curso_id,'coordinaciones'=>$coordinaciones,'catalogoCurso'=>$catalogo_curso[0],'curso'=>$curso));	
            $nombre = $catalogo_curso[0]->nombre_curso.'_'.$curso->semestre_anio.'_'.$curso->semestre_pi.'_'.$curso->semestre_si.'_sesion_'.$final.'pdf';
            return $pdf->download($nombre.'.pdf');
        }

        return view($lugar)
            ->with('evaluaciones',$Datos)
            ->with('curso_id',$curso_id)
            ->with('coordinaciones',$coordinaciones)
            ->with('catalogoCurso',$catalogo_curso[0])
            ->with('curso',$curso)
            ->with('encargado_id',$encargado_id);

    }

}


