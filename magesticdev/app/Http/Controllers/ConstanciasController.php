<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use PDF;
use App\Curso;
use App\CatalogoCurso;
use App\ProfesoresCurso;
use App\ParticipantesCurso;
use App\Profesor;
use App\Director;
use App\CoordinadorGeneral;
use App\SecretarioApoyo ;
use App\Coordinacion;
use Carbon\Carbon;
use Zipper;
use Laracasts\Flash\Flash;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use File;
use PdfMerger;
use PdfManage;


function rrmdir($dir) { 
    if (is_dir($dir)) { 
        $objects = scandir($dir);
        foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
                if (is_dir($dir. "/" .$object) && !is_link($dir."/".$object))
                    rrmdir($dir. "/" .$object);
                else
                    unlink($dir. "/" .$object); 
            }
        }
        rmdir($dir); 
    }
}

class ConstanciasController extends Controller{
  public function fechaEnvio($id)
  {
      $curso = Curso::findOrFail($id);
      return view("pages.constancias-fechaEnvio")
              ->with('curso',$curso);
  }
  
  public function fechaEnvioActualizar(Request $request, $id)
  {
      $curso = Curso::findOrFail($id);
      $curso->fecha_envio_constancia = $request->envio;
      $curso->save();
      return redirect('constancias/'.$id)
              ->with('curso', $curso)
              ->with('success', 'Fecha actualizada correctamente');
  }

  public function selectType($id)
    {
        $curso = Curso::findOrFail($id);
        $tmp = ProfesoresCurso::where('curso_id', $id)->get();
        $cuenta = $tmp->count();
        $folio_inst = "123";
        $folio_peque = "123";

        return view("pages.constancias-elegirTipoConstancia")
                ->with('curso',$curso)
                ->with('count_profesores', $cuenta);
    }

    public function selectType3()
    {
        $cursosCatalogo = CatalogoCurso::all();
        $cursos = Curso::all();
        return view("pages.reconocimientos-elegirTipoReconocimiento")
                ->with('cursosCatalogo',$cursosCatalogo)
                ->with('cursos',$cursos);
    }

    public function convertirACadena($iter){
        if($iter>999){
            return (string)$iter;
        }elseif($iter>99){
            return "0".(string)$iter;
        }elseif($iter>9){
            return "00".(string)$iter;
        }else{
            return "000".(string)$iter;
        }
    }

    public function generar($id, Request $request){
        $pdfMerger = new PdfManage;
        $tipoDeConstancia = $request->type;
        if ($tipoDeConstancia === "H")
          $generacion = $request->generacion;
        else
          $generacion = null;
        $esUnica = false;
        $folio_der = (strlen($request->numero) != 0 and is_numeric($request->numero)) ? intval($request->numero) : -1;
        $zip = new Zipper();
        $zip::make(public_path('constancias.zip'));
        $count = ProfesoresCurso::select('id')
        ->where('curso_id',$id)
        ->count();
        try{
            $hash_aux = str_replace(".", "0",substr(Hash::make(url()->full(), [
                                        'rounds' => 4,
                                    ]),-4));
        }catch(\ErrorException  $e){
            return redirect()->back()->with('danger', 'Problemas con la url');
        }
         //Obtención de personal académico
        try{
            $coordinadorGeneral = CoordinadorGeneral::all();
            $coordinadorGeneral = $coordinadorGeneral[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with(
                'info',
                'Primero hay que dar de alta al Coordinador General'
            );
        }
        try{
            $secretarioApoyo = SecretarioApoyo::all();
            $secretarioApoyo = $secretarioApoyo[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with(
                'info', 
                'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
            );
        }
        try{
            $director = Director::all();
            $director = $director[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with(
                'info',
                'Primero hay que dar de alta al Director'
            );
        }
        //Obtención de datos del curso
        $curso = Curso::findOrFail($id);
        $idTipo = (strlen($request->typeid) != 0 and is_numeric($request->typeid)) ? intval($request->typeid) : $curso->getTypeId();
        if($idTipo>99){
            $idTipo = (string)$idTipo;
        }elseif($idTipo>9){
            $idTipo="0".(string)$idTipo;
        }else{
            $idTipo="00".(string)$idTipo;
        }
        $cursoCatalogo = CatalogoCurso::find($curso->catalogo_id);
        $coordinacion = Coordinacion::find($cursoCatalogo->coordinacion_id);
        $tipo = $cursoCatalogo->tipo;
        if($tipo == 'CT'){$tipo = 'T';}
        $institucion = $cursoCatalogo->institucion;
        //Obtención de Profesores
        $profesoresCurso = ProfesoresCurso::where('curso_id',$id)->get();
        $profesores = array();
        foreach($profesoresCurso as $profesorCurso){
            $tmp = Profesor::find($profesorCurso->profesor_id);
            array_push($profesores,$tmp);
        }
        //Obtención de participantes ordenados y acreditados
        $acreditacion = $curso->acreditacion;
        // if($institucion == 'DGAPA'){
        //     $acreditacion = '6';
        // }
        // else if($institucion == 'CDD'){
        //     $acreditacion = '8';
        // }
        $participantes = Profesor::leftJoin(
            'participante_curso',
            'profesors.id','=','participante_curso.profesor_id'
        )
        ->where('participante_curso.curso_id',$id)
        ->where('participante_curso.calificacion','>=',$acreditacion)
        ->where('participante_curso.asistencia', TRUE)
        ->where('participante_curso.acreditacion', TRUE)
        ->select('profesors.*')->get();
        if(count($participantes) <= 0){
            return redirect()->back()->with(
                'warning',
                'No hay alumnos que ameriten constancia'
            );
        }
        if($count == null){
            $zip::close();
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with(
                'warning', 'No hay profesores asignados para dicho curso'
            );
        }
        $participantes = $participantes->sortBy(function($user){
                return $user->apellido_paterno;
        });
        $tmp = array();
        foreach($participantes as $participante){
            $tmp2 = ParticipantesCurso::where(
                'participante_curso.profesor_id',$participante->id
            )
            ->where('participante_curso.curso_id',$id)->get();
            array_push($tmp,$tmp2[0]);
        }
        $participantes = $tmp;
        //Obtención de fechas
        $fechaimp = $curso->getFecha();
        $fecha = Carbon::parse($curso->getFechaFin());
        $fecha = $fecha->format('d/m/Y');
        $fecha = explode("/",$fecha);
        $anio = $fecha[2];
        $dia_a = $fecha[0];
        $mes_a = $fecha[1];
        if ($mes_a == '01'){
            $mes_a = 'enero';
        } elseif ($mes_a == '02') {
            $mes_a = 'febrero';
        } elseif ($mes_a == '03') {
            $mes_a = 'marzo';
        } elseif ($mes_a == '04') {
            $mes_a = 'abril';
        } elseif ($mes_a == '05') {
            $mes_a = 'mayo';
        } elseif ($mes_a == '06') {
            $mes_a = 'junio';
        } elseif ($mes_a == '07') {
            $mes_a = 'julio';
        } elseif ($mes_a == '08') {
            $mes_a = 'agosto';
        } elseif ($mes_a == '09') {
            $mes_a = 'septiembre';
        } elseif ($mes_a == '10') {
            $mes_a = 'octubre';
        } elseif ($mes_a == '11') {
            $mes_a = 'noviembre';
        } elseif ($mes_a == '12') {
            $mes_a = 'diciembre';
        }
        $fecha = $dia_a . " de " .$mes_a . " de " . $anio;
        $folio = "F04".$anio.$tipo;
        //$texto = "por acreditar el ".$curso->getTipoCadena();
				if($request->texto1 == "D"){
					$texto = $request->texto_per;
				}else{
					$texto = $request->texto1." ".$curso->getTipoCadena();
				}
        try{
            try{
                File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
            }catch(\ErrorException  $e){
                return redirect()->back()->with(
                    'warning', 'Problemas con el directorio "tmp"'
                );    
            }

            //BUSCAMOS AL PRIMER FIRMANTE
            // El tipo de constancia tiene al coordinador como mayor cargo
            if ($tipoDeConstancia == "A" or $tipoDeConstancia == "AA"){
                $firmante1 = $coordinacion->grado." ".$coordinacion->coordinador;
                if($coordinacion->genero === 'F')
                  $descripcion1 = "Coordinadora de ".$coordinacion->nombre_coordinacion;
                else
                  $descripcion1 = "Coordinador de ".$coordinacion->nombre_coordinacion;
                $formatoConstancia = 1;
            //El tipo de constancia necesita al coordinador general como mayor cargo
            }elseif ($tipoDeConstancia == "B" or $tipoDeConstancia == "D" 
                or $tipoDeConstancia == "I" or $tipoDeConstancia == "H"){
                $firmante1 = $coordinadorGeneral->grado." ".$coordinadorGeneral->coordinador;
                if($coordinadorGeneral->genero === 'F')
                  $descripcion1 = "Coordinadora del Centro de Docencia";
                else
                  $descripcion1 = "Coordinador del Centro de Docencia";
                $formatoConstancia = 1;
            //El tipo de constancia necesita al director como mayor cargo
            }elseif ($tipoDeConstancia == "E" OR $tipoDeConstancia == "G"){
                $firmante1 = $director->grado." ".$director->director;
                if($director->genero === 'F')
                  $descripcion1 = "Directora de la Facultad de Ingeniería";
                else
                  $descripcion1 = "Director de la Facultad de Ingeniería";
                $formatoConstancia = 1;
            //El tipo de constancia necesita al SAD como mayor cargo
            }elseif ($tipoDeConstancia == "C" or $tipoDeConstancia == "F"){
                $firmante1 = $secretarioApoyo->grado." ".$secretarioApoyo->secretario;
                if($secretarioApoyo->genero === 'F')
                  $descripcion1 = "Secretaria de Apoyo a la Docencia";
                else
                  $descripcion1 = "Secretario de Apoyo a la Docencia";
                $formatoConstancia = 1;
            }
            //BUSCAMOS AL SEGUNDO FIRMANTE
            if($tipoDeConstancia == "I"){
                $firmante2 = $coordinacion->grado." ".$coordinacion->coordinador;
                if($coordinacion->genero === 'F')
                  $descripcion2 = "Coordinadora de ".$coordinacion->nombre_coordinacion;
                else
                  $descripcion2 = "Coordinador de ".$coordinacion->nombre_coordinacion;
                $formatoConstancia = 2;
            }elseif($tipoDeConstancia == "G"){
                $firmante2 = $secretarioApoyo->grado." ".$secretarioApoyo->secretario;
                if($secretarioApoyo->genero === 'F')
                  $descripcion2 = "Secretaria de Apoyo a la Docencia";
                else
                  $descripcion2 = "Secretario de Apoyo a la Docencia";
                $formatoConstancia = 2;
            }elseif($tipoDeConstancia == "F"){
								$firmante2 = $coordinadorGeneral->grado." ".$coordinadorGeneral->coordinador;
								if($coordinadorGeneral->genero === 'F')
                  $descripcion2 = "Coordinadora del Centro de Docencia";
                else
                  $descripcion2 = "Coordinador del Centro de Docencia";
								$formatoConstancia = 2;
						}
            //BUSCAMOS A LOS INSTRUCTORES
            if ($tipoDeConstancia == "A" or $tipoDeConstancia == "B" 
                or $tipoDeConstancia == "C" or $tipoDeConstancia == "H"){
                if($count > 4){
                  return redirect()->back()->with('danger', 'El formato no puede ser de más de cinco firmantes');
                }
                if($count >= 1){
                //La constancia es para cuando sólo hay un instructor
                  $firmante2 = $profesores[0]->getFirmanteConstancia();
                  $descripcion2 = $profesores[0]->getDescripcionConstancia();
                  $formatoConstancia = 2;
                }if($count >= 2){
                //La constancia es para cuando hay dos instructores
                  $firmante3 = $profesores[1]->getFirmanteConstancia();
                  $descripcion3 = $profesores[1]->getDescripcionConstancia();
                  $formatoConstancia = 3;
                }if($count >= 3){
                //La constancia es para cuando hay tres instructores
                  $firmante4 = $profesores[2]->getFirmanteConstancia();
                  $descripcion4 = $profesores[2]->getDescripcionConstancia();
                  $formatoConstancia = 4;
                }if($count >= 4){
                //La constancia es para cuando hay cuatro instructores
                  $firmante5 = $profesores[3]->getFirmanteConstancia();
                  $descripcion5 = $profesores[3]->getDescripcionConstancia();
                  $formatoConstancia = 5;
                }
            //SE ELIGIÓ LA OPCIÓN MANUAL
            }if ($tipoDeConstancia == "f1"){
                //Un Firmante
                $firmante1 = $request->name5;
                $descripcion1 = $request->posicion5;
                $formatoConstancia = 1;
            }elseif ($tipoDeConstancia == "f2"){
                //Dos Firmantes
                $firmante2 = $request->name5;
                $descripcion2 = $request->posicion5;
                $firmante1 = $request->name4;
                $descripcion1 = $request->posicion4;
                $formatoConstancia = 2;
            }elseif ($tipoDeConstancia == "f3"){
                //Tres Firmantes
                $firmante3 = $request->name5;
                $descripcion3 = $request->posicion5;
                $firmante2 = $request->name4;
                $descripcion2 = $request->posicion4;
                $firmante1 = $request->name3;
                $descripcion1 = $request->posicion3;
                $formatoConstancia = 3;
            }elseif ($tipoDeConstancia == "f4"){
                //Cuatro Firmantes
                $firmante4 = $request->name5;
                $descripcion4 = $request->posicion5;
                $firmante3 = $request->name4;
                $descripcion3 = $request->posicion4;
                $firmante2 = $request->name3;
                $descripcion2 = $request->posicion3;
                $firmante1 = $request->name2;
                $descripcion1 = $request->posicion2;
                $formatoConstancia = 4;
            }elseif ($tipoDeConstancia == "f5"){
                //Cinco Firmantes
                $firmante5 = $request->name5;
                $descripcion5 = $request->posicion5;
                $firmante4 = $request->name4;
                $descripcion4 = $request->posicion4;
                $firmante3 = $request->name3;
                $descripcion3 = $request->posicion3;
                $firmante2 = $request->name2;
                $descripcion2 = $request->posicion2;
                $firmante1 = $request->name1;
                $descripcion1 = $request->posicion1;
                $formatoConstancia = 5;
            }
            
            //DE ACUERDO AL NUMERO DE FIRMANTES, ENVIAMOS LOS DATOS
            $iter = 1;
            foreach($participantes as $participante){
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio_inst = $folio.$idTipo."C".$numLista;
                $participante->folio_inst = $folio_inst;
                if($folio_der > 0)
                    $participante->folio_peque = strval($folio_der);
								else
										$participante->folio_peque = "";
                $participante->save();
                if($formatoConstancia == 1){
                    $pdf = PDF::loadView('pages.pdf.constancia1F',
                    array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                        'descripcion1'=>$descripcion1, 'folio'=>$folio.$idTipo."C".$numLista,
                        'generacion'=>$generacion, 'texto'=>$texto,
                        'folio_der'=>$participante->folio_peque
											)
                    )->setPaper('letter', 'landscape');
                }elseif($formatoConstancia == 2){
                    $pdf = PDF::loadView('pages.pdf.constancia2F', 
                    array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                        'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                        'generacion'=>$generacion, 'texto'=>$texto,
                        'folio'=>$folio.$idTipo."C".$numLista,'folio_der'=>$participante->folio_peque)
                    )->setPaper('letter', 'landscape');
                }elseif($formatoConstancia == 3){
                    $pdf = PDF::loadView('pages.pdf.constancia3F',
                    array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                        'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                        'firmante3'=>$firmante3,'descripcion3'=>$descripcion3,
                        'generacion'=>$generacion, 'texto'=>$texto,
                        'folio'=>$folio.$idTipo."C".$numLista,'folio_der'=>$participante->folio_peque )
                    )->setPaper('letter', 'landscape');
                }elseif($formatoConstancia == 4){
                    $pdf = PDF::loadView('pages.pdf.constancia4F',
                    array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                        'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                        'firmante3'=>$firmante3,'descripcion3'=>$descripcion3, 'firmante4'=>$firmante4,'descripcion4'=>$descripcion4,
                        'generacion'=>$generacion, 'texto'=>$texto,
                        'folio'=>$folio.$idTipo."C".$numLista,'folio_der'=>$participante->folio_peque )
                    )->setPaper('letter', 'landscape');
                }elseif($formatoConstancia == 5){
                    $pdf = PDF::loadView('pages.pdf.constancia5F',
                    array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                        'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                        'firmante3'=>$firmante3,'descripcion3'=>$descripcion3, 'firmante4'=>$firmante4,'descripcion4'=>$descripcion4,
                        'firmante5'=>$firmante5,'descripcion5'=>$descripcion5,
                        'generacion'=>$generacion, 'texto'=>$texto,
                        'folio'=>$folio.$idTipo."C".$numLista,'folio_der'=>$participante->folio_peque )
                    )->setPaper('letter', 'landscape');
                }
                $nombreArchivo = strval($iter).'_'.$profesor->getNombresArchivo().'_C.pdf';
                $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
                $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
                $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                $iter++;
                $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
            }
            $zip::addString('Constancias_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Constancias_'.$curso->id.'.pdf')));
            $zip::close();
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return response()->download(public_path('constancias.zip'))->deleteFileAfterSend(public_path('constancias.zip'));
        }catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('warning', 'El curso no tiene alumnos que ameriten constancia');
        }catch(Exception $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        }
    }//End Function
}//End Class