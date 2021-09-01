<?php

namespace App\Http\Controllers;

use App\Coordinacion;
use App\Curso;
use App\CatalogoCurso;
use App\TemaSeminario;
use App\Profesor;
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
        $catalogoCurso = CatalogoCurso::find($id);
        return view("pages.ver-catalogo-cursos")
            ->with("user",$catalogoCurso);
    }


    public function edit($id)
    {
        $catalogoCurso = CatalogoCurso::find($id);
        $coordinaciones = Coordinacion::all(['id','nombre_coordinacion']);
        
        return view("pages.update-catalogo-cursos")
            ->with("user",$catalogoCurso)->with("coordinaciones",$coordinaciones);
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
        $catalogoCurso = CatalogoCurso::find($id);
        if($catalogoCurso->clave_curso != $request->clave_curso){
            if(CatalogoCurso::where('clave_curso', $request->clave_curso)->exists())
                return redirect()->back()->with('danger', 'Error al actualizar los datos. La clave ya está en uso');
            else
                $catalogoCurso->clave_curso = $request->clave_curso;
        }
        $temas = TemaSeminario::where('catalogo_id', $catalogoCurso->id)->get();
        //El tipo se actualizó a seminario y hay que cambiar temas
        if($request->tipo == 'S' && $temas->count() != intval($request->num_temas)){
            return view("pages.update-temas-seminario")
                ->with('temas', $temas)
                ->with('num_temas', $request->num_temas)
                ->with('catalogo_id', $catalogoCurso->id);
        }
        //El tipo dejó de ser seminario y hay que eliminar todos sus temas
        if(!$temas->isEmpty() && $catalogoCurso->tipo != $request->tipo){
            foreach($temas as $tema){
              try{
                $tema->delete();
              } catch(\Illuminate\Database\QueryException $e){
                return redirect()->back()
                ->with('danger', 'Existen instructores de algún curso asociados a los temas del seminario, primero elimínelos antes de cambiar de tipo');
              }
            }
        }
        $catalogoCurso->nombre_curso = $request->nombre_curso;
        $catalogoCurso->duracion_curso = $request->duracion_curso;
        $catalogoCurso->coordinacion_id = $request->coordinacion_id;
        $catalogoCurso->tipo = $request->tipo;
        $catalogoCurso->institucion = $request->institucion;
        $catalogoCurso->dirigido = $request->dirigido;
        $catalogoCurso->objetivo = $request->objetivo;
        $catalogoCurso->contenido = $request->contenido;
        $catalogoCurso->antecedentes = $request->antesc;
        $catalogoCurso->fecha_disenio = $request->fecha_disenio;

        $catalogoCurso->save();
        
        return redirect('catalogo-cursos/'.$catalogoCurso->id)
            ->with("user",$catalogoCurso)
            ->with('success','Se han actualizado los cambios');
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
            $catalogoCurso = CatalogoCurso::findOrFail($id);
            $catalogoCurso -> delete();
            return redirect('catalogo-cursos')->with('success', 
              'Se ha dado de baja el curso del catálogo'
            );
        }catch (\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('danger', 
                  'El catálogo de cursos no puede ser eliminado porque tiene cursos asignados.');
            }
    }

    public function create(Request $request)
    {
        if(CatalogoCurso::where('clave_curso', $request->clave_curso)->exists())
          return redirect()->back()->with('danger', 'Error al crear el curso: '.$request->nombre_curso.'. La clave ya está en uso');
        $catalogoCurso = new CatalogoCurso;
        $catalogoCurso->nombre_curso = $request->nombre_curso;
        $catalogoCurso->duracion_curso = $request->duracion_curso;
        $catalogoCurso->coordinacion_id = $request->coordinacion_id;
        $catalogoCurso->tipo = $request->tipo;
        $catalogoCurso->institucion = $request->institucion;
        $catalogoCurso->dirigido = $request->dirigido;
        $catalogoCurso->objetivo = $request->objetivo;
        $catalogoCurso->contenido = $request->contenido;
        $catalogoCurso->antecedentes = $request->antesc;
        $catalogoCurso->fecha_disenio = $request->fecha_disenio;
        $catalogoCurso->clave_curso = $request->clave_curso;
        try{
            $catalogoCurso->save();
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('danger', 'Error al almacenar en la base de datos');
        }
        if($request->tipo == 'S'){
            return view("pages.ingresar-temas-seminario")
                ->with('num_temas', $request->temas)
                ->with('catalogo_id', $catalogoCurso->id);
        }
        return redirect('catalogo-cursos')->with('success','Se ha dado de alta el curso: '.$catalogoCurso->nombre_curso.' exitosamente.');
    }
}
