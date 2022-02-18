<?php

namespace App\Exports;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Salon;
use App\ProfesoresDivisiones;
use App\ParticipantesCurso;
use App\Exports\UsersExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AllCursosExport implements FromView, ShouldAutosize
{
    use Exportable;
    public function view():View {
      $registros = array();
      $participantes = ParticipantesCurso::all();
      foreach ($participantes as $participante){
        //Instancias
        $profesor = $participante->getProfesor();
        $curso = $participante->getCurso();
        $catalogo = $curso->getCatalogoCurso();
        
        //Datos
        $participante->semestre_anio = $curso->semestre_anio;
        $participante->semestre_pi = $curso->semestre_pi;
        $participante->semestre_si = $curso->semestre_si;
        $participante->clave = $catalogo->clave_curso;
        $participante->nombre_curso = $catalogo->nombre_curso;
        $participante->duracion = $catalogo->duracion_curso;
        $participante->fecha_inicio = $curso->getFechaInicio();
        $participante->fecha_fin = $curso->getFechaFin();
        $participante->rfc = $profesor->rfc;
        $participante->nombre = $profesor->getNombresNoAcento();
        $participante->categoria= $profesor->getCatAbr();
        $participante->division = $profesor->getDivisionAbr();
        $participante->email = $profesor->email;
        $participante->telefono = $profesor->telefono;
        $participante->edad = $profesor->getEdad();
      }
      $participantes = $participantes->sortBy(function ($registro, $key){
        if($registro['semestre_si']=='s')
          $x = 'a';
        if($registro['semestre_si']=='i')
          $x = 'b';
        return $registro['semestre_anio'].$registro['semestre_pi'].$x.$registro['clave'].$registro['nombre'];
      });
      return view('exports.todoscursos', ['registros'=>$participantes]);
    }
}