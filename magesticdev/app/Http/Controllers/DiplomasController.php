<?php

namespace App\Http\Controllers;
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
        $zip = new Zipper();
        $zip::make(public_path('diplomas.zip'));
        try{
            $coordinadorGeneral = CoordinadorGeneral::all();
            $coordinadorGeneral = $coordinadorGeneral[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with('msj', 'Primero hay que dar de alta al Coordinador General');    
        } 
        try{
            $secretarioApoyo = SecretarioApoyo::all();
            $secretarioApoyo = $secretarioApoyo[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with('msj', 'Primero hay que dar de alta al Secretario de Apoyo a la Docencia');    
        }
        try{
            $director = Director::all();
            $director = $director[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with('msj', 'Primero hay que dar de alta al Director');    
        }     
        $diplomado = Diplomado::find($request->id);
        $idFol = $diplomado->getTypeId();
        $foja = $request->foja;
        $libro = $request->libro;
        $diplomadosCurso = DiplomadosCurso::where('diplomado_id',$diplomado->id)->get();
        $diplomadosProfesor = DiplomadosProfesor::where('diplomado_id',$diplomado->id)->get();
        $duracion = $diplomado->getDuracion();
        $fechaimp = $diplomado->getFecha();
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y');
        $fecha = explode("/",$fecha);
        $anio = $fecha[2];
        $dia_a = $fecha[0];
        $mes_a = $fecha[1];
        $folior = "F04".$anio.'D'.$idFol.'D';
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
        
        if (!$diplomadosProfesor){
          return redirect()
            ->back()
            ->with('msj', 'El diplomado no tiene alumnos inscritos');
        }
        if(!$diplomadosCurso){
          return redirect()
            ->back()
            ->with('msj', 'El diplomado no tiene cursos inscritos');
        }
        $tmp = Profesor::all();
        $folio_der = $request->folder;
        $iterprof = 1;
        foreach($diplomadosProfesor as $diplomadoProfesor){
          $acredito = true;
          $calificaciones = array();
          $cursos = array();
          $profesor = Profesor::find($diplomadoProfesor->profesor_id);
          $promedio = 0;
          $iterprom = 0;
          $numLista = $this->convertirACadena($iterprof);
          $folio = $folior.$numLista;
          foreach($diplomadosCurso as $diplomadoCurso){
            $curso = Curso::find($diplomadoCurso->curso_id);
            $participante = ParticipantesCurso::where('curso_id',$curso->id)
              ->where('profesor_id',$profesor->id)->get();
            //Un participante no aprobó un módulo
            if($participante == "[]"){
              $acredito = false;
              break;
            }
            $participante = $participante[0];
            if($participante->asistencia and $participante->acreditacion){
              if($curso->getInstitucion() == 'DGAPA' && $participante->calificacion >= 6){
                array_push($cursos,$curso);
                array_push($calificaciones,$participante->calificacion);
                $promedio += intval($participante->calificacion);
              }else if($curso->getInstitucion() == 'CD' && $participante->calificacion >= 8){
                array_push($cursos,$curso);
                array_push($calificaciones,$participante->calificacion);
                $promedio += intval($participante->calificacion);
              }else{
                //El alumno no amerita constancia
                $acredito = false;
              }
            }
            $iterprom++;
          }
          if($iterprom != 0){
          $promedio = $promedio / $iterprom;}
          if($acredito){
            $pdf = PDF::loadView('pages.pdf.diploma', array('profesor'=>$profesor,
              'calificaciones'=>$calificaciones,
              'promedio' => $promedio,
              'cursos'=>$cursos,
              'director'=>$director,
              'fecha'=>$fecha,
              'fechaimp'=>$fechaimp,
              'asistentes'=>$diplomadosProfesor->count(),
              'folio'=>$folio,
              'folio_der' => $folio_der,
              'foja'=>$foja,
              'libro'=>$libro,
              'duracion'=>$duracion,
              'direccion'=>$director,
              'coordinadorGeneral' => $coordinadorGeneral,
              'secretarioApoyo' => $secretarioApoyo,
              'diplomado'=>$diplomado))
              ->setPaper('letter', 'landscape');
            $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
            $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
          }
        $folio_der++;
        $iterprof++;   
        }
      $zip::close();
      return response()->download(public_path('diplomas.zip'))->deleteFileAfterSend(public_path('diplomas.zip'));
    }catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException  $e){
      return redirect()
        ->back()
        ->with('msj', 'El diplomado no tiene alumnos que ameriten diploma');
    }
  }
}//End Clase
