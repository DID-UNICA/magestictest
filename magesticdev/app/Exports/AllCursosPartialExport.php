<?php

namespace App\Exports;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Exports\UsersExport;
use App\Curso;
use App\CatalogoCurso;
use App\Profesor;
use App\ProfesoresCurso;
use App\ParticipantesCurso;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AllCursosPartialExport implements FromView, ShouldAutosize
{
    use Exportable;
    public function view():View {   
      $cursos = Curso::all();
      //PRIMERO ENCONTRAR RECONOCIMIENTOS
      $registros = array();
      foreach($cursos as $curso){
        $catalogo_curso = CatalogoCurso::find($curso->catalogo_id);
        $instructores = ProfesoresCurso::where('curso_id',$curso->id)->get();
        foreach($instructores as $instructor){
          $profesor = Profesor::find($instructor->profesor_id);
          $fecha_envio = $curso->fecha_envio_reconocimiento;
          if($fecha_envio == "" or !$fecha_envio)
            $fecha_envio = $catalogo_curso->institucion;
          $tmp = array(
            'folio' => $instructor->folio_inst,
            'tipo' => 'INSTRUCTOR',
            'nombre' => $profesor->getFirmanteConstancia(),
            'curso' => $catalogo_curso->nombre_curso,
            'semiperiodo' => $curso->getSemestre(),
            'fecha_envio' => $fecha_envio,
            'emision' => $catalogo_curso->institucion
          );
          array_push($registros, $tmp);
        }
        $participantes = ParticipantesCurso::where('curso_id',$curso->id)->get();
        foreach($participantes as $participante){
          $profesor = Profesor::find($participante->profesor_id);
          $fecha_envio = $curso->fecha_envio_constancia;
          if($fecha_envio == "" or !$fecha_envio)
            $fecha_envio = $catalogo_curso->institucion;
          $tmp = array(
            'folio' => $participante->folio_inst,
            'tipo' => 'PARTICIPANTE',
            'nombre' => $profesor->getFirmanteConstancia(),
            'curso' => $catalogo_curso->nombre_curso,
            'semiperiodo' => $curso->getSemestre(),
            'fecha_envio' => $fecha_envio,
            'emision' => $catalogo_curso->institucion
          );
          array_push($registros, $tmp);
        }
      }
      return view('exports.libro_folios', ['registros'=>$registros]);
    }
}
