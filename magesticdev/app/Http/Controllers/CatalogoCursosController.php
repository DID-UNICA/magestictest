<?php

namespace App\Http\Controllers;

use App\Coordinacion;
use App\Curso;
use App\CatalogoCurso;
use App\TemaSeminario;
use App\Profesor;
use App\Consecuente;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class CatalogoCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $coordinaciones = Coordinacion::all();
        $users = CatalogoCurso::all();
        return view("pages.consulta-catalogo-cursos")
            ->with("coordinaciones",$coordinaciones)
            ->with("users",$users);


    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {
        $coordinaciones = Coordinacion::all();
        $catalogo_cursos = CatalogoCurso::all();
        $profesores = Profesor::all();

        return view("pages.alta-catalogo-cursos")
            ->with("catalogo_cursos",$catalogo_cursos)
            ->with("profesores",$profesores)
            ->with("coordinaciones",$coordinaciones);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = CatalogoCurso::find($id);
        return view("pages.ver-catalogo-cursos")
            ->with("user",$user);
    }


    public function edit($id)
    {
        $user = CatalogoCurso::find($id);
        $coordinaciones = Coordinacion::all(['id','nombre_coordinacion']);
        
        return view("pages.update-catalogo-cursos")
            ->with("user",$user)->with("coordinaciones",$coordinaciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = CatalogoCurso::find($id);
        $user->nombre_curso = $request->nombre_curso;
        $user->duracion_curso = $request->duracion_curso;
        $user->coordinacion_id = $request->coordinacion_id;
        $user->tipo = $request->tipo;
        $user->institucion = $request->institucion;
        $user->presentacion = $request->presentacion;
        $user->dirigido = $request->dirigido;
        $user->objetivo = $request->objetivo;
        $user->contenido = $request->contenido;
        $user->acreditacion = $request->acreditacion;
        $user->previo = $request->antesc;
        $user->evaluacion = $request->evaluacion;
        $user->bibliografia = $request->bibliografia;
        $user->fecha_disenio = $request->fecha_disenio;
        $user->clave_curso = $request->clave_curso;

        $user->save();
        $temas = TemaSeminario::where('catalogo_id', $user->id)->get();
        //El tipo se actualizó a seminario y hay que cambiar temas
        if($request->tipo == 'S'){
            return view("pages.update-temas-seminario")
                ->with('temas', $temas)
                ->with('num_temas', $request->num_temas)
                ->with('catalogo_id', $user->id);
        }
        //El tipo dejó de ser seminario y hay que eliminar todos sus temas
        if(!$temas->isEmpty()){
            foreach($temas as $tema){
                $tema->delete();
            }
        }
        return view("pages.ver-catalogo-cursos")
            ->with("user",$user)
            ->with('msj','Se han actualizado los cambios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->type == "nombre")
        {
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = CatalogoCurso::whereRaw("lower(unaccent(nombre_curso)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            return view("pages.consulta-catalogo-cursos")
            ->with("users",$users);

        $coordinaciones = Coordinacion::all();
        $users = CatalogoCurso::all();
        return view("pages.consulta-catalogo-cursos")
            ->with("coordinaciones",$coordinaciones)
            ->with("users",$users);

         }elseif($request->type == "clave"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = CatalogoCurso::whereRaw("lower(unaccent(clave_curso)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            return view("pages.consulta-catalogo-cursos")
            ->with("users",$users);
        }
        elseif($request->type == "coordinacion"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $aux = Coordinacion::select("id")->whereRaw("lower(unaccent(nombre_coordinacion)) ILIKE lower(unaccent('%".$word."%'))")
                ->get();
            }
            $aux2 = array();
                foreach ($aux as $value) {
                    array_push($aux2, $value->id);
                }
                $users = CatalogoCurso::whereIn("coordinacion_id", $aux2)->get();;
            return view("pages.consulta-catalogo-cursos")
            ->with("users",$users);
        }

        $coordinaciones = Coordinacion::all();
        $users = CatalogoCurso::all();
        return view("pages.consulta-catalogo-cursos")
            ->with("coordinaciones",$coordinaciones)
            ->with("users",$users);
    }

    public function delete($id)
    {
         try{
            $user = CatalogoCurso::findOrFail($id);
            $user -> delete();
            return redirect('/catalogo-cursos')->with('msj', 'Se ha dado de baja el curso del catálogo');
        }catch (\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('error', 'El catálogo de cursos no puede ser eliminado porque tiene cursos asignados.');
            }
    }

    public function create(Request $request)
    {
        $catalogos = CatalogoCurso::all();
        $catalogoCurso = new CatalogoCurso;
        $catalogoCurso->nombre_curso = $request->nombre_curso;

        foreach($catalogos as $catalogo){
            if($catalogo->nombre_curso == $catalogoCurso->nombre_curso){
                return back()->withError('El nombre '.$request->nombre_curso.' ya está en uso')->withInput();
            }
        }

        $catalogoCurso->duracion_curso = $request->duracion_curso;
        $catalogoCurso->coordinacion_id = $request->coordinacion_id;
        $catalogoCurso->tipo = $request->tipo;
        $catalogoCurso->institucion = $request->institucion;
        $catalogoCurso->presentacion = $request->presentacion;
        $catalogoCurso->dirigido = $request->dirigido;
        $catalogoCurso->objetivo = $request->objetivo;
        $catalogoCurso->contenido = $request->contenido;
        $catalogoCurso->acreditacion = $request->acreditacion;
        $catalogoCurso->previo = $request->antesc;
        $catalogoCurso->evaluacion = $request->evaluacion;
        $catalogoCurso->bibliografia = $request->bibliografia;
        $catalogoCurso->fecha_disenio = $request->fecha_disenio;
        $catalogoCurso->clave_curso = $request->clave_curso;
        try{
            $catalogoCurso->save();
        } catch(\Illuminate\Database\QueryException $e){
            return back()->withError('La clave '.$request->clave_curso.' ya está en uso')->withInput();
        }
        if($request->antescedente_id){
            foreach($request->antescedente_id as $antescedente_id){
                if ($antescedente_id != 'Otros') {
                    $consecuentes = new Consecuente;
                    $consecuentes->catalogo_id = $antescedente_id;
                    $consecuentes->siguiente_catalogo_id = $catalogoCurso->id;
                    $consecuentes->save();
                }
            }
        }
        if($request->tipo == 'S'){
            return view("pages.ingresar-temas-seminario")
                ->with('num_temas', $request->temas)
                ->with('catalogo_id', $catalogoCurso->id);
        }
        return redirect()->back()->with('msj','Se ha dado de alta al catalogo de curso '.$catalogoCurso->nombre_curso.' exitosamente.');
    }

    public function verAntescedentes($id){
        $catalogoCurso = CatalogoCurso::find($id);
        $consecuentes = Consecuente::where('siguiente_catalogo_id',$catalogoCurso->id)->get();
        $antescedentes=array();
        foreach($consecuentes as $consecuente){
            $antescedente=CatalogoCurso::findOrFail($consecuente->catalogo_id);
            array_push($antescedentes,$antescedente);
        }
        return view("pages.catalogo-cursos-ver-antescedentes")
            ->with("catalogoCurso",$catalogoCurso)
            ->with("antescedentes",$antescedentes);

        }

    public function descartarAntescedente($catalogoCurso_id, $antescedente_id){
        Consecuente::where('siguiente_catalogo_id', $catalogoCurso_id)->where('catalogo_id', $antescedente_id)->delete();
        return redirect()->back();
    }


}
