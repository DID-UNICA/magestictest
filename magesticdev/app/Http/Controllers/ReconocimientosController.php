<?php

namespace App\Http\Controllers;

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
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use Carbon\Carbon;
use Zipper;
use Laracasts\Flash\Flash;
use App\Http\Controllers\PDFManage;

class ReconocimientosController extends Controller{

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
        try{
            $coordinadorGeneral = CoordinadorGeneral::all();
            $coordinadorGeneral = $coordinadorGeneral[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with('msj', 'Primero hay que dar de alta al Coordinador General');    
        }try{
            $secretarioApoyo = SecretarioApoyo::all();
            $secretarioApoyo = $secretarioApoyo[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with('msj', 'Primero hay que dar de alta al Secretario de Apoyo a la Docencia');    
        }try{
            $director = Director::all();
            $director = $director[0];
        }catch(\ErrorException  $e){
            return redirect()->back()->with('msj', 'Primero hay que dar de alta al Director');    
        }
        $idTipo = $curso->getTypeId();
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
        $dia_a = $fecha[0];
        $mes_a = $fecha[1];
        $folio_der = intval($request->folio_der);
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
        if($count == null){
            $zip::close();
            return redirect()->back()->with('msj', 'No hay profesores asignados para dicho curso');
        }
        $iter = 1;
        $ceros = "000";
        foreach($profesores as $profesor){
            if($iter > 9 ){ $ceros = "00";}
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
                    'folio'=>$folio.$idTipo."R".$ceros.$iter,
                    'folio_der'=>strval($folio_der),
                    "tema" => $request->texto_personalizado))
                ->setPaper('letter', 'landscape');
            $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
            $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
            $iter++;
            $folio_der++;
        }
        $zip::close();
        return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
    }
    public function generar(Request $request)
    {
        $zip = new Zipper();
        $zip::make(public_path('reconocimientos.zip'));
        $count = ProfesoresCurso::select('id')
        ->where('curso_id',$request->id)
        ->count();
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
        $curso = Curso::findOrFail($request->id);
        
        
        $idTipo = $curso->getTypeId();
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
        $dia_a = $fecha[0];
        $mes_a = $fecha[1];
        $folio_der = intval($request->folio_der);
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
        if($count == null){
            $zip::close();
            return redirect()->back()->with('msj', 'No hay profesores asignados para dicho curso');
        }
    try{
        
        if ($tipo == "T" || $tipo == "C" || $tipo == "CT"){
              $iter = 1;
              $ceros = "000";
              foreach($profesores as $profesor){
                  if($iter>9){
                      $ceros = "00";
                  }
                    $pdf = PDF::loadView(
                        'pages.pdf.reconocimientoCTTC', 
                        array('curso' => $curso,
                            'profesor'=>$profesor,
                            'cursoCatalogo' => $cursoCatalogo,
                            'fecha'=>$fecha, 
                            'coordinadorGeneral'=>$coordinadorGeneral, 
                            'fechaimp'=>$fechaimp,
                            'coordinacion'=>$coordinacion,
                            'folio'=>$folio.$idTipo."R".$ceros.$iter,
                            'folio_der'=>strval($folio_der)))
                        ->setPaper('letter', 'landscape');

                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
                $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                $iter++;
                $folio_der++;
            }
            $zip::close();
            return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
        }elseif($tipo == "E"){
            $iter = 1;
            $ceros = "000";
            foreach($profesores as $profesor){
                if($iter >9 ){ $ceros = "00";}
                $pdf = PDF::loadView('pages.pdf.reconocimientoE', 
                    array('curso' => $curso,
                        'profesor'=>$profesor,
                        'cursoCatalogo' => $cursoCatalogo,
                        'fecha'=>$fecha, 
                        'coordinadorGeneral'=>$coordinadorGeneral, 
                        'fechaimp'=>$fechaimp,
                        'coordinacion'=>$coordinacion,
                        'secretarioApoyo' =>$secretarioApoyo,
                        'folio'=>$folio.$idTipo."R".$ceros.$iter,
                        'folio_der'=>strval($folio_der),
                        "tema" => $request->texto_personalizado))
                    ->setPaper('letter', 'landscape');
                $nombreArchivo = 'a' . $profesor->nombres . '.pdf';
                $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
                $iter++;
                $folio_der++;
            }
            $zip::close();
            return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
        }elseif($tipo == "S"){
          $tsprofes = TemaSeminarioProfesor::where('curso_id', $curso->id)
            ->get();
          foreach($tsprofes as $tsp){
            $profesor=$tsp->getProfesor();
            $tema=$tsp->getTema();
            $pdf = PDF::loadView('pages.pdf.reconocimientoS', 
              array('curso' => $curso,
              'profesor'=>$profesor,
              'cursoCatalogo' => $cursoCatalogo,
              'fecha'=>$fecha, 
              'coordinadorGeneral'=>$coordinadorGeneral, 
              'fechaimp'=>$fechaimp,
              'coordinacion'=>$coordinacion,
              'duracion'=>$tema->duracion,
              'tema' => $tema->nombre))
                  ->setPaper('letter', 'landscape');
              $nombreArchivo = 'a' . $profesor->nombres.$tema->id . '.pdf';
              $zip::addString($nombreArchivo,$pdf->download($nombreArchivo));
          }
          $zip::close();
          return response()->download(public_path('reconocimientos.zip'))->deleteFileAfterSend(public_path('reconocimientos.zip'));
        }
        else{
            return "Error en el tipo";
        }
    }catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException  $e){
        return redirect()->back()->with('msj', 'Error');    } 
         
    }//End Funcion 

}//End Clase
