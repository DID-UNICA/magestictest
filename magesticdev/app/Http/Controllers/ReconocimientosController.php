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
use App\SecretarioApoyo;
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
    
    public function generar(Request $request, $id){
      try{
        $hash_aux = str_replace(".", "0",substr(Hash::make(url()->full(), [
          'rounds' => 4,
          ]),-4));
      }catch(\ErrorException  $e){
        return redirect()->back()->with('danger', 'Problemas con la url');
      }

      // DATOS DEL CURSO
      $curso = Curso::findOrFail($id);
      $cursoCatalogo = CatalogoCurso::findOrFail($curso->catalogo_id);
      $tipo = $cursoCatalogo->tipo;
      if($tipo == 'CT'){$tipo = 'T';}
      // TODO: Utilizar un arreglo llave valor
      $firmantes = array();
      $descripciones = array();
      $numFirmantes = 1;


      // PRIMER FIRMANTE
      //El reconocimiento necesita al coordinador del centro de docencia como mayor cargo
      if($request->tipof == 'A' || $request->tipof == 'B'){
        try{
          $coordinadorGeneral = CoordinadorGeneral::first();
          $firmantes[0] = $coordinadorGeneral->getNombreFirma();
          $descripciones[0] = $coordinadorGeneral->getDescripcion();
        }catch(\ErrorException  $e){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Coordinador del Centro de Docencia'
          );
        }
      }
      //El reconocimiento necesita al SAD como mayor cargo
      elseif($request->tipof == 'C'){
        try{
          $secretarioApoyo = SecretarioApoyo::first();
          $firmantes[0] = $secretarioApoyo->getNombreFirma();
          $descripciones[0] = $secretarioApoyo->getDescripcion();
        }catch(\ErrorException  $e){
          return redirect()->back()->with(
            'info', 
            'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
          );
        }
      }
      //El reconocimiento necesita al Director como mayor cargo
      elseif($request->tipof == 'D'){
        try{
          $director = Director::first();
          $firmantes[0] = $director->getNombreFirma();
          $descripciones[0] = $director->getDescripcion();
        }catch(\ErrorException  $e){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Director'
          );
        }
      }

      // SEGUNDO FIRMANTE
      // Se necesita al coordinador de área como menor cargo
      if($request->tipof == 'B'){
        $coordinacion = Coordinacion::findOrFail($cursoCatalogo->coordinacion_id);
        $firmantes[1] = $coordinacion->getNombreFirma();
        $descripciones[1] = $coordinacion->getDescripcion();
        $numFirmantes = 2;
      }
      // Se necesita al CCDD de área como menor cargo
      elseif($request->tipof == 'C'){
        try{
          $coordinadorGeneral = CoordinadorGeneral::first();
          $firmantes[1] = $coordinadorGeneral->getNombreFirma();
          $descripciones[1] = $coordinadorGeneral->getDescripcion();
          $numFirmantes = 2;
        }catch(\ErrorException  $e){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Coordinador del Centro de Docencia'
          );
        }
      }
      // Se necesita al SAD de área como menor cargo
      elseif($request->tipof == 'D'){
        try{
          $secretarioApoyo = SecretarioApoyo::first();
          $firmantes[1] = $secretarioApoyo->getNombreFirma();
          $descripciones[1] = $secretarioApoyo->getDescripcion();
          $numFirmantes = 2;
        }catch(\ErrorException  $e){
          return redirect()->back()->with(
            'info', 
            'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
          );
        }
      }

      //SE ELIGIÓ LA OPCIÓN MANUAL
      if ($request->tipof == "E"){
        //Un Firmante
        $firmantes[0] = $request->name5;
        $descripciones[0] = $request->posicion5;
      }elseif ($request->tipof == "F"){
        //Dos Firmantes
        $firmantes[1] = $request->name5;
        $descripciones[1] = $request->posicion5;
        $firmantes[0] = $request->name4;
        $descripciones[0] = $request->posicion4;
        $numFirmantes = 2;
      }elseif ($request->tipof == "G"){
        //Tres Firmantes
        $firmantes[2] = $request->name5;
        $descripciones[2] = $request->posicion5;
        $firmantes[1] = $request->name4;
        $descripciones[1] = $request->posicion4;
        $firmantes[0] = $request->name3;
        $descripciones[0] = $request->posicion3;
        $numFirmantes = 3;
      }elseif ($request->tipof == "H"){
        //Cuatro Firmantes
        $firmantes[3] = $request->name5;
        $descripciones[3] = $request->posicion5;
        $firmantes[2] = $request->name4;
        $descripciones[2] = $request->posicion4;
        $firmantes[1] = $request->name3;
        $descripciones[1] = $request->posicion3;
        $firmantes[0] = $request->name2;
        $descripciones[0] = $request->posicion2;
        $numFirmantes = 4;
      }elseif ($request->tipof == "I"){
        //Cinco Firmantes
        $firmantes[4] = $request->name5;
        $descripciones[4] = $request->posicion5;
        $firmantes[3] = $request->name4;
        $descripciones[3] = $request->posicion4;
        $firmantes[2] = $request->name3;
        $descripciones[2] = $request->posicion3;
        $firmantes[1] = $request->name2;
        $descripciones[1] = $request->posicion2;
        $firmantes[0] = $request->name1;
        $descripciones[0] = $request->posicion1;
        $numFirmantes = 5;
      }

      // OBTENCIÓN DE INSTRUCTORES
      $instructores = ProfesoresCurso::where('curso_id',$id)->get();
      if($instructores->count() == 0)
        return redirect()->back()->with(
          'danger', 'No hay instructores asignados en este curso'
        );

      // OBTENCIÓN DE FECHAS
      $fechaimp = $curso->getFecha();
      $fecha = Carbon::parse($curso->getFechaFin());
      $fecha = $fecha->format('d/m/Y');
      $fecha = explode("/",$fecha);
      $anio = $fecha[2];
      $dia_a = (int) $fecha[0];
      $mes_a = $fecha[1];
      $mes_a = $curso->translate_month($mes_a);
      $fecha = $dia_a . " de " .$mes_a . " de " . $anio;

      //FOLIO INSTITUCIONAL
      if($request->gen_folio_inst){
        $idTipo = (strlen($request->folio_inst) != 0 and is_numeric($request->folio_inst)) ? intval($request->folio_inst) : $curso->getTypeId();
        if($idTipo>99){
            $idTipo = (string)$idTipo;
        }elseif($idTipo>9){
            $idTipo="0".(string)$idTipo;
        }else{
            $idTipo="00".(string)$idTipo;
        }
      }

      //FOLIO PEQUEÑO
      if($request->gen_folio_peq)
        $folio_der = (strlen($request->folio_peq) != 0 and is_numeric($request->folio_peq)) ? intval($request->folio_peq) : -1;
      else
        $folio_der = -1;

      //TODO: TEXTO INTERMEDIO

      //ZIP, DIR y MERGER
      $pdfMerger = new PdfManage;
      $zip = new Zipper();
      $zip::make(public_path('reconocimientos.zip'));
      try{
        File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
      }catch(\ErrorException  $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        return redirect()->back()->with(
          'warning', 'Problemas con el directorio "tmp"'
        );
      }

      //SELECCIÓN DE FORMATO
      $iter = 1;
      try{
        //Recorremos cada instructor
        foreach($instructores as $instructor){
          $numLista = app('App\Http\Controllers\ReconocimientosController')->convertirACadena($iter);
          $profesor = Profesor::findOrFail($instructor->profesor_id);
          if($request->gen_folio_inst){
            $instructor->folio_inst = "F04".$anio.$tipo.$idTipo."R".$numLista;
          }
          else
            $instructor->folio_inst = "";
          if($folio_der > 0)
            $instructor->folio_peque = strval($folio_der);
          else
            $instructor->folio_peque = "";
          $instructor->save();
          
          // Reconocimiento para taller, curso, curso-taller o foro
          if ($cursoCatalogo->tipo == "T" || $cursoCatalogo->tipo == "C" || $cursoCatalogo->tipo == "CT" || $cursoCatalogo->tipo == "F"){
            $pdf = PDF::loadView('pages.pdf.reconocimientoCTTC', 
              array('curso' => $curso,
              'profesor'=>$profesor,
              'cursoCatalogo' => $cursoCatalogo,
              'fecha'=>$fecha,
              'firmantes'=>$firmantes,
              'descripciones'=>$descripciones,
              'numFirmantes'=>$numFirmantes,
              'fechaimp'=>$fechaimp,
              'folio'=>$instructor->folio_inst,
              'folio_der'=>$instructor->folio_peque))
            ->setPaper('letter', 'landscape');
          
          // Reconocimiento para evento
          } elseif($cursoCatalogo->tipo=="E"){
            $pdf = PDF::loadView('pages.pdf.reconocimientoE', 
            array('curso' => $curso,
            'profesor'=>$profesor,
            'cursoCatalogo' => $cursoCatalogo,
            'fecha'=>$fecha,
            'firmantes'=>$firmantes,
            'descripciones'=>$descripciones,
            'numFirmantes'=>$numFirmantes,
            'fechaimp'=>$fechaimp,
            'folio'=>$instructor->folio_inst,
            'folio_der'=>$instructor->folio_peque,
            'tema' => $request->texto_pers))
            ->setPaper('letter', 'landscape');
          // } elseif($cursoCatalogo->tipo=="S"){
          //   $tsprofs = TemaSeminarioProfesor::where('curso_id', $curso->id)->where('profesor_id',$profesor->id)->get();
          //   if($tsprofes->isEmpty()){
          //     rrmdir(resource_path('views/pages/tmp'.$hash_aux));
          //     $zip::close();
		 			// 		return redirect()->back()->with('danger', 'No hay un profesor asignado para algún tema del seminario');
          //   }
          //   // Tenemos que generar un reconocimiento por cada tema que el profesor impartió
          //   foreach($tsprofs as $tsprof){
          //     $tema=$tsprof->getTema();
          //     $pdf = PDF::loadView('pages.pdf.reconocimientoS', 
          //       array('curso' => $curso,
          //       'profesor'=>$profesor,
          //       'cursoCatalogo' => $cursoCatalogo,
          //       'fecha'=>$fecha, 
          //       'firmantes'=>$firmantes,
          //       'descripciones'=>$descripciones, 
          //       'fechaimp'=>$fechaimp,
          //       'duracion'=>$tema->duracion,
          //       'tema' => $tema->nombre,
          //       'folio' => $instructor->folio_inst,
          //       'folio_der' => $instructor_curso->folio_peque,
          //     ))->setPaper('letter', 'landscape');
          //       $nombreArchivo = strval($iter).'_'.$profesor->getNombresArchivo().'_R.pdf';
          //       $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
          //       $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
          //       $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
          //       $iter++;
          //       $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
          //   }
          //   }

          } elseif($cursoCatalogo->tipo=="D"){
            $diplomado = Diplomado::findOrFail($request->diplomado);
            $pdf = PDF::loadView('pages.pdf.reconocimientoD', 
            array('curso' => $curso,
            'profesor'=>$profesor,
            'cursoCatalogo' => $cursoCatalogo,
            'diplomado' => $diplomado,
            'fecha'=>$fecha,
            'firmantes'=>$firmantes,
            'descripciones'=>$descripciones,
            'numFirmantes'=>$numFirmantes,
            'fechaimp'=>$fechaimp,
            'folio'=>$instructor->folio_inst,
            'folio_der'=>$instructor->folio_peque))
            ->setPaper('letter', 'landscape');
          }else{
            rrmdir(resource_path('views/pages/tmp'.$hash_aux));
            $zip::close();
		 		  	return redirect()->back()->with('danger', 'Tipo aún no soportado');
          }
          $nombreArchivo = strval($iter).'_'.$profesor->getNombresArchivo().'_R.pdf';
          $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
          $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
          $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
          $iter++;
          $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
        }

        $zip::addString('Reconocimietos_'.$curso->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Reconocimientos_'.$curso->id.'.pdf')));
        $zip::close();
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
      }catch(Exception $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        $zip::close();
        return redirect()->back()->with(
          'warning', 'Errores al generar el formato'
        );
      }
         
    }//End Funcion 


}//End Clase
