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
      foreach($cursos as $curso){
        $catalogo_curso = CatalogoCurso::find($curso->catalogo_id);
        $curso->nombre_catalogo = $catalogo_curso->nombre_curso;
        $curso->semiperiodo = $curso->getSemestre();
        $curso->emision = $catalogo_curso->institucion;
        $curso->instructores = ProfesoresCurso::where('curso_id', $curso->id)->get();
        $curso->participantes = ParticipantesCurso::where('curso_id',$curso->id)
          ->where('acreditacion',true)
          ->get();
        $curso->fecha_envio_reconocimiento = $curso->getFechaEnvioReconocimiento();
        $curso->fecha_envio_constancia = $curso->getFechaEnvioConstancia();
        foreach($curso->instructores as $instructor){
          $profesor = Profesor::find($instructor->profesor_id);
          $instructor->ord = $profesor->getNombres();
          $instructor->nombre = $profesor->getFirmanteConstancia();
        }
        foreach($curso->participantes as $participante){
          $participante->nombre = Profesor::find($participante->profesor_id)->getNombres();
        }
        $curso->instructores = $curso->instructores->sortBy(function ($registro, $key){
          return $registro['folio_inst'].$registro['ord'];
        } );
        $curso->participantes = $curso->participantes->sortBy(function ($registro, $key){
          return $registro['folio_inst'].$registro['nombre'];
        });
      }
      $cursos = $cursos->sortBy(function ($registro, $key){
        if($registro['semestre_si']==='s')
          $x = 1;
        if($registro['semestre_si']==='i')
          $x = 2;
        return $registro['semestre_anio'].$registro['semestre_pi'].$x;
      });
      return view('exports.libro_folios', ['cursos'=>$cursos]);
    }
}
