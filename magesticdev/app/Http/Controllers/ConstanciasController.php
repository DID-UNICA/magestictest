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
        $generacion = $request->generacion;
        $folio_der = (strlen($request->numero) != 0 and is_numeric($request->numero)) ?  intval($request->numero) : -1;
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
        $tipoDeConstancia = $request->type;
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
        if($institucion == 'DGAPA'){
            $acreditacion = '6';
        }
        else if($institucion == 'CD'){
            $acreditacion = '8';
        }
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
        try{
            try{
                File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
            }catch(\ErrorException  $e){
                return redirect()->back()->with(
                    'warning', 'Problemas con el directorio "tmp"'
                );    
            }
            if ($tipoDeConstancia == "A"){
            // El tipo de constancia es Instructores y Coordinador
                if($count == 1){
                //La constancia es para cuando sólo hay un instructor
                    $iter = 1;
                foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app(
                        'App\Http\Controllers\ConstanciasController'
                    )->convertirACadena($iter);
                    $profesor = Profesor::findOrFail(
                        $participante->profesor_id
                    );
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.constanciaUnInstructor', 
                        array('curso' => $curso,
                            'profesor'=>$profesor,
                            'cursoCatalogo' => $cursoCatalogo,
                            'fechaimp'=>$fechaimp,
                            'fecha'=>$fecha,
                            'coordinacion'=>$coordinacion,
                            'instructor1'=>$profesores[0],
                            'folio_der'=>strval($folio_der), 
                            'folio'=>$folio_inst
                        )
                    )->setPaper('letter', 'landscape');
                    
                    $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
                    $pdf->save(
                        resource_path(
                            'views/pages/tmp'.$hash_aux.'/'.$nombreArchivo
                        )
                    );
                    $pdfMerger->addPDF(
                        resource_path(
                            'views/pages/tmp'.$hash_aux.'/'.$nombreArchivo
                        ), 
                        'all','L'
                    );
                    $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                    $iter++;
                    $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
                }
                $zip::addString(
                    'Constancias_'.$curso->id.'.pdf',
                    $pdfMerger->merge(
                        'string',resource_path(
                            'views/pages/tmp'.$hash_aux.'/Constancias_'.$curso->id.'.pdf'
                        )
                    )
                );
                $zip::close();
                rrmdir(resource_path('views/pages/tmp'.$hash_aux));
                return response()->download(public_path('constancias.zip'))->deleteFileAfterSend(public_path('constancias.zip'));
            }elseif($count == 2){
                $iter = 1;
                foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaDosInstructores', 
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,'fecha'=>$fecha, 
                    'coordinacion'=>$coordinacion,
                    'instructor1'=>$profesores[0], 
                    'instructor2'=>$profesores[1], 
                    'folio'=>$folio.$idTipo."C".$numLista, 
                    'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                        $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

                }elseif($count == 3){
                $iter = 1;
                foreach($participantes as $participante){
                  
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaTresInstructores', 
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,
                    'fecha'=>$fecha, 
                    'coordinacion'=>$coordinacion,
                    'instructor1'=>$profesores[0], 
                    'instructor2'=>$profesores[1], 
                    'instructor3'=>$profesores[2], 
                    'folio'=>$folio.$idTipo."C".$numLista,
                    'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                    $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
                    $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
                    $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
                    $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                    $iter++;
                    $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
                  
              }
                  $zip::addString('Constancias_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Constancias_'.$curso->id.'.pdf')));
                  $zip::close();
                  rrmdir(resource_path('views/pages/tmp'.$hash_aux));
                  return response()->download(public_path('constancias.zip'));//->deleteFileAfterSend(public_path('constancias.zip'));
            }
        }elseif ($tipoDeConstancia == "B"){
            // El tipo de constancia es Instructores y Coordinación General
            if($count == 1){
            //La constancia es para cuando sólo hay un instructor
            $iter = 1;
                foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);

                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaUnInstructorCoordinadorGeneral', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha, 
                'coordinadorGeneral'=>$coordinadorGeneral,
                'instructor'=>$profesores[0], 
                'folio'=>$folio.$idTipo."C".$numLista,
                'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

            }elseif($count == 2){
                $iter = 1;
                foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);

                        $profesor = Profesor::findOrFail($participante->profesor_id);
                        $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                        $pdf = PDF::loadView('pages.pdf.constanciaDosInstructoresCoordinadorGeneral', 
                        array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,
                        'fecha'=>$fecha, 
                        'coordinadorGeneral'=>$coordinadorGeneral,
                        'instructor1'=>$profesores[0],
                        'instructor2'=>$profesores[1], 
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                        $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

                }elseif($count == 3){
                $iter = 1;
                foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);

                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaTresInstructoresCoordinadorGeneral', 
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,
                    'fecha'=>$fecha, 
                    'coordinadorGeneral'=>$coordinadorGeneral,
                    'instructor1'=>$profesores[0],
                    'instructor2'=>$profesores[1], 
                    'instructor3'=>$profesores[2], 
                    'folio'=>$folio.$idTipo."C".$numLista,
                    'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                    $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
            }
        }elseif ($tipoDeConstancia == "AA"){
        // El tipo de constancia es Coordinador

            $iter = 1;
            foreach($participantes as $participante){
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);

                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaSoloCoordinacion', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,
                'fecha'=>$fecha, 
                'coordinacion'=>$coordinacion,
                'folio'=>$folio.$idTipo."C".$numLista,
                'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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


        }elseif ($tipoDeConstancia == "C"){
            // El tipo de constancia es Instructores y SAD

            if($count == 1){
            //La constancia es para cuando sólo hay un instructor
              $iter = 1;
              foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);

                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaUnInstructorSAD', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha,
                'secretarioApoyo'=>$secretarioApoyo, 
                'instructor'=>$profesores[0], 
                'folio'=>$folio.$idTipo."C".$numLista,
                'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

            }elseif($count == 2){
                $iter = 1;
                foreach($participantes as $participante){
                        $folio = "F04".$anio.$tipo;
                        $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);

                        $profesor = Profesor::findOrFail($participante->profesor_id);
                        $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                        $pdf = PDF::loadView('pages.pdf.constanciaDosInstructoresSAD', 
                        array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha, 
                        'secretarioApoyo'=>$secretarioApoyo,
                        'instructor1'=>$profesores[0],
                        'instructor2'=>$profesores[1], 
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                        $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

            }elseif($count == 3){
                $iter = 1;
                foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaTresInstructoresSAD', 
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,
                    'fecha'=>$fecha, 
                    'secretarioApoyo'=>$secretarioApoyo,
                    'instructor1'=>$profesores[0],
                    'instructor2'=>$profesores[1],
                    'instructor3'=>$profesores[2],
                     'folio'=>$folio.$idTipo."C".$numLista,'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                    $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
                }
        }elseif ($tipoDeConstancia == "D"){
            //Coord. Gral.

            $iter = 1;
            foreach($participantes as $participante){
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaCoordinadorGeneral', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,
                'fecha'=>$fecha, 
                'coordinadorGeneral'=>$coordinadorGeneral,
                'folio'=>$folio.$idTipo."C".$numLista,
                'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }elseif ($tipoDeConstancia == "E"){
            //Director

            $iter = 1;
            foreach($participantes as $participante){
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaDirector', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha, 
                'direccion'=>$director, 
                'folio'=>$folio.$idTipo."C".$numLista,
                'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }elseif ($tipoDeConstancia == "F"){
            //Coord. Gral. y SAD
            $iter = 1;
            foreach($participantes as $participante){
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaCoordinadorGeneralYSAD', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,
                'fecha'=>$fecha, 
                'secretarioApoyo'=>$secretarioApoyo,
                'coordinadorGeneral'=>$coordinadorGeneral,
                 'folio'=>$folio.$idTipo."C".$numLista,
                 'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }

        elseif ($tipoDeConstancia == "G"){ ////////////////////////Usado como base para constanciaCDDYSAD
            //SAD y Director
            $iter = 1;
            foreach($participantes as $participante){
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaSADYDirector', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,
                'fecha'=>$fecha, 
                'secretarioApoyo'=>$secretarioApoyo,
                'direccion'=>$director,
                 'folio'=>$folio.$idTipo."C".$numLista,
                 'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }elseif ($tipoDeConstancia == "H"){
            //UNICA
            if($count == 1){
            //La constancia es para cuando sólo hay un instructor
            $iter = 1;
            foreach($participantes as $participante){
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaUnicaUnInstructor', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,
                'generacion' =>$generacion,
                'fecha'=>$fecha, 
                'coordinadorGeneral'=>$coordinadorGeneral,
                'instructor'=>$profesores[0], 
                'folio'=>$folio.$idTipo."C".$numLista,
                'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

            }elseif($count == 2){
            $iter = 1;
            foreach($participantes as $participante){
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaUnicaDosInstructores', 
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,'fecha'=>$fecha, 
                    'coordinadorGeneral'=>$coordinadorGeneral,
                    'generacion' =>$generacion,
                    'instructor1'=>$profesores[0],
                    'instructor2'=>$profesores[1], 
                    'folio'=>$folio.$idTipo."C".$numLista,
                    'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                    $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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

                }elseif($count == 3){
            $iter = 1;
            foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaUnicaTresInstructores', 
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,
                    'fecha'=>$fecha, 
                    'generacion' =>$generacion,
                    'coordinadorGeneral'=>$coordinadorGeneral,
                    'instructor1'=>$profesores[0],
                    'instructor2'=>$profesores[1],
                    'instructor3'=>$profesores[2],
                    'folio'=>$folio.$idTipo."C".$numLista,
                    'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                    $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
            }
        }elseif ($tipoDeConstancia == "I"){
            //Coord. y Coord. Gral.
              $iter = 1;
              foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView('pages.pdf.constanciaCoordinacionYCoordinadorGeneral',
                    array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'fechaimp'=>$fechaimp,
                    'fecha'=>$fecha, 
                    'coordinacion'=>$coordinacion,
                    'coordinadorGeneral'=>$coordinadorGeneral,
                    'folio'=>$folio.$idTipo."C".$numLista,
                    'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        } elseif ($tipoDeConstancia == "f1"){
            //Un Firmante
            if($request->texto1 == "D"){
                $texto = $request->texto1P;
            }else{
                $texto = $request->texto1." ".$curso->getTipoCadena();

            }
              $iter = 1;
              foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.constanciaUnFirmante',
                        array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fechaimp'=>$fechaimp,'fecha'=>$fecha,
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'nombre'=>$request->name1A,
                        'cargo'=>$request->posicion1A,
                        'texto'=>$texto,'folio_der'=>strval($folio_der), ))
                        ->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }elseif ($tipoDeConstancia == "f2"){
            //Dos Firmantes
            if($request->texto2 == "D"){
                $texto = $request->texto2P;
            }else{
                $texto = $request->texto2." ".$curso->getTipoCadena();
            }
              $iter = 1;
              foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.constanciaDosFirmantes',
                        array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fecha'=>$fecha, 
                        'fechaimp' => $fechaimp, 
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'nombre1'=>$request->name1B,
                        'cargo1'=>$request->posicion1B,
                        'nombre2'=>$request->name2B,
                        'cargo2'=>$request->posicion2B,
                        'texto'=>$texto,'folio_der'=>strval($folio_der), ))
                        ->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }elseif ($tipoDeConstancia == "f3"){
            //Tres Firmantes
            if($request->texto3 == "D"){
                $texto = $request->texto3P;
            }else{
                $texto = $request->texto3." ".$curso->getTipoCadena();
            }
              $iter = 1;
              foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.constanciaTresFirmantes',
                        array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fecha'=>$fecha,
                        'fechaimp'=>$fechaimp,
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'nombre1'=>$request->name1C,
                        'cargo1'=>$request->posicion1C,
                        'nombre2'=>$request->name2C,
                        'cargo2'=>$request->posicion2C,
                        'nombre3'=>$request->name3C,
                        'cargo3'=>$request->posicion3C,
                        'texto'=>$texto,
                        'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');

                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
    }elseif ($tipoDeConstancia == "f4"){
            //Cuatro Firmantes
            if($request->texto4 == "D"){
                $texto = $request->texto4P;
            }else{
                $texto = $request->texto4." ".$curso->getTipoCadena();
            }
              $iter = 1;
              foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.constanciaCuatroFirmantes',
                        array('fechaimp'=>$fechaimp,
                        'curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fecha'=>$fecha,
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'nombre1'=>$request->name1D,
                        'cargo1'=>$request->posicion1D,
                        'nombre2'=>$request->name2D,
                        'cargo2'=>$request->posicion2D,
                        'nombre3'=>$request->name3D,
                        'cargo3'=>$request->posicion3D,
                        'nombre4'=>$request->name4D,
                        'cargo4'=>$request->posicion4D,
                        'texto'=>$texto,
                        'folio_der'=>strval($folio_der), ))
                        ->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
    } elseif ($tipoDeConstancia == "f5"){
            //Cinco Firmantes
            if($request->texto5 == "D"){
                $texto = $request->texto5P;
            }else{
                $texto = $request->texto5." ".$curso->getTipoCadena();
            }
              $iter = 1;
              foreach($participantes as $participante){
                    $profesor = Profesor::findOrFail($participante->profesor_id);
                    $folio = "F04".$anio.$tipo;
                    $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                    $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.constanciaCincoFirmantes',
                        array('fechaimp'=>$fechaimp,
                        'curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fecha'=>$fecha,
                        'folio'=>$folio.$idTipo."C".$numLista,
                        'nombre1'=>$request->name1E,
                        'cargo1'=>$request->posicion1E,
                        'nombre2'=>$request->name2E,
                        'cargo2'=>$request->posicion2E,
                        'nombre3'=>$request->name3E,
                        'cargo3'=>$request->posicion3E,
                        'nombre4'=>$request->name4E,
                        'cargo4'=>$request->posicion4E,
                        'nombre5'=>$request->name5E,
                        'cargo5'=>$request->posicion5E,
                        'texto'=>$texto,
                        'folio_der'=>strval($folio_der), ))
                        ->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }
            elseif ($tipoDeConstancia == "J"){ ////////////////////////////////
            //Constancia CDDYSAD
            $iter = 1;
            foreach($participantes as $participante){
                $profesor = Profesor::findOrFail($participante->profesor_id);
                $folio = "F04".$anio.$tipo;
                $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
                $folio_inst = $folio.$idTipo."C".$numLista;
                    $participante->folio_inst = $folio_inst;
                    if($folio_der > 0)
                      $participante->folio_peque = strval($folio_der);
                    $participante->save();
                $pdf = PDF::loadView('pages.pdf.constanciaCDDYSAD', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,
                'fecha'=>$fecha, 
                 'folio'=>$folio.$idTipo."C".$numLista,
                 'folio_der'=>strval($folio_der), ))->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
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
        }




    }catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException  $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        return redirect()->back()->with('warning', 'El curso no tiene alumnos que ameriten constancia');
    }catch(Exception $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
    }

    }//End Funcion
}//End Clase
