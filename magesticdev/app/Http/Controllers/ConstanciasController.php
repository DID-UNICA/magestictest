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
      try{
        $hash_aux = str_replace(".", "0",substr(Hash::make(url()->full(), [
          'rounds' => 4,
          ]),-4));
      }catch(\ErrorException  $e){
        return redirect()->back()->with('danger', 'Problemas con la url');
      }

      //Obtención de datos del curso
      $curso = Curso::findOrFail($id);
      if(!$curso->acreditacion)
        return redirect()->back()->with('danger', 'No hay calificación asignada para la acreditación de este curso');
      $cursoCatalogo = CatalogoCurso::find($curso->catalogo_id);
      $coordinacion = Coordinacion::find($cursoCatalogo->coordinacion_id);

      //Obtención de fechas
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
        $folio_der = (strlen($request->numero) != 0 and is_numeric($request->numero)) ? intval($request->numero) : -1;
      else
        $folio_der = -1;

      //TEXTO INTERMEDIO
      if($request->texto1 == "D"){
        $texto = $request->texto_per;
      }else{
        $texto = $request->texto1." ".$curso->getTipoCadena();
      }
        
      //GENERACION (UNICA)
      $tipoDeConstancia = $request->type;
      if ($tipoDeConstancia === "H")
        $generacion = $request->generacion;
      else
        $generacion = null;

      //BUSCAMOS AL PRIMER FIRMANTE
      // El tipo de constancia tiene al coordinador como mayor cargo
      if ($tipoDeConstancia == "A" or $tipoDeConstancia == "AA"){
          $firmante1 = $coordinacion->getNombreFirma();
          $descripcion1 = $coordinacion->getDescripcion();
          $formatoConstancia = 1;

      //El tipo de constancia necesita al coordinador del CD como mayor cargo
      }elseif ($tipoDeConstancia == "B" or $tipoDeConstancia == "D" 
      or $tipoDeConstancia == "I" or $tipoDeConstancia == "H"){
        $coordinadorGeneral = CoordinadorGeneral::where('nombre_coordinacion', 'Coordinación Del Centro de Docencia')->get()->first();
        if(!$coordinadorGeneral){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Coordinador del Centro de Docencia'
          );
        }
        $firmante1 = $coordinadorGeneral->getNombreFirma();
        $descripcion1 = $coordinadorGeneral->getDescripcion();
        $formatoConstancia = 1;

      //El tipo de constancia necesita al director como mayor cargo
      }elseif ($tipoDeConstancia == "E" OR $tipoDeConstancia == "G"){
        $director = Director::first();
        if(!$director){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Director'
          );
        }
        $firmante1 = $director->getNombreFirma();
        $descripcion1 = $director->getDescripcion();
        $formatoConstancia = 1;

      //El tipo de constancia necesita al SAD como mayor cargo
      }elseif ($tipoDeConstancia == "C" or $tipoDeConstancia == "F"){
        $secretarioApoyo = SecretarioApoyo::first();
        if(!$secretarioApoyo){
          return redirect()->back()->with(
            'info', 
            'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
          );
        }
        $firmante1 = $secretarioApoyo->getNombreFirma();
        $descripcion1 = $secretarioApoyo->getDescripcion();
        $formatoConstancia = 1;
      }

      //BUSCAMOS AL SEGUNDO FIRMANTE
      if($tipoDeConstancia == "I"){
        $firmante2 = $coordinacion->getNombreFirma();
        $descripcion2 = $coordinacion->getDescripcion();
        $formatoConstancia = 2;
      
      //El tipo de constancia necesita al SAD como menor cargo
      }elseif($tipoDeConstancia == "G"){
        $secretarioApoyo = SecretarioApoyo::first();
        if(!$secretarioApoyo){
          return redirect()->back()->with(
            'info', 
            'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
          );
        }
        $firmante2 = $secretarioApoyo->getNombreFirma();
        $descripcion2 = $secretarioApoyo->getDescripcion();
        $formatoConstancia = 2;

      //El tipo de constancia necesita al coordinador del CD como menor cargo
      }elseif($tipoDeConstancia == "F"){
        $coordinadorGeneral = CoordinadorGeneral::where('nombre_coordinacion', 'Coordinación Del Centro de Docencia')->get()->first();
        if(!$coordinadorGeneral){
          return redirect()->back()->with(
            'info',
            'Primero hay que dar de alta al Coordinador del Centro de Docencia”'
          );
        }
        $firmante2 = $coordinadorGeneral->getNombreFirma();
        $descripcion2 = $coordinadorGeneral->getDescripcion();
        $formatoConstancia = 2;
      }

      //BUSCAMOS A LOS INSTRUCTORES
      if ($tipoDeConstancia == "A" or $tipoDeConstancia == "B" 
      or $tipoDeConstancia == "C" or $tipoDeConstancia == "H"){
        //Contamos a los profesores
        $count = ProfesoresCurso::select('id')
        ->where('curso_id',$id)
        ->count();
        if($count == null){
          $zip = new Zipper();
          $zip::close();
          return redirect()->back()->with(
              'warning', 'No hay instructores asignados en este curso'
          );
        }

        if($count > 4){
          return redirect()->back()->with('danger', 'El formato no puede ser de más de cinco firmantes');
        }

        //Obtención de Instructores
        $profesoresCurso = ProfesoresCurso::where('curso_id',$id)->get();
        $profesores = array();
        foreach($profesoresCurso as $profesorCurso){
            $tmp = Profesor::find($profesorCurso->profesor_id);
            array_push($profesores,$tmp);
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
      }

      //SE ELIGIÓ LA OPCIÓN MANUAL
      if ($tipoDeConstancia == "f1"){
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

      //PARTICIPANTES
      $participantes = Profesor::leftJoin(
          'participante_curso',
          'profesors.id','=','participante_curso.profesor_id'
      )
      ->where('participante_curso.curso_id',$id)
      ->where('participante_curso.calificacion','>=',$curso->acreditacion)
      ->where('participante_curso.asistencia', TRUE)
      ->where('participante_curso.acreditacion', TRUE)
      ->select('profesors.*')
      ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
      ->get();
      if(count($participantes) <= 0){
          return redirect()->back()->with(
              'warning',
              'No hay alumnos que ameriten constancia'
          );
      }

      $tmp = array();
      foreach($participantes as $participante){
        $tmp2 = ParticipantesCurso::where(
            'participante_curso.profesor_id',$participante->id
        )
        ->where('participante_curso.curso_id',$id)->get();
        array_push($tmp,$tmp2[0]);
      }
      $participantes = $tmp;

      //ZIP, DIR y MERGER
      $pdfMerger = new PdfManage;
      $zip = new Zipper();
      $zip::make(public_path('constancias.zip'));
      try{
        File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
      }catch(\ErrorException  $e){
        return redirect()->back()->with(
          'warning', 'Problemas con el directorio "tmp"'
        );
      }

      //DE ACUERDO AL NUMERO DE FIRMANTES, ENVIAMOS LOS DATOS
      $iter = 1;
      try{
        foreach($participantes as $participante){
          $numLista = app('App\Http\Controllers\ConstanciasController')->convertirACadena($iter);
          $profesor = Profesor::findOrFail($participante->profesor_id);
          if($request->gen_folio){
            $participante->folio_inst = $request->typeid.$numLista;
          }
          else
            $participante->folio_inst = "";
          if($folio_der > 0)
                $participante->folio_peque = strval($folio_der);
            else
                $participante->folio_peque = "";
          $participante->save();
          if($formatoConstancia == 1){
            $pdf = PDF::loadView('pages.pdf.constancia1F',
              array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                'descripcion1'=>$descripcion1, 'folio'=>$participante->folio_inst,
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
                'folio'=>$participante->folio_inst,'folio_der'=>$participante->folio_peque)
            )->setPaper('letter', 'landscape');
          }elseif($formatoConstancia == 3){
            $pdf = PDF::loadView('pages.pdf.constancia3F',
            array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                'firmante3'=>$firmante3,'descripcion3'=>$descripcion3,
                'generacion'=>$generacion, 'texto'=>$texto,
                'folio'=>$participante->folio_inst,'folio_der'=>$participante->folio_peque )
            )->setPaper('letter', 'landscape');
          }elseif($formatoConstancia == 4){
            $pdf = PDF::loadView('pages.pdf.constancia4F',
            array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                'firmante3'=>$firmante3,'descripcion3'=>$descripcion3, 'firmante4'=>$firmante4,'descripcion4'=>$descripcion4,
                'generacion'=>$generacion, 'texto'=>$texto,
                'folio'=>$participante->folio_inst,'folio_der'=>$participante->folio_peque )
            )->setPaper('letter', 'landscape');
          }elseif($formatoConstancia == 5){
            $pdf = PDF::loadView('pages.pdf.constancia5F',
            array('curso' => $curso, 'profesor'=>$profesor, 'cursoCatalogo' => $cursoCatalogo,
                'fechaimp'=>$fechaimp,'fecha'=>$fecha, 'firmante1'=>$firmante1,
                'descripcion1'=>$descripcion1,'firmante2'=>$firmante2,'descripcion2'=>$descripcion2,
                'firmante3'=>$firmante3,'descripcion3'=>$descripcion3, 'firmante4'=>$firmante4,'descripcion4'=>$descripcion4,
                'firmante5'=>$firmante5,'descripcion5'=>$descripcion5,
                'generacion'=>$generacion, 'texto'=>$texto,
                'folio'=>$participante->folio_inst,'folio_der'=>$participante->folio_peque )
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
      }catch(Exception $e){
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        $zip::close();
        return redirect()->back()->with(
          'warning', 'Errores al generar el formato'
        );
      }
    }//End Function
}//End Class