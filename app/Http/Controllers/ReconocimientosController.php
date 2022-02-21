<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use PDF;
use App\Curso;
use App\CatalogoCurso;
use App\ProfesoresCurso;
use App\ParticipantesCurso;
use App\Diplomado;
use App\DiplomadosCurso;
use App\TemaSeminario;
use App\Profesor;
use App\Director;
use App\CoordinadorGeneral;
use App\SecretarioApoyo;
use App\Coordinacion;
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
        if($curso->getTipo() === 'D'){
          if(!$curso->diplomado_id)
            return redirect()->back()->with('danger', 
              'Para crear reconocimientos de un módulo de diplomado, es necesario que esté asociado al menos a un diplomado'
            );
          else
            return view("pages.reconocimientos-elegirTipoReconocimiento")
            ->with('curso',$curso)
            ->with('diplomado',Diplomado::findOrFail($curso->diplomado_id));
        }
        return view("pages.reconocimientos-elegirTipoReconocimiento")
          ->with('curso',$curso);
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
      $firmantes = array();
      $descripciones = array();
      $numFirmantes = 1;


      // PRIMER FIRMANTE
      //El reconocimiento necesita al coordinador del centro de docencia como mayor cargo
      if($request->tipof == 'A' || $request->tipof == 'B'){
        $coordinadorGeneral = CoordinadorGeneral::where('nombre_coordinacion', 'Coordinación Del Centro de Docencia')->get()->first();
        if(!$coordinadorGeneral){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Coordinador del Centro de Docencia'
          );
        }
        $firmantes[0] = $coordinadorGeneral->getNombreFirma();
        $descripciones[0] = $coordinadorGeneral->getDescripcion();
      }
      //El reconocimiento necesita al SAD como mayor cargo
      elseif($request->tipof == 'C'){
        $secretarioApoyo = SecretarioApoyo::first();
        if(!$secretarioApoyo){
          return redirect()->back()->with(
            'info', 
            'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
          );
        }
        $firmantes[0] = $secretarioApoyo->getNombreFirma();
        $descripciones[0] = $secretarioApoyo->getDescripcion();
      }
      //El reconocimiento necesita al Director como mayor cargo
      elseif($request->tipof == 'D'){
        $director = Director::first();
        if(!$director){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Director'
          );
        }
        $firmantes[0] = $director->getNombreFirma();
        $descripciones[0] = $director->getDescripcion();
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
        $coordinadorGeneral = CoordinadorGeneral::where('nombre_coordinacion', 'Coordinación Del Centro de Docencia')->get()->first();
        if(!$coordinadorGeneral){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Coordinador del Centro de Docencia'
          );
        }
        $firmantes[1] = $coordinadorGeneral->getNombreFirma();
        $descripciones[1] = $coordinadorGeneral->getDescripcion();
        $numFirmantes = 2;
      }
      // Se necesita al SAD de área como menor cargo
      elseif($request->tipof == 'D'){
        $secretarioApoyo = SecretarioApoyo::first();
        if(!$secretarioApoyo){
          return redirect()->back()->with(
            'info', 
            'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
          );
        }
        $firmantes[1] = $secretarioApoyo->getNombreFirma();
        $descripciones[1] = $secretarioApoyo->getDescripcion();
        $numFirmantes = 2;
      }
      $length4 = 0;
      $length3 = 0;
      $length2 = 0;
      $length1 = 0;
      $length0 = 0;
      //SE ELIGIÓ LA OPCIÓN MANUAL
      if ($request->tipof == "E"){
        //Un Firmante
        $firmantes[0] = $request->name5;
        $descripciones[0] = $request->posicion5;
        $length0 = Str::length($descripciones[0]);
      }elseif ($request->tipof == "F"){
        //Dos Firmantes
        $firmantes[1] = $request->name5;
        $descripciones[1] = $request->posicion5;
        $firmantes[0] = $request->name4;
        $descripciones[0] = $request->posicion4;
        $numFirmantes = 2;
        $length0 = Str::length($descripciones[0]); //4
        $length1 = Str::length($descripciones[1]); //5
        
      }elseif ($request->tipof == "G"){
        //Tres Firmantes
        $firmantes[2] = $request->name5;
        $descripciones[2] = $request->posicion5;
        $length2 = Str::length($descripciones[2]);
        $firmantes[1] = $request->name4;
        $descripciones[1] = $request->posicion4;
        $length1 = Str::length($descripciones[1]);
        $firmantes[0] = $request->name3;
        $descripciones[0] = $request->posicion3;
        $length0 = Str::length($descripciones[0]);
        $numFirmantes = 3;
      }elseif ($request->tipof == "H"){
        //Cuatro Firmantes
        $firmantes[3] = $request->name5;
        $descripciones[3] = $request->posicion5;
        $length3 = Str::length($descripciones[3]);
        $firmantes[2] = $request->name4;
        $descripciones[2] = $request->posicion4;
        $length2 = Str::length($descripciones[2]);
        $firmantes[1] = $request->name3;
        $descripciones[1] = $request->posicion3;
        $length1 = Str::length($descripciones[1]);
        $firmantes[0] = $request->name2;
        $descripciones[0] = $request->posicion2;
        $length0 = Str::length($descripciones[0]);
        $numFirmantes = 4;
      }elseif ($request->tipof == "I"){
        //Cinco Firmantes
        $firmantes[4] = $request->name5;
        $descripciones[4] = $request->posicion5;
        $length4 = Str::length($descripciones[4]);
        $firmantes[3] = $request->name4;
        $descripciones[3] = $request->posicion4;
        $length3 = Str::length($descripciones[3]);
        $firmantes[2] = $request->name3;
        $descripciones[2] = $request->posicion3;
        $length2 = Str::length($descripciones[2]);
        $firmantes[1] = $request->name2;
        $descripciones[1] = $request->posicion2;
        $length1 = Str::length($descripciones[1]);
        $firmantes[0] = $request->name1;
        $descripciones[0] = $request->posicion1;
        $length0 = Str::length($descripciones[0]);
        $numFirmantes = 5;
      }

      // OBTENCIÓN DE INSTRUCTORES
      $instructores = ProfesoresCurso::where('curso_id',$id)->get()->sortBy('id');
      if($instructores->count() == 0)
        return redirect()->back()->with(
          'danger', 'No hay instructores asignados en este curso'
        );

      // OBTENCIÓN DE FECHAS
      $fechaimp = $curso->getFecha();
      $fecha = $curso->getFechaFin();
      $fecha = explode("/",$fecha);
      $anio = $fecha[2];
      $dia_a = (int) $fecha[0];
      $mes_a = $fecha[1];
      $mes_a = $curso->translate_month($mes_a);
      $fecha = $dia_a . " de " .$mes_a . " de " . $anio;

      //FOLIO PEQUEÑO
      if($request->gen_folio_peq)
        $folio_der = (strlen($request->folio_peq) != 0 and is_numeric($request->folio_peq)) ? intval($request->folio_peq) : -1;
      else
        $folio_der = -1;

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
      //PDF del coordinador
      if($cursoCatalogo->tipo=="S"){
        $numLista = app('App\Http\Controllers\ReconocimientosController')->convertirACadena($iter);
        if($request->gen_folio_inst){
          $folio_inst = $request->folio_inst.$numLista;
        }
        else
          $folio_inst = "";
        if($folio_der > 0)
          $folio_peque = strval($folio_der);
        else
          $folio_peque = "";
        // fecha de todo el seminario
        if(!isset($coordinacion)){
          $coordinacion = Coordinacion::findOrFail($cursoCatalogo->coordinacion_id);
        }
        $pdf = PDF::loadView('pages.pdf.reconocimientoSC', 
          array('curso' => $curso,
          'coordinacion'=>$coordinacion,
          'cursoCatalogo' => $cursoCatalogo,
          'fecha'=>$fecha, 
          'firmantes'=>$firmantes,
          'descripciones'=>$descripciones,
          'numFirmantes'=>$numFirmantes,
          'fechaimp'=>$fechaimp,
          'texto' => $request->sem_pers_coord,
          'folio' => $folio_inst,
          'folio_der' => $folio_peque,
          'length0'=>$length0,
          'length1'=>$length1,
          'length2'=>$length2,
          'length3'=>$length3,
          'length4'=>$length4 
        ))->setPaper('letter', 'landscape');
        $nombreArchivo = strval($iter).'Coordinador_'.$coordinacion->coordinador.'_R.pdf';
        $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
        $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
        $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
        $iter++;
        $folio_der = $folio_der > 0 ? $folio_der + 1 : $folio_der - 1;
      }
      try{
        //Recorremos cada instructor
        foreach($instructores as $instructor){
          $numLista = app('App\Http\Controllers\ReconocimientosController')->convertirACadena($iter);
          $profesor = Profesor::findOrFail($instructor->profesor_id);
          if($request->gen_folio_inst){
            $instructor->folio_inst = $request->folio_inst.$numLista;
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
              'texto'=>$request->texto_pers,
              'folio'=>$instructor->folio_inst,
              'folio_der'=>$instructor->folio_peque,
              'length0'=>$length0,
              'length1'=>$length1,
              'length2'=>$length2,
              'length3'=>$length3,
              'length4'=>$length4        
              ))
            ->setPaper('letter', 'landscape');
          
          // Reconocimiento para evento
          }elseif($cursoCatalogo->tipo=="E"){
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
            'tema' => $request->texto_pers,
            'folio_der'=>$instructor->folio_peque,
            'length0'=>$length0,
            'length1'=>$length1,
            'length2'=>$length2,
            'length3'=>$length3,
            'length4'=>$length4 
            ))
            ->setPaper('letter', 'landscape');
          }elseif($cursoCatalogo->tipo=="S"){
              $tema = TemaSeminario::findOrFail($instructor->tema_seminario_id);
              if(!$fechaimp = $instructor->getFechaImparticion())
                return redirect()->back()
                  ->with('danger', 
                    'Uno de los instructores no tiene fecha de impartición en su tema del seminario'
                  );
              $pdf = PDF::loadView('pages.pdf.reconocimientoS', 
                array('curso' => $curso,
                'profesor'=>$profesor,
                'cursoCatalogo' => $cursoCatalogo,
                'fecha'=>$fecha, 
                'firmantes'=>$firmantes,
                'descripciones'=>$descripciones,
                'numFirmantes'=>$numFirmantes,
                'fechaimp'=>$fechaimp,
                'duracion'=>$tema->duracion,
                'tema' => $tema->nombre,
                'seminario' => $request->sem_pers,
                'texto'=>$request->texto_pers,
                'folio' => $instructor->folio_inst,
                'folio_der' => $instructor->folio_peque,
                'length0'=>$length0,
                'length1'=>$length1,
                'length2'=>$length2,
                'length3'=>$length3,
                'length4'=>$length4 
              ))->setPaper('letter', 'landscape');

          } elseif($cursoCatalogo->tipo=="D"){
            $diplomado = Diplomado::findOrFail($curso->diplomado_id);
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
            'texto'=>$request->texto_pers,
            'folio'=>$instructor->folio_inst,
            'folio_der'=>$instructor->folio_peque,
            'length0'=>$length0,
            'length1'=>$length1,
            'length2'=>$length2,
            'length3'=>$length3,
            'length4'=>$length4
            ))
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
