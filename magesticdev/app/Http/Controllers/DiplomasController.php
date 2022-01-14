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
use App\Diplomado;
use App\DiplomadosCurso;
use App\DiplomadosProfesor;
use App\CoordinadorGeneral;
use App\SecretarioApoyo ;
use App\Coordinacion;
use Carbon\Carbon;
use Zipper;
use Laracasts\Flash\Flash;
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
class DiplomasController extends Controller{

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
        $diplomado = Diplomado::findOrFail($id);
        return view("pages.diplomas-elegirTipoDiploma")
                ->with('diplomado',$diplomado);
    }

    public function generar(Request $request){
      try{
        $hash_aux = str_replace(".", "0",substr(Hash::make(url()->full(), [
          'rounds' => 4,
          ]),-4));
      }catch(\ErrorException  $e){
          return redirect()->back()->with('danger', 'Problemas con la url');
      }
      $diplomado = Diplomado::findOrFail($request->id);

      //Obtención de firmantes
      $director = Director::first();
      if(!$director){
        return redirect()->back()->with(
          'info',
          'Primero hay que dar de alta al Director'
        );
      }
      $coordinadorGeneral = CoordinadorGeneral::where('nombre_coordinacion', 'Coordinación Del Centro de Docencia')->get()->first();
      if(!$coordinadorGeneral)
        return redirect()->back()->with('info', 
        'Primero hay que dar de alta al Coordinador del Centro de Docencia'
        );
      $secretarioApoyo = SecretarioApoyo::first();
      if(!$secretarioApoyo)
        return redirect()->back()->with('info', 
        'Primero hay que dar de alta al Secretario de Apoyo a la Docencia'
        );

      // FOLIOS
      $folio_inst = $request->folio_inst;
      $folio_peq = (strlen($request->folio_peq) != 0 and is_numeric($request->folio_peq)) ?  intval($request->folio_peq) : -1;
      $num_foja = $request->num_foja;
      $num_libro = $request->num_libro;

      //Fechas
      $duracion = $diplomado->getDuracion();
      $fechaimp = $diplomado->getFecha();
      $fecha = Carbon::now();
      $fecha = $fecha->format('d/m/Y');
      $fecha = explode("/",$fecha);
      $anio = $fecha[2];
      $dia_a = $fecha[0];
      $mes_a = $fecha[1];
      //TODO: Implementar helper de fecha
      if ($mes_a == '01'){
          $mes_a = 'enero';
      }elseif ($mes_a == '02') {
          $mes_a = 'febrero';
      }elseif ($mes_a == '03') {
          $mes_a = 'marzo';
      }elseif ($mes_a == '04') {
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
      // $diplomadosCurso = DiplomadosCurso::where('diplomado_id',$diplomado->id)->get();
      // $diplomadosProfesor = DiplomadosProfesor::where('diplomado_id',$diplomado->id)->get();
      
      //Modulos
      $modulos = Curso::where('diplomado_id', $diplomado->id)->get();
      if($modulos->isEmpty()){
        return redirect()
          ->back()
          ->with('danger', 'El diplomado no tiene módulos asociados');
      }

      // Participantes
      $participantes = ParticipantesCurso::where('curso_id', $modulos->first()->id)->get();
      if ($participantes->isEmpty()){
        return redirect()
          ->back()
          // Un módulo no tiene inscritos
          ->with('danger', 'El diplomado no tiene alumnos que ameriten diploma');
      }

      $iterprof = 1;
      $acreditados_empty = true;

      //ZIP, PDF, MERGER
      File::makeDirectory(resource_path('views/pages/tmp'.$hash_aux),0777,true);
      $pdfMerger = new PdfManage;
      $zip = new Zipper();
      $zip::make(public_path('diplomas.zip'));

      foreach($participantes as $participante){
        $acredito = true;
        $calificaciones = array();
        // $cursos = array();
        $profesor = Profesor::findOrFail($participante->profesor_id);
        $promedio = 0;
        $iterprom = 0;
        $numLista = $this->convertirACadena($iterprof);
        if($folio_inst != '')
          $folio = $folio_inst.$numLista;
        else
          $folio = '';
        foreach($modulos as $modulo){
          // ¿El participante está inscrito en todos los módulos?
          if(ParticipantesCurso::where('curso_id',$modulo->id)
          ->where('profesor_id',$participante->profesor_id)->get()->isEmpty()){
            $acredito = false;
            break;
          }
          //El participante canceló su inscripción
          if($participante->cancelacion){
            $acredito = false;
            break;
          }
          if($participante->asistencia and $participante->acreditacion){
            if($participante->acreditacion >= $modulo->calificacion){
              // array_push($cursos,$curso);
              array_push($calificaciones,$participante->calificacion);
              $promedio += intval($participante->calificacion);
            }else{
              //El alumno no amerita constancia
              $acredito = false;
            }
          }else{
            $acredito = false;
          }
          $iterprom++;
        }
        if($iterprom != 0)
          $promedio = $promedio / $iterprom;
        if($acredito){
          $acreditados_empty = false;
          $pdf = PDF::loadView('pages.pdf.diploma', array('profesor'=>$profesor,
            'calificaciones'=>$calificaciones,
            'promedio' => $promedio,
            'cursos'=>$modulos,
            'director'=>$director,
            'fecha'=>$fecha,
            'fechaimp'=>$fechaimp,
            'asistentes'=>$participantes->count(),
            'folio'=>$folio,
            'folio_der'=>$folio_peq,
            'foja'=>$num_foja,
            'libro'=>$num_libro,
            'duracion'=>$duracion,
            'direccion'=>$director,
            'coordinadorGeneral' => $coordinadorGeneral,
            'secretarioApoyo' => $secretarioApoyo,
            'diplomado'=>$diplomado))
            ->setPaper('letter', 'landscape');
          $nombreArchivo = strval($iterprof).'_'.$profesor->getNombresArchivo().'_D.pdf';
          $pdf->save(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo));
          $pdfMerger->addPDF(resource_path('views/pages/tmp'.$hash_aux.'/'.$nombreArchivo),'all','L');
          $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
        }
        $folio_peq = $folio_peq > 0 ? $folio_peq + 1 : $folio_peq - 1;
        $iterprof++;   
      }
      
      if($acreditados_empty){
        $zip::close();
        rrmdir(resource_path('views/pages/tmp'.$hash_aux));
        return redirect()
        ->back()
        ->with('warning', 'El diplomado no tiene alumnos que ameriten diploma');
      }

      $zip::addString('Diplomas_'.$diplomado->id.'.pdf',$pdfMerger->merge('string',resource_path('views/pages/tmp'.$hash_aux.'/Diplomas_'.$diplomado->id.'.pdf')));
      $zip::close();
      rrmdir(resource_path('views/pages/tmp'.$hash_aux));
      return response()->download(public_path('diplomas.zip'))->deleteFileAfterSend(public_path('diplomas.zip'));
    }
}//End Clase
