<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;
use App\ProfesoresCurso;
use App\CatalogoCurso;
use App\TemaSeminario;
use App\TemaSeminarioProfesor;
use App\Profesor;
use Session;

class TemaSeminarioProfesorController extends Controller
{
    
    public function index($curso_id){
        $curso = Curso::findOrFail($curso_id);
        $catalogo = CatalogoCurso::findOrFail($curso->catalogo_id);
        $profesores = Profesor::select('profesors.*')
            ->where('pc.curso_id', $curso_id)
            ->join('profesor_curso as pc', 'pc.profesor_id', '=', 'profesors.id')
            ->get();
        $tmp = array();
        foreach($profesores as $profesor){
            $tmp[$profesor->id]=$profesor->getNombres();
        }
        $profesores = $tmp;
        if(empty($profesores))
          return redirect()->back()->with('danger', 'Aún no hay instructores inscritos, primero asigne instructores');
        $temas = TemaSeminario::where('catalogo_id', $catalogo->id)
            ->get();
        return view('pages.asignar-temas-seminario')
            ->with('profesores',$profesores)
            ->with('temas',$temas)
            ->with('curso_id', $curso_id);
    }
    public function create($curso_id, Request $request){
        $clear = TemaSeminarioProfesor::where('curso_id', $curso_id)->get();
        if($clear->isNotEmpty()){
            foreach($clear as $borrar){
                $borrar->delete();
            }
        }
        $i = 0;
        $tema = "tema".strval($i);
        while(isset($request->$tema))
        {
            $profesor = "proft".strval($i);
            $temasp = new TemaSeminarioProfesor;
            $temasp->tema_id = $request->$tema;
            $temasp->profesor_id = $request->$profesor;
            $temasp->curso_id = $curso_id;
            $temasp->save();
            $i++;
            $tema="tema".$i;
        }
        Session::flash('create', 'Se ha creado el registro correctamente');
        return redirect()
            ->route('curso.consulta');
    }

    public function update($id, Request $request){
        $temasp = TemaSeminarioProfesor::find($id);
        $temasp->tema_id = $request->tema_id;
        $temasp->profesor_id = $request->profesor_id;
        $temasp->curso_id = $request->curso_id;
        $temasp->save();
    }

    public function delete(){
        $temasp = TemaSeminarioProfesor::findOrFail($id);
        $temasp->delete();
        return;
    }
}
