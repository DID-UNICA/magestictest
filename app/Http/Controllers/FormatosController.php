<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Curso;
use App\CatalogoCurso;
use App\ParticipantesCurso;
use App\Profesor;
use App\Coordinacion;
use Carbon\Carbon;
use App\Salon;
use App\HistoricoTematicas;
use App\Exports\AllCursosExport;
use App\Exports\AllCursosPartialExport;
use Dompdf;
class FormatosController extends Controller
{
    public function generarreporte(Request $request){
        $anio = $request->anio3;
        $si = $request->IO2;
        $pi = $request->Sem2;
        $periodo = $anio.'-'.$pi.$si;

        if ($request->type2 == 'excel'){
            return (new AllCursosExport)->download('reporte_completo.xlsx');
        }elseif($request->type2 == 'excel2'){
            return (new AllCursosPartialExport)->download('reporte_parcial.xlsx');
        }elseif ($request->type2 == 'sugerencia'){
          
          $coordinaciones = Coordinacion::where('nombre_coordinacion','<>', 'Coordinación Del Centro de Docencia')
            ->select('id as coord_id','nombre_coordinacion')
            ->get();
          foreach($coordinaciones as $coordinacion){
            $coordinacion->cursos = DB::table('catalogo_cursos as cc')
              ->join('cursos as c', 'c.catalogo_id', '=', 'cc.id')
              ->where('cc.coordinacion_id', $coordinacion->coord_id)
              ->where('c.semestre_anio', $anio)
              ->where('c.semestre_pi', $pi)
              ->where('c.semestre_si', $si)
              ->select('c.id as curso_id', 'cc.nombre_curso')
              ->get();
            foreach($coordinacion->cursos as $curso){
              $curso->sugerencias = DB::table('participante_curso as pc')
                ->join('profesors as p', 'pc.profesor_id', '=', 'p.id')
                ->join('_evaluacion_final_curso as e', 'e.participante_curso_id', '=', 'pc.id')
                ->where('pc.curso_id', $curso->curso_id)
                ->where('e.sug', 'not like', 'Ninguna')
                ->where('e.sug', 'not like', 'En blanco')
                ->select('p.nombres', 'p.apellido_paterno', 'p.apellido_materno', 'e.sug')
                ->get();
            }
          }
            $datos = array(
                'periodo'=>$periodo, 
                'coordinaciones'=>$coordinaciones
            );
            $pdf = PDF::loadView('pages.pdf.reportecomentarios', $datos)
                ->setPaper('letter');
            return $pdf->download('Reporte-Comentarios'.$periodo.'.pdf'); 
        }elseif ($request->type2 == 'periodo'){
            $cursos = Curso::all()
            ->where('semestre_anio', $anio)
            ->where('semestre_pi', $pi)
            ->where('semestre_si', $si);
            foreach($cursos as $curso){
                if ($curso->getTipo() == 'C'){
                    $curso->leyenda = 'por haber acreditado el curso';
                }elseif ($curso->getTipo() == 'T'){
                    $curso->leyenda = 'por haber acreditado el taller';
                }elseif ($curso->getTipo() == 'F'){
                    $curso->leyenda = 'por haber acreditado el foro';
                }elseif ($curso->getTipo() == 'CT'){
                    $curso->leyenda = 'por haber acreditado el curso-taller';
                }elseif ($curso->getTipo() == 'S'){
                    $curso->leyenda = 'por haber acreditado el seminario';
                }elseif ($curso->getTipo() == 'E'){
                    $curso->leyenda = 'por haber asistido a ';
                }elseif ($curso->getTipo() == 'D'){
                    $curso->leyenda = 'por haber acreditado el ';
                }
            }
            $datos = array('periodo'=>$periodo, 'cursos'=>$cursos);
            $pdf = PDF::loadView('pages.pdf.reportecursosperiodo', $datos)
            ->setPaper('letter');
            return $pdf->download('Reporte'.$periodo.'.pdf'); 
        }elseif ($request->type2 == 'historico'){
            $path=public_path('hist/access.xlsx');
            return response()->download($path);
        }
    }
  
    //Correos personalizados
  public function generarCorreosPer(Request $request, $id){
      $curso = Curso::findOrFail($id);
      $str_tematicas = '';
      $tematicas = preg_split("/#/", $request->words);
        unset($tematicas[0]);
      if(empty($tematicas))
        return redirect()->back()->with('danger', 'ERROR: Recuerde que cada palabra debe comenzar con #');
      $tematicas = str_replace(' ', '', $tematicas);
      foreach($tematicas as $index => $tematica)
        if($index === 1)
            $str_tematicas = $tematica;
        else
            $str_tematicas = $str_tematicas . ', '.$tematica;
      $interesados = $curso->getInteresados($tematicas);
      if(($interesados[0] === 0 && $interesados[1] === 0) || $interesados == 0)
        return redirect()->back()->with('info', 'No hubo interesados con esas temáticas.');
      //Deshacemos colección
      if($interesados[0] !== 0){
            $new_interesados = array(); 
            foreach($interesados[0] as $interesados_curso){
            foreach($interesados_curso as $interesado){
                array_push($new_interesados, $interesado->id);
              }
            }
            //Eliminamos duplicados
            $arrUnicos = array_count_values($new_interesados);
            $arrPreFinal=array();
            foreach ($arrUnicos  as $key => $value)  {
              array_push($arrPreFinal, $key);
            }
            //Obtenemos a los interesados finalmente
            $arrayFinal = array();
            foreach($arrPreFinal as $inter){
              $participante = ParticipantesCurso::findOrFail($inter);
              array_push($arrayFinal, $participante);
            }
        }
        if($interesados[1] !== 0){
            $new_interesados = array();
            foreach($interesados[1] as $interesados_curso){
            foreach($interesados_curso as $interesado){
                array_push($new_interesados, $interesado->id);
              }
            }
            //Eliminamos duplicados
            $arrUnicos = array_count_values($new_interesados);
            $arrPreFinal=array();
            foreach ($arrUnicos  as $key => $value)  {
              array_push($arrPreFinal, $key);
            }
            //Obtenemos a los interesados finalmente
            foreach($arrPreFinal as $inter){
              $participante = HistoricoTematicas::findOrFail($inter);
              array_push($arrayFinal, $participante);
            }
        }
      $datos = array(
          'curso' => $curso,
          'interesados'=> $arrayFinal,
          'tematicas'=> $str_tematicas);
      $pdf = PDF::loadView(
          'pages.pdf.correospersonalizados', $datos
      )->setPaper('letter');
      return $pdf->download(
          "CorreosPersonalizados".$curso->id.".pdf"
      ); 
    }
    public function sendPDF($id,$formato){
        $curso = Curso::findOrFail($id);
        $cursoCatalogo = CatalogoCurso::findOrFail($curso->catalogo_id);
        $coordinacion=Coordinacion::findOrFail(
            $cursoCatalogo->coordinacion_id
        );
        $profesor = $curso->getProfesores();
        $salon=Salon::findOrFail($curso->salon_id);
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y');
        $fechaimp = $curso->getFecha_sinLeyenda();
        $participantes = Profesor::leftJoin(
            'participante_curso','profesors.id',
            '=',
            'participante_curso.profesor_id'
        )->where('participante_curso.curso_id',$id)
        ->select('profesors.*', 'participante_curso.cancelacion', 
            'participante_curso.espera'
        )
        ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
        ->get();

        $tipo=$cursoCatalogo->tipo;

        if( $cursoCatalogo->tipo == "C"){
            $tipo="Curso";
        } elseif ($cursoCatalogo->tipo == "S"){
            $tipo="Seminario";
        }elseif($cursoCatalogo->tipo == "T"){
            $tipo="Taller";
        }elseif($cursoCatalogo->tipo == "F"){
            $tipo="Foro";
        }elseif($cursoCatalogo->tipo == "CT"){
            $tipo="Curso-Taller";
        }elseif($cursoCatalogo->tipo == "E"){
            $tipo="Evento";
        }
      elseif($cursoCatalogo->tipo == "D"){
        $tipo="Módulo Diplomado";
      }
        $datos = array(
            'curso' => $curso,
            'profesor' => $profesor,
            'cursoCatalogo' => $cursoCatalogo,
            'coordinacion' => $coordinacion,
            'fecha'=> $fecha,
            'fechaimp'=>$fechaimp,
            'salon'=>$salon,
            'participantes' => $participantes,
            'tipo' => $tipo,
            'total' => $participantes->count()
        );
        if ($formato == "A"){
        //Lista de asistencia
            $pdf = PDF::loadView(
                'pages.pdf.asistencia', $datos
            )->setPaper(
                'a4', 'landscape'
            );
            return $pdf->download(
                $cursoCatalogo->nombre_curso .'Asistencia.pdf'
            );
        }elseif ($formato == "B"){
        //Hoja de Verificación de Datos
            $pdf = PDF::loadView(
                'pages.pdf.formatos-HojaConfirmacion', $datos
            );
            return $pdf->download(
                $cursoCatalogo->nombre_curso.'HojaVerificacionDatos.pdf'
            );
        }elseif ($formato == "B1"){
        //Hoja de Verificación de Datos con Lista de espera
            $pdf = PDF::loadView(
                'pages.pdf.formatos-VerfDatosLS',
                $datos
            )->setPaper('letter');
            return $pdf->download(
                $cursoCatalogo->nombre_curso.'VerificacionDatos.pdf'
            );
          }elseif ($formato == "C"){ 
            //Identificadores Grandes
                $pdf = PDF::loadView(
                    'pages.pdf.formatos-identificadores', $datos
                )->setPaper('letter');
                return $pdf->download(
                    $cursoCatalogo->nombre_curso . 'Identificadores.pdf'
                );
        } elseif ($formato == "C1"){ 
        //Identificadores Pequeños
            $pdf = PDF::loadView(
                'pages.pdf.formatos-identificadoresPequeños', $datos
            )->setPaper('letter');
            return $pdf->download(
                $cursoCatalogo->nombre_curso . 'Identificadores.pdf'
            );
        }elseif ($formato == "D"){ 
        //Publicidad
            $pdf = PDF::loadView(
                'pages.pdf.publicidadinternet', $datos
            );
            return $pdf->download(
                $cursoCatalogo->nombre_curso . 'Publicidad.pdf'
            );
        }
    }
}