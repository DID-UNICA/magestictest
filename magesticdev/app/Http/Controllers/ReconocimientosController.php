<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use PDF;
use App\Curso;
use App\CatalogoCurso;
use App\ProfesoresCurso;
use App\ParticipantesCurso;
use App\Diplomado;
use App\DiplomadosCurso;
use App\Profesor;
use App\Director;
use App\CoordinadorGeneral;
use App\SecretarioApoyo ;
use App\Coordinacion;
use App\TemaSeminarioProfesor;
use File;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use Carbon\Carbon;
use Zipper;
use Laracasts\Flash\Flash;
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

class ReconocimientosController extends Controller{

  public function fechaEnvio($id)
  {
      $curso = Curso::findOrFail($id);
      return view("pages.reconocimientos-fechaEnvio")
              ->with('curso',$curso);
  }
  
  public function fechaEnvioActualizar(Request $request, $id)
  {
      $curso = Curso::findOrFail($id);
      $curso->fecha_envio_reconocimiento = $request->envio;
      $curso->save();
      return redirect('reconocimientos/'.$id)
              ->with('curso', $curso)
              ->with('success', 'Fecha actualizada correctamente');
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
    public function selectType($id)
    {
        $curso = Curso::findOrFail($id);
        return view("pages.reconocimientos-elegirTipoReconocimiento")
                ->with('curso',$curso);
    }
    public function selectTypeD($diplomaid, $cursoid)
    {
        $curso = Curso::findOrFail($cursoid);
        $diplomado = Diplomado::findOrFail($diplomaid);
        return view("pages.reconocimientos-elegirTipoReconocimiento")
                ->with('curso',$curso)
                ->with('diplomado', $diplomado);
    }
    public function generarD($diplomadoid,$cursoid, Request $request){
        $curso = Curso::findOrFail($cursoid);
        $diplomado = Diplomado::findorFail($diplomadoid);
        $zip = new Zipper();
        $zip::make(public_path('reconocimientos.zip'));
        $count = ProfesoresCurso::select('id')
            ->where('curso_id', $curso->id)
            ->count();
            if($count == null){
              $zip::close();
              return redirect()->back()->with('warning', 'No hay instructores asignados para dicho curso');
          }
        try{
            $hash_aux = str_replace(".", "0",substr(Hash::make(url()->full(), [
                                        'rounds' => 4,
                                    ]),-4));
        }catch(\ErrorException  $e){
            return redirect()->back()->with('danger', 'Problemas con la url');
        }
        File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
        try{
            $coordinadorGeneral = CoordinadorGeneral::all();
            $coordinadorGeneral = $coordinadorGeneral[0];
        }catch(\ErrorException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('info', 'Primero hay que dar de alta al Coordinador General');    
        }try{
            $secretarioApoyo = SecretarioApoyo::all();
            $secretarioApoyo = $secretarioApoyo[0];
        }catch(\ErrorException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('info', 'Primero hay que dar de alta al Secretario de Apoyo a la Docencia');    
        }try{
            $director = Director::all();
            $director = $director[0];
        }catch(\ErrorException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('info', 'Primero hay que dar de alta al Director');    
        }
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
        $profesoresCurso = ProfesoresCurso::where('curso_id',$curso->id)->get();
        $profesores = array();
        foreach($profesoresCurso as $profesorCurso){
            $tmp = Profesor::find($profesorCurso->profesor_id);
            array_push($profesores,$tmp);
        } 
        $fechaimp = $curso->getFecha();
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y');
        $fecha = explode("/",$fecha);
        $anio = $fecha[2];
        $dia_a = (int) $fecha[0];
        $mes_a = $fecha[1];
        $folio_der = (strlen($request->folio_der) != 0 and is_numeric($request->folio_der)) ?  intval($request->folio_der) : -1;
        if ($mes_a == '01'){
            $mes_a = 'enero';
          }
          elseif ($mes_a == '02') {
            $mes_a = 'febrero';
          }
          elseif ($mes_a == '03') {
            $mes_a = 'marzo';
          }
          elseif ($mes_a == '04') {
            $mes_a = 'abril';
          }
          elseif ($mes_a == '05') {
            $mes_a = 'mayo';
          }
          elseif ($mes_a == '06') {
            $mes_a = 'junio';
          }
          elseif ($mes_a == '07') {
            $mes_a = 'julio';
          }
          elseif ($mes_a == '08') {
            $mes_a = 'agosto';
          }
          elseif ($mes_a == '09') {
            $mes_a = 'septiembre';
          }
          elseif ($mes_a == '10') {
            $mes_a = 'octubre';
          }
          elseif ($mes_a == '11') {
            $mes_a = 'noviembre';
          }
          elseif ($mes_a == '12') {
            $mes_a = 'diciembre';
          }
        $fecha = $dia_a . " de " .$mes_a . " de " . $anio;
        $folio = "F04".$anio.$tipo;
        $iter = 1;
        $ceros = "000";

        $pdfMerger = new PdfManage;

        foreach($profesores as $profesor){
            if($iter > 9 ){ $ceros = "00";}
            $folio_inst = $folio.$idTipo."R".$ceros.$iter;
            $instructor_curso = ProfesoresCurso::where('curso_id',$curso->id)
              ->where('profesor_id',$profesor->id)->get();
            $instructor_curso = $instructor_curso[0];
            $instructor_curso->folio_inst = $folio_inst;
            if($folio_der > 0)
              $instructor_curso->folio_peque = strval($folio_der);
						else
							$instructor_curso->folio_peque = "";
            $instructor_curso->save();
            $pdf = PDF::loadView('pages.pdf.reconocimientoD', 
                array('curso' => $curso,
                    'profesor'=>$profesor,
                    'cursoCatalogo' => $cursoCatalogo,
                    'diplomado' => $diplomado,
                    'fecha'=>$fecha, 
                    'coordinadorGeneral'=>$coordinadorGeneral, 
                    'fechaimp'=>$fechaimp,
                    'coordinacion'=>$coordinacion,
                    'secretarioApoyo' =>$secretarioApoyo,
                    'folio'=>$folio_inst,
                    'folio_der'=>$instructor_curso->folio_peque,
                    "tema" => $request->texto_personalizado))
                ->setPaper('letter', 'landscape');
            $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
            $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
            $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
            $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
            $iter++;
            $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
        }
        $zip::addString('Reconocimientos_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Reconocimientos_'.$curso->id.'.pdf')));
        $zip::close();
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
    }
    public function generar(Request $request){
        $pdfMerger = new PdfManage;
        $zip = new Zipper();
        $zip::make(public_path('reconocimientos.zip'));
        $count = ProfesoresCurso::select('id')
        ->where('curso_id',$request->id)
        ->count();
        if($count == null){
          $zip::close();
          return redirect()->back()->with('warning', 'No hay instructores asignados para dicho curso');
      }
        try{
            $hash_aux = str_replace(".", "0",substr(Hash::make(url()->full(), [
                                        'rounds' => 4,
                                    ]),-4));
        }catch(\ErrorException  $e){
            return redirect()->back()->with('danger', 'Problemas con la url');
        }
        try{
            $coordinadorGeneral = CoordinadorGeneral::all();
            $coordinadorGeneral = $coordinadorGeneral[0];
        }catch(\ErrorException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('info', 'Primero hay que dar de alta al Coordinador General');    
        } 
        try{
            $secretarioApoyo = SecretarioApoyo::all();
            $secretarioApoyo = $secretarioApoyo[0];
        }catch(\ErrorException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('info', 'Primero hay que dar de alta al Secretario de Apoyo a la Docencia');    
        }
        try{
            $director = Director::all();
            $director = $director[0];
        }catch(\ErrorException  $e){
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return redirect()->back()->with('info', 'Primero hay que dar de alta al Director');    
        } 
        $curso = Curso::findOrFail($request->id);
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
        $profesoresCurso = ProfesoresCurso::where('curso_id',$curso->id)->get();
        $profesores = array();
        foreach($profesoresCurso as $profesorCurso){
            $tmp = Profesor::find($profesorCurso->profesor_id);
            array_push($profesores,$tmp);
        }
        $fechaimp = $curso->getFecha();
        $fecha = Carbon::parse($curso->getFechaFin());
        $fecha = $fecha->format('d/m/Y');
        $fecha = explode("/",$fecha);
        $anio = $fecha[2];
        $dia_a = (int) $fecha[0];
        $mes_a = $fecha[1];
        $folio_der = (strlen($request->folio_der) != 0 and is_numeric($request->folio_der)) ?  intval($request->folio_der) : -1;
        if ($mes_a == '01'){
            $mes_a = 'enero';
          }
          elseif ($mes_a == '02') {
            $mes_a = 'febrero';
          }
          elseif ($mes_a == '03') {
            $mes_a = 'marzo';
          }
          elseif ($mes_a == '04') {
            $mes_a = 'abril';
          }
          elseif ($mes_a == '05') {
            $mes_a = 'mayo';
          }
          elseif ($mes_a == '06') {
            $mes_a = 'junio';
          }
          elseif ($mes_a == '07') {
            $mes_a = 'julio';
          }
          elseif ($mes_a == '08') {
            $mes_a = 'agosto';
          }
          elseif ($mes_a == '09') {
            $mes_a = 'septiembre';
          }
          elseif ($mes_a == '10') {
            $mes_a = 'octubre';
          }
          elseif ($mes_a == '11') {
            $mes_a = 'noviembre';
          }
          elseif ($mes_a == '12') {
            $mes_a = 'diciembre';
          }
        $fecha = $dia_a . " de " .$mes_a . " de " . $anio;
        $auxiliar = $tipo;
        if($tipo == 'CT'){
            $auxiliar = 'T';
        }
        $folio = "F04".$anio.$auxiliar;
    try{
      try{
        File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
    }catch(\ErrorException  $e){
        return redirect()->back()->with(
            'warning', 'Problemas con el directorio "tmp"'
        );    
    }
        if ($tipo == "T" || $tipo == "C" || $tipo == "CT" || $tipo == "F"){
              $iter = 1;
              $ceros = "000";
              foreach($profesores as $profesor){
                  if($iter>9){
                      $ceros = "00";
                  }
                  $folio_inst = $folio.$idTipo."R".$ceros.$iter;
                  $instructor_curso = ProfesoresCurso::where('curso_id',$curso->id)
                    ->where('profesor_id',$profesor->id)->get();
                  $instructor_curso = $instructor_curso[0];
                  $instructor_curso->folio_inst = $folio_inst;
                  $instructor_curso->fecha_envio = $request->envio;
                  if($folio_der > 0)
                    $instructor_curso->folio_peque = strval($folio_der);
									else
										$instructor_curso->folio_peque = "";
                  $instructor_curso->save();
                    $pdf = PDF::loadView(
                        'pages.pdf.reconocimientoCTTC', 
                        array('curso' => $curso,
                            'profesor'=>$profesor,
                            'cursoCatalogo' => $cursoCatalogo,
                            'fecha'=>$fecha, 
                            'coordinadorGeneral'=>$coordinadorGeneral, 
                            'fechaimp'=>$fechaimp,
                            'coordinacion'=>$coordinacion,
                            'folio'=>$folio_inst,
                            'folio_der'=>$instructor_curso->folio_peque))
                        ->setPaper('letter', 'landscape');

                $nombreArchivo = strval($iter).'_'.$profesor->getNombresArchivo().'_R.pdf';
                $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
                $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
                $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                $iter++;
                $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
            }
            $zip::addString('Reconocimientos_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Reconocimientos_'.$curso->id.'.pdf')));
            $zip::close();
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
        }elseif($tipo == "E"){
            $iter = 1;
            $ceros = "000";
            foreach($profesores as $profesor){
                if($iter >9 ){ $ceros = "00";}
                $folio_inst = $folio.$idTipo."R".$ceros.$iter;
                $instructor_curso = ProfesoresCurso::where('curso_id',$curso->id)
                  ->where('profesor_id',$profesor->id)->get();
                $instructor_curso = $instructor_curso[0];
                $instructor_curso->folio_inst = $folio_inst;
                if($folio_der > 0)
                  $instructor_curso->folio_peque = strval($folio_der);
								else
									$instructor_curso->folio_peque = "";
                $instructor_curso->save();
                $pdf = PDF::loadView('pages.pdf.reconocimientoE', 
                    array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fecha'=>$fecha, 
                        'coordinadorGeneral'=>$coordinadorGeneral, 
                        'fechaimp'=>$fechaimp,
                        'coordinacion'=>$coordinacion,
                        'secretarioApoyo' =>$secretarioApoyo,
                        'folio'=>$folio_inst,
                        'folio_der'=>$instructor_curso->folio_peque,
                        "tema" => $request->texto_personalizado))
                    ->setPaper('letter', 'landscape');
                $nombreArchivo = strval($iter).'_'.$profesor->getNombresArchivo().'_R.pdf';
                $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
                $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
                $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                $iter++;
                $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
            }
            $zip::addString('Reconocimientos_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Reconocimientos_'.$curso->id.'.pdf')));
            $zip::close();
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
        }elseif($tipo == "S"){
            $tsprofes = TemaSeminarioProfesor::where('curso_id', $curso->id)->get();
						if($tsprofes->isEmpty())
							return redirect()->back()->with('danger', 'No hay profesores asignados para los temas del seminario');
            $ceros = "000";
            $iter = 1;
          foreach($tsprofes as $tsp){
            if($iter >9 ){ $ceros = "00";}
            $profesor=$tsp->getProfesor();
            $tema=$tsp->getTema();
            $folio_inst = $folio.$idTipo."R".$ceros.$iter;
            $instructor_curso = ProfesoresCurso::where('curso_id',$curso->id)
              ->where('profesor_id',$profesor->id)->get();
            $instructor_curso = $instructor_curso[0];
            $instructor_curso->folio_inst = $folio_inst;
            if($folio_der > 0)
              $instructor_curso->folio_peque = strval($folio_der);
						else
							$instructor_curso->folio_peque = "";
            $instructor_curso->save();
            $pdf = PDF::loadView('pages.pdf.reconocimientoS', 
              array('curso' => $curso,
              'profesor'=>$profesor,
              'cursoCatalogo' => $cursoCatalogo,
              'fecha'=>$fecha, 
              'coordinadorGeneral'=>$coordinadorGeneral, 
              'fechaimp'=>$fechaimp,
              'coordinacion'=>$coordinacion,
              'duracion'=>$tema->duracion,
              'folio' => $folio_inst,
              'folio_der' => $instructor_curso->folio_peque,
              'tema' => $tema->nombre))
                  ->setPaper('letter', 'landscape');
              $nombreArchivo = strval($iter).'_'.$profesor->getNombresArchivo().'_R.pdf';
              $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
              $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
              $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
              $iter++;
              $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
          }
          $zip::addString('Reconocimientos_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Reconocimientos_'.$curso->id.'.pdf')));
          $zip::close();
          rrmdir(resource_path('views/pages/tmp'.$hash_aux));
          return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
        }
        else{
            return "Error en el tipo";
        }
    }catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException  $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        return redirect()->back()->with('danger', 'Error');
      }catch(Exception $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
    }
         
    }//End Funcion 


}//End Clase
