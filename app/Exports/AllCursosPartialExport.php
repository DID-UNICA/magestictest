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
  public function view(): View
  {
    $cursos = Curso::all();
    $usuarios = collect();
    foreach ($cursos as $curso) {
      $catalogo_curso = CatalogoCurso::find($curso->catalogo_id);
      $curso->nombre_catalogo = $catalogo_curso->nombre_curso;
      $curso->clave = $catalogo_curso->clave_curso;
      $curso->semiperiodo = $curso->getSemestre();
      $curso->emision = $catalogo_curso->institucion;
      $curso->instructores = ProfesoresCurso::where('curso_id', $curso->id)->get();
      $curso->participantes = ParticipantesCurso::where('curso_id', $curso->id)
        ->where('acreditacion', true)
        ->where('calificacion', '>=', $curso->acreditacion)
        ->get();
      $curso->fecha_envio_reconocimiento = $curso->getFechaEnvioReconocimiento();
      $curso->fecha_envio_constancia = $curso->getFechaEnvioConstancia();
      foreach ($curso->instructores as $instructor) {
        if ($instructor->profesor_id) {
          $profesor = Profesor::find($instructor->profesor_id);
          $instructor->ord = $profesor->getNombres();
          $instructor->carreras = $profesor->getCarrerasString();
          $instructor->nombre = $profesor->getFirmanteConstancia();
          $instructor->categoria = $profesor->getCategoria_1();
          $instructor->type = 'INSTRUCTOR';
          //TODO:El coordinador sera profesor ahora
        } else {
          $coord = $curso->getCoordinacion();
          $instructor->ord = $coord->coordinador;
          $instructor->nombre = $coord->getNombreFirma();
          $instructor->categoria = '';
          $instructor->type = 'COORDINADOR';
        }
        $instructor->clave = $curso->clave;
        $instructor->nombre_catalogo = $curso->nombre_catalogo;
        $instructor->fecha_inicio = $curso->getFechaInicio();
        $instructor->fecha_fin = $curso->getFechaFin();
        $instructor->semiperiodo = $curso->semiperiodo;
        $instructor->fecha_envio = $curso->fecha_envio_reconocimiento;
        $instructor->emision = $curso->emision;
        $instructor->semestre_anio = $curso->semestre_anio;
        $instructor->semestre_pi = $curso->semestre_pi;
        $instructor->semestre_si = $curso->semestre_si;
        $instructor->folio_inst_num = (int)$instructor->folio_inst;
      }
      foreach ($curso->participantes as $participante) {
        $profesor = Profesor::find($participante->profesor_id);
        $participante->nombre = $profesor->getNombres();
        $participante->categoria = $profesor->getCategoria_1();
        $participante->carreras = $profesor->getCarrerasString();
        $participante->clave = $curso->clave;
        $participante->nombre_catalogo = $curso->nombre_catalogo;
        $participante->fecha_inicio = $curso->getFechaInicio();
        $participante->fecha_fin = $curso->getFechaFin();
        $participante->semiperiodo = $curso->semiperiodo;
        $participante->fecha_envio = $curso->fecha_envio_constancia;
        $participante->emision = $curso->emision;
        $participante->ord = $participante->nombre;
        $participante->semestre_anio = $curso->semestre_anio;
        $participante->semestre_pi = $curso->semestre_pi;
        $participante->semestre_si = $curso->semestre_si;
        $participante->folio_inst_num = (int)$participante->folio_inst;
        $participante->type = 'PARTICIPANTE';
      }
      $usuarios = $usuarios->merge($curso->instructores->merge($curso->participantes));
    }

    $usuarios = $usuarios->sortBy(function ($registro, $key) {
      if ($registro['semestre_si'] === 's')
        $x = 1;
      if ($registro['semestre_si'] === 'i')
        $x = 2;
      if (is_null($registro['folio_inst']) or $registro['folio_inst'] === '' or $registro['folio_inst'] === ' ')
        return '2'.$registro['semestre_anio'] . $registro['semestre_pi'] . $x . $registro['nombre_catalogo'] . $registro['type'] . $registro['ord'];
      else
        return '1'.$registro['semestre_anio'] . $registro['semestre_pi'] .  $x . $registro['nombre_catalogo'] . $registro['type'] . $registro['folio_inst'] . $registro['ord'];
    }, SORT_NATURAL);
    return view('exports.libro_folios', ['usuarios' => $usuarios]);
  }
}
