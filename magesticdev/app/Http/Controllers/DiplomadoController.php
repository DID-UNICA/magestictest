<?php

namespace App\Http\Controllers;

use App\Diplomado;
use App\Curso;
use App\DiplomadosCurso;
use App\DiplomadosProfesor;
use App\ParticipantesCurso;
use App\Profesor;
use App\CatalogoCurso;

use Illuminate\Http\Request;
use Session;

class DiplomadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $diplomados = Diplomado::all();

        return view("pages.consulta-diplomados")
            ->with("diplomados",$diplomados);    
    }
    public function nuevo()
    {
        $cursos = Curso::all();
        $catCursos = CatalogoCurso::all();
        return view("pages.alta-diplomado")
            ->with("catCursos",$catCursos)
            ->with("cursos",$cursos);
    }

    public function show($id){
        $diplomado = Diplomado::find($id);
        return view("pages.ver-diplomado")
            ->with("diplomado",$diplomado);
    }

    public function edit($id){
        $diplomado = Diplomado::find($id);
        return view("pages.update-diplomado")
            ->with("diplomado",$diplomado);
    }

    public function create(Request $request)
    {
        $diplomado = new Diplomado;
        $diplomado->nombre_diplomado = $request->nombre;
        $diplomado->cupo_maximo = $request->cupo_max;
        $diplomado->save();
        return redirect()->back()->with('success', 'El diplomado: '.$diplomado->nombre_diplomado.' ha sido dado de alta exitosamente');
    }
    public function verDiplomado($id)
    {
        $diplomado = Diplomado::findOrFail($id);

        $diplomadosCurso = DiplomadosCurso::where('diplomado_id',$id)->get();

        $cursos = array();
        foreach($diplomadosCurso as $diplomadoCurso){
            $curso = Curso::find($diplomadoCurso->curso_id);
            array_push($cursos,$curso);
        }
   
        return view("pages.ver-diplomado")
            ->with("diplomado",$diplomado)
            ->with("cursos",$cursos);
    }

    public function verCursosDiplomado($id)
    {
        $diplomado = Diplomado::findOrFail($id);
        $diplomadosCurso = DiplomadosCurso::where('diplomado_id',$id)->get();
        $cursos = array();
        foreach($diplomadosCurso as $diplomadoCurso){
            $curso = Curso::find($diplomadoCurso->curso_id);
            array_push($cursos,$curso);
        }
   
        //return view("pages.ver-diplomado")
        return view("pages.ver-cursos-diplomado")
            ->with("diplomado",$diplomado)
            ->with("cursos",$cursos);
    }

    public function verParticipantesDiplomado($id)
    {
        $diplomado = Diplomado::findOrFail($id);
        $displomadosParticipantes = DiplomadosProfesor::join('profesors', 'profesors.id', 'profesor_id')->where('diplomado_id',$id)->orderBy('apellido_paterno')->orderBy('apellido_materno')->get();
        $profesores = array();
        foreach($displomadosParticipantes as $displomadosParticipante){
            array_push($profesores,Profesor::find($displomadosParticipante->profesor_id));
        }
        return view("pages.ver-profesores-diplomado")
            ->with("diplomado",$diplomado)
            ->with("profesores",$profesores);
    }
    public function delete($id)
    {   
        try {
                $diplomado = Diplomado::findOrFail($id);

                $diplomadosCursos = DiplomadosCurso::where('diplomado_id',$diplomado->id)->get();
                $diplomadosProfesores = DiplomadosProfesor::where('diplomado_id',$diplomado->id)->get();
                foreach($diplomadosCursos as $diplomadosCurso){
                    $curso = Curso::find($diplomadosCurso->id);
                    foreach($diplomadosProfesores as $diplomadosProfesor){
                        $profesor = Profesor::find($diplomadosProfesor->id);
                        $participanteCurso = ParticipantesCurso::where('curso_id',$curso->id)->where('profesor_id',$profesor->id)->get();
                        $participanteCurso->delete();
                        $diplomadosProfesor->delete();
                    }
                    $diplomadosCurso->delete();
                }



                $diplomado -> delete();
                return redirect('/diplomado');

            }catch (\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('danger', 'El curso no puede ser eliminado porque tiene alumnos inscritos.');
            }
    }



    public function descartarCurso($diplomado_id, $curso_id){
        $curso = Curso::where('id',$curso_id)->get();
        $curso = $curso[0];
        //return $curso;
        $diplomado = Diplomado::where('id',$diplomado_id)->get();
        $diplomado = $diplomado[0];
        //return $diplomado;
        $diplomadoCursos = DiplomadosCurso::where('diplomado_id',$diplomado->id)->where('curso_id',$curso->id)->get();
        $diplomadoCursos[0] -> delete();
        
        //Hay que actualizar los números de módulo
        $diplomadoCursos = DiplomadosCurso::where('diplomado_id',$diplomado->id)->get();
        if(!$diplomadoCursos->isEmpty()){
            $diplomadoCursos -> sortBy('num_modulo');
            $num_modulo = 1;
            foreach($diplomadoCursos as $modulo){
                if ($modulo->num_modulo != $num_modulo) {
                    $modulo->num_modulo = $num_modulo;
                    $modulo->save();
                }
            $num_modulo++;
            }
        }
        ParticipantesCurso::where('curso_id', '=', $curso_id)->delete();
        return redirect()->back()->with('success', 'El curso ha sido descartado del diplomado '.$diplomado->nombre_diplomado.' exitosamente.');
    }

    public function descartarParticipante($diplomado_id, $profesor_id){
        $profesor = Profesor::where('id',$profesor_id)->get();
        $profesor=$profesor[0];
        //return $curso;
        $diplomado = Diplomado::where('id',$diplomado_id)->get();
        $diplomado=$diplomado[0];
        //return $diplomado;
        $diplomadoProfesor = DiplomadosProfesor::where('diplomado_id',$diplomado->id)->where('profesor_id',$profesor->id)->get();
        $diplomadoProfesor=$diplomadoProfesor[0];
        $diplomadoProfesor -> delete();

        $diplomadosCursos = DiplomadosCurso::where('diplomado_id',$diplomado->id)->get();
        //return $diplomadosCursos;
        foreach($diplomadosCursos as $diplomadosCurso){
            $curso = Curso::find($diplomadosCurso->curso_id);
            $participanteCurso = ParticipantesCurso::where('profesor_id',$profesor->id)
            ->where('curso_id',$curso->id)
            ->delete();
        }
        return redirect()->back()->with('success', 'El profesor ha sido descartado del diplomado '.$diplomado->nombre_diplomado.' exitosamente y de todos los cursos que lo conforman.');
    }

    public function añadirCursos($id){
        $diplomado = Diplomado::where('id',$id)->get();
        $diplomado = $diplomado[0];
        $cursosDip = DiplomadosCurso::where('diplomado_id', $id)->select('curso_id')->get();
        $cursDip = array();
        foreach ($cursosDip as $value) {
            array_push($cursDip,$value->curso_id);
        }
        $temporales = Curso::whereNotIn('id', $cursDip)->get();
        $cursos = array();
        foreach($temporales as $curso){
            if ($curso->getTipo() == 'D'){
                array_push($cursos,$curso);
            }
        }
        $catCursos = CatalogoCurso::all()
        ->where('tipo','D');
        //Añadir filtros para solo mandar cursos que no estén ya estén inscritos
        return view("pages.diplomado-añadirCursos")
            ->with("cursos",$cursos)
            ->with("catCursos",$catCursos)
            ->with("id",$id);
    }

    public function addCursos(Request $request){
        //Para insertar el número de módulo
        $dipCursos = DiplomadosCurso::where('diplomado_id', $request->diplomado)->get();
        if($dipCursos->isEmpty()){ 
            $num_modulo = 1;
        }
        else{
            $dipCursos->sortByDesc('num_modulo');
            $num_modulo = intval($dipCursos[0]->num_modulo)+1;
        } 
        foreach ($request->curso_id as $key => $value) {
            $dipCursos = new DiplomadosCurso;
            $dipCursos->diplomado_id = $request->diplomado;
            $dipCursos->curso_id = $value;
            $dipCursos->num_modulo = $num_modulo;
            $dipCursos->save();
            $participantes = DiplomadosProfesor::where('diplomado_id', $request->diplomado)->get();
            foreach ($participantes as $participante) {
                $pcurso = new ParticipantesCurso;
                $pcurso->profesor_id = $participante->profesor_id;
                $pcurso->curso_id = $value;
                $pcurso->save();
            }
            $num_modulo++;
        }
        return redirect()->back()->with('success', 'El diplomado ha sido actualizado exitosamente');
    }

    public function update(Request $request, $id){
        $diplomado = Diplomado::findOrFail($id);
        $diplomado->nombre_diplomado = $request->nombre;
        $diplomado->cupo_maximo = $request->cupo_maximo;
        $diplomado->save();
        return redirect()->back()->with('success', 'El diplomado ha sido actualizado exitosamente');
    }

    public function inscribirAlumnos($id){
        $diplomado = Diplomado::find($id);

        $count = DiplomadosProfesor::select('id')
            ->where('diplomado_id',$diplomado->id)
            ->count();

        $cupo = $diplomado->cupo_maximo;

        $profesores = Profesor::select('*')
            ->whereNotIn('id',Profesor::join('diplomado_profesor','diplomado_profesor.profesor_id','profesors.id')
                ->where('diplomado_profesor.diplomado_id',$diplomado->id)
                ->select('profesors.id')->get())
            ->get();
        return view("pages.diplomado-inscribirAlumnos")
            ->with("count",$count)
            ->with("cupo",$cupo)
            ->with("profesores",$profesores)
            ->with("diplomado",$diplomado);
    }
    public function buscarCandidatos(Request $request)
    {
        $inscritos = Profesor::join('diplomado_profesor','diplomado_profesor.profesor_id','profesors.id')
                ->where('diplomado_profesor.diplomado_id', '=', $request->diplomado_id)
                ->select('profesors.id')->get();
        $diplomado = Diplomado::findOrFail($request->diplomado_id);

        if($request->type == "nombre")
        {
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('id',$inscritos)->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('id',$inscritos)->orWhereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('id',$inscritos)->orWhereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('id',$inscritos)->get();

            }
            return view("pages.diplomado-inscribirAlumnos")
                ->with("profesores",$users)->with("count", $request->count)->with("cupo", $request->cupo)->with("diplomado",$diplomado);

        }elseif($request->type == "correo"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('id',$inscritos)->whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
                    ->get();
            }
            return view("pages.diplomado-inscribirAlumnos")
                ->with("profesores",$users)->with("count", $request->count)->with("cupo", $request->cupo)->with("diplomado",$diplomado);
        }elseif($request->type == "rfc"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('id',$inscritos)->whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
                ->get();
            }
            return view("pages.diplomado-inscribirAlumnos")
                ->with("profesores",$users)->with("count", $request->count)->with("cupo", $request->cupo)->with("diplomado",$diplomado);
        }elseif($request->type == "num"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('id',$inscritos)->whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
                ->get();
            }
            return view("pages.diplomado-inscribirAlumnos")
                ->with("profesores",$users)->with("count", $request->count)->with("cupo", $request->cupo)->with("diplomado",$diplomado);
        }
        $users = Profesor::all();
        return view("pages.diplomado-inscribirAlumnos")
                ->with("profesores",$users)->with("count", $request->count)->with("cupo", $request->cupo)->with("diplomado",$diplomado);

    }

public function registrarParticipante(Request $request){
        $diplomado = Diplomado::find($request->diplomado_id);

        //return $request->diplomado_id;
        //return $request->profesor_id;
        $count = DiplomadosProfesor::select('id')
            ->where('diplomado_id',$diplomado->id)
            ->count();
        //Queda pendiente el registro
        $cupo = $diplomado->cupo_maximo;

        $diplomadoCursos = DiplomadosCurso::where('diplomado_id',$diplomado->id)->get();

        if($count < $cupo){

            $diplomadoProfesor = new DiplomadosProfesor;
            $diplomadoProfesor->diplomado_id = $request->diplomado_id;
            $diplomadoProfesor->profesor_id = $request->profesor_id;
            $diplomadoProfesor->save();
            $inscripciones="";
            foreach($diplomadoCursos as $diplomadoCurso){
                //Revisa si el alumno ya está inscrito
                $tmp = ParticipantesCurso::where('profesor_id',$request->profesor_id)->where('curso_id',$diplomadoCurso->curso_id)->get();
                if(count($tmp)>0){
                    continue;
                }
                $participanteCurso = new ParticipantesCurso;
                $participanteCurso->curso_id = $diplomadoCurso->curso_id;
                $participanteCurso->profesor_id = $request->profesor_id;
                //$inscripciones.=$participanteCurso->curso_id.$participanteCurso->profesor_id."   ";
                $participanteCurso->save();
            }
            //return $inscripciones;


            return redirect()->route("diplomado.inscribirAlumnos",$request->diplomado_id)->with('success', 'El alumno ha sido dado de alta en el diplomado y todos los cursos que le conforman exitosamente');
        }else{
            return redirect()->route("diplomado.inscribirAlumnos",$request->diplomado_id)->with('danger', 'El alumno no puede darse de alta debido a que el cupo ha sido llenado');
        }

    }


}