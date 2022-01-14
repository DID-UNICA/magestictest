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
        $registro = array(
          'clave' => $catalogo->clave_curso,
          'nombrec' => $catalogo->nombre_curso,
          'duracion' => $catalogo->duracion_curso,
          'semestre' => $curso->getSemestre(),
          'fecha_inicio' => $curso->getFechaInicio(),
          'fecha_fin' => $curso->getFechaFin(),
          'rfc' => $profesor->rfc,
          'nombre' => $profesor->getNombres2(),
          'categoria' => $profesor->getCatAbr(),
          'confirmacion' => $participante->confirmacion,
          'asistencia' => $participante->asistencia,
          'acreditacion' => $participante->acreditacion,
          'causa' => $participante->causa_no_acreditacion,
          'cancelacion' => $participante->cancelacion,
          'lista' => $participante->estuvo_en_lista,
          'num_lista' => $participante->espera,
          'calificacion' => $participante->calificacion,
          'folio_inst' => $participante->folio_inst,
          'folio_peque' => $participante->folio_peque,
          'division' => $profesor->getDivisionAbr(),
          'email' => $profesor->email,
          'telefono' => $profesor->telefono,
          'edad' => $profesor->getEdad()
        );
        //Arreglo
        array_push($registros, $registro);
      }
      return view('exports.todoscursos', ['registros'=>$registros]);
    }
}
      /*
            $registros = DB::table('participante_curso AS pc')
            ->join('cursos AS c', 'pc.curso_id', '=', 'c.id')
            ->join('profesors AS p', 'p.id','=','pc.profesor_id')
            ->join('catalogo_cursos AS ct','c.catalogo_id','=','ct.id')
            ->leftjoin('categoria_nivel AS cn','cn.id','=','p.categoria_nivel_id')
            
            //->join('carreras AS cr','cr.id','=','p.carrera_id')
            //->join('divisions AS d','d.id','=','cr.id_division')
            ->select('ct.clave_curso AS clave', 
            'c.semestre_anio','c.semestre_pi','c.semestre_si',
            'p.rfc AS rfc', 'p.id AS profesor_id',
            'p.nombres', 'p.apellido_paterno', 'p.apellido_materno',
            'cn.abreviatura AS categoria',
            'ct.nombre_curso AS nombrec',
            'ct.duracion_curso AS duracion',
            'c.fecha_inicio AS fecha_inicio',
            'c.fecha_fin AS fecha_fin',
            'pc.confirmacion AS confirmacion',
            'pc.asistencia AS asistencia',
            'pc.acreditacion AS acreditacion',
            'pc.causa_no_acreditacion AS causa',
            'pc.cancelacion AS cancelacion',
            'pc.estuvo_en_lista AS lista',
            'pc.espera AS num_lista',
            'pc.calificacion AS calificacion',
            'p.email AS email',
            'p.telefono AS telefono',
            'p.fecha_nacimiento AS nacimiento',
            'pc.folio_inst as folio_inst',
            'pc.folio_peque as folio_peque')->get();

            foreach($registros as $renglon){
                $renglon->nombre = $renglon->nombres.' '.$renglon->apellido_paterno.' '.$renglon->apellido_materno;
                $renglon->semestre = $renglon->semestre_anio.'-'.$renglon->semestre_pi.$renglon->semestre_si;
                $nacimiento = $renglon->nacimiento;
                $renglon->edad = Carbon::parse($nacimiento)->age;
                $divisiones = DB::table('profesores_divisiones AS pd')
                  ->join('divisions AS d', 'pd.id_division', '=', 'd.id')
                  ->select('d.nombre')
                  ->where('pd.id_profesor', '=', $renglon->profesor_id)->get();
                $div_nombre = '';
                foreach($divisiones as $index => $division){
                  if($index == 0)
                    $div_nombre = $division->nombre;
                  else
                    $div_nombre = $division->nombre.', '.$div_nombre;
                }
                $renglon->division = $div_nombre;
            }
          */
 