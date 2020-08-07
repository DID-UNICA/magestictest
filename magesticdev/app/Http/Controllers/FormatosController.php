<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Curso;
use App\CatalogoCurso;
use App\Profesor;
use App\Coordinacion;
use Carbon\Carbon;
use App\Salon;
use App\Exports\AllCursosExport;
class FormatosController extends Controller
{
    public function generarreporte(Request $request){
        $anio = $request->anio3;
        $si = $request->IO2;
        $pi = $request->Sem2;
        $periodo = $anio.'-'.$pi.$si;

        if ($request->type2 == 'excel'){
            return (new AllCursosExport)->download('cursos.xlsx');
        }
        elseif ($request->type2 == 'sugerencia'){
            $coordinaciones = Coordinacion::all();
            $cursos = Curso::all()
                ->where('semestre_anio', $anio)
                ->where('semestre_pi', $pi)
                ->where('semestre_si', $si);
            $datos = array(
                'periodo'=>$periodo, 
                'coordinaciones'=>$coordinaciones,
                'cursos'=>$cursos);
            $pdf = PDF::loadView('pages.pdf.reportecomentarios', $datos)
                ->setPaper('letter');
            return $pdf->download('Reporte-Comentarios'.$periodo.'.pdf'); 

        }
        elseif ($request->type2 == 'periodo'){
            $cursos = Curso::all()
                ->where('semestre_anio', $anio)
                ->where('semestre_pi', $pi)
                ->where('semestre_si', $si);
            foreach($cursos as $curso){
                if ($curso->getTipo() == 'C'){
                    $curso->leyenda = 'por haber acreditado el curso';
                }
                elseif ($curso->getTipo() == 'T'){
                    $curso->leyenda = 'por haber acreditado el taller';
                }
                elseif ($curso->getTipo() == 'CT'){
                    $curso->leyenda = 'por haber acreditado el curso-taller';
                }
                elseif ($curso->getTipo() == 'S'){
                    $curso->leyenda = 'por haber acreditado el seminario';
                }
                elseif ($curso->getTipo() == 'E'){
                    $curso->leyenda = 'por haber asistido a ';
                }
                elseif ($curso->getTipo() == 'D'){
                    $curso->leyenda = 'por haber acreditado el ';
                }
            }
            $datos = array('periodo'=>$periodo, 'cursos'=>$cursos);
            $pdf = PDF::loadView('pages.pdf.reportecursosperiodo', $datos)
                ->setPaper('letter');
            return $pdf->download('Reporte'.$periodo.'.pdf'); 
        }
    }
    public function sendPDF($id,$tipoDeConstancia){
        $curso = Curso::findOrFail($id);
        $cursoCatalogo = CatalogoCurso::findOrFail($curso->catalogo_id);
        $coordinacion=Coordinacion::findOrFail($cursoCatalogo->coordinacion_id);
        $profesor = $curso->getProfesores();
        $salon=Salon::findOrFail($curso->salon_id);
        $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y');
        $fechaimp = $curso->getFecha();

        $participantes = Profesor::leftJoin('participante_curso','profesors.id','=','participante_curso.profesor_id')
            ->where('participante_curso.curso_id',$id)
            ->select('profesors.*', 'participante_curso.cancelación', 'participante_curso.espera')->get();

        $participantes = $participantes->sortBy(function($user){
                return $user->apellido_paterno;
            });
        $tipo=$cursoCatalogo->tipo;

        if( $cursoCatalogo->tipo == "C"){
            $tipo="Curso";
        } elseif ($cursoCatalogo->tipo == "S"){
            $tipo="Seminario";
        }elseif($cursoCatalogo->tipo == "T"){
            $tipo="Taller";
        }elseif($cursoCatalogo->tipo == "CT"){
            $tipo="Curso-Taller";
        }elseif($cursoCatalogo->tipo == "E"){
            $tipo="Evento";
        }

        $datos = array('curso' => $curso,'profesor'=>$profesor,'cursoCatalogo' => $cursoCatalogo,'coordinacion'=>$coordinacion,'fecha'=>$fecha,'fechaimp'=>$fechaimp, 'salon'=>$salon, 'participantes' => $participantes,'tipo' => $tipo);
        if ($tipoDeConstancia == "A"){
        //Lista de asistencia
            $pdf = PDF::loadView('pages.pdf.asistencia', $datos)->setPaper('a4', 'landscape');
            return $pdf->download($cursoCatalogo->nombre_curso .'Asistencia.pdf'); 
        }elseif ($tipoDeConstancia == "B"){
        //Hoja de Verificación de Datos  
            $pdf = PDF::loadView('pages.pdf.formatos-HojaConfirmacion', $datos);
            return $pdf->download($cursoCatalogo->nombre_curso . 'HojaVerificacionDatos.pdf');
        }elseif ($tipoDeConstancia == "B1"){
        //Hoja de Verificación de Datos con Lista de espera
                $datos_verificacion = array('curso' => $curso,'profesor'=>$profesor,'cursoCatalogo' => $cursoCatalogo,'coordinacion'=>$coordinacion,'fecha'=>$fecha, 'fechaimp'=>$fechaimp, 'salon'=>$salon, 'participantes' => $participantes,'tipo' => $tipo);    
                $pdf = PDF::loadView('pages.pdf.formatos-VerfDatosLS', $datos_verificacion)->setPaper('letter');
                return $pdf->download($cursoCatalogo->nombre_curso . 'VerificacionDatos.pdf');
        } elseif ($tipoDeConstancia == "B2"){
            $interesados = $curso->getInteresados();
            $datos = array(
                'curso' => $curso,
                'interesados'=> $interesados);
            $pdf = PDF::loadView('pages.pdf.correospersonalizados', $datos)
                ->setPaper('letter');
            return $pdf->download("CorreosPersonalizados".$curso->id.".pdf");
        } elseif ($tipoDeConstancia == "C"){ 
        //Identificadores Grandes
            $pdf = PDF::loadView('pages.pdf.formatos-identificadores', $datos);
            return $pdf->download($cursoCatalogo->nombre_curso . 'Identificadores.pdf'); 
        } elseif ($tipoDeConstancia == "C1"){ 
        //Identificadores Pequeños
            $pdf = PDF::loadView('pages.pdf.formatos-identificadoresPequeños', $datos);
            return $pdf->download($cursoCatalogo->nombre_curso . 'Identificadores.pdf'); 
        }
        elseif ($tipoDeConstancia == "D"){ 
        //Publicidad
                $pdf = PDF::loadView('pages.pdf.publicidadinternet', $datos);
                return $pdf->download($cursoCatalogo->nombre_curso . 'Publicidad.pdf'); 
            }   
    }
}