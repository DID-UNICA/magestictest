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
      $coordinaciones = Coordinacion::where('nombre_coordinacion','<>', 'Coordinación Del Centro de Docencia')->get();
      $users = CatalogoCurso::all();
      return view("pages.consulta-catalogo-cursos")
          ->with("coordinaciones",$coordinaciones)
          ->with("users",$users);
    }

    public function verModulos(){
      $modulos = CatalogoCurso::where('tipo','D')->get();
      return view("pages.consulta-catalogo-modulos")
        ->with('modulos', $modulos);
    }

    public function verCatalogosCursos(){
      $catalogos = CatalogoCurso::where('tipo','<>','D')->get();
      return view("pages.consulta-catalogo-cursos")
        ->with('users', $catalogos);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {
      $coordinaciones = Coordinacion::where('nombre_coordinacion','<>','Coordinación Del Centro de Docencia')
        ->where('nombre_coordinacion','<>', 'Área de Gestión y Vinculación')->get();
      $catalogo_cursos = CatalogoCurso::all();
      $profesores = Profesor::all();

      return view("pages.alta-catalogo-cursos")
          ->with("coordinaciones",$coordinaciones);
    }

    public function nuevoModulo()
    {
      $coordinaciones = Coordinacion::where('nombre_coordinacion','<>','Coordinación Del Centro de Docencia')->get();
      $catalogo_cursos = CatalogoCurso::all();
      $profesores = Profesor::all();

      return view("pages.alta-catalogo-modulos")
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

    public function verModulo($catalogo_modulo_id)
    {
      $catalogoCurso = CatalogoCurso::findOrFail($catalogo_modulo_id);
      return view("pages.ver-catalogo-modulo")
          ->with("modulo",$catalogoCurso);
    }


    public function edit($id)
    {
      $catalogoCurso = CatalogoCurso::find($id);
      $coordinaciones = Coordinacion::all(['id','nombre_coordinacion']);
      return view("pages.update-catalogo-cursos")
          ->with("user",$catalogoCurso)->with("coordinaciones",$coordinaciones);
    }

    public function editModulo($catalogo_modulo_id)
    {
      $catalogoCurso = CatalogoCurso::findOrFail($catalogo_modulo_id);
      $coordinaciones = Coordinacion::all(['id','nombre_coordinacion']);
      return view("pages.update-catalogo-modulo")
        ->with("modulo",$catalogoCurso)->with("coordinaciones",$coordinaciones);
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
        if($catalogoCurso->tipo === 'S' && $catalogoCurso->tipo != $request->tipo){
          $temas = TemaSeminario::where('catalogo_id', $catalogoCurso->id)->get();
          if(!$temas->isEmpty()){
            foreach($temas as $tema){
              try{
                $tema->delete();
              } catch(\Illuminate\Database\QueryException $e){
                return redirect()->back()
                ->with('danger', 'Existen instructores de algún curso asociados a los temas del seminario, primero elimínelos antes de cambiar de tipo');
              }
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

    public function updateModulo(Request $request, $catalogo_modulo_id)
    {
        $catalogoCurso = CatalogoCurso::find($catalogo_modulo_id);
        if($catalogoCurso->clave_curso != $request->clave_curso){
            if(CatalogoCurso::where('clave_curso', $request->clave_curso)->exists())
                return redirect()->back()->with('danger', 'Error al actualizar los datos. La clave ya está en uso');
            else
                $catalogoCurso->clave_curso = $request->clave_curso;
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

        return redirect()->route('catalogo.modulo.ver', $catalogoCurso->id)
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
      $arreglo_aux = array();
      $catalogos = collect();
        if($request->type == "nombre"){
          $words=explode(" ", $request->pattern);
          foreach($words as $word){
              array_push($arreglo_aux, CatalogoCurso::where('tipo', '<>','D')->whereRaw("lower(unaccent(nombre_curso)) ILIKE lower(unaccent('%".$word."%'))")
                  ->get());
          }
          foreach ($arreglo_aux as $tmp) {
              $catalogos = $catalogos->concat($tmp);
          }
        }elseif($request->type == "clave"){
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $catalogos = CatalogoCurso::whereRaw("lower(unaccent(clave_curso)) ILIKE lower(unaccent('%".$word."%'))")->where('tipo','<>','D')
                    -> get();
            }
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
                $catalogos = CatalogoCurso::whereIn("coordinacion_id", $aux2)->where('tipo','<>','D')->get();;
        }
        if($catalogos->isEmpty()){
          return redirect()->route('catalogo-cursos.ver.todos')
            ->with('warning', 'No se encontraron resultados');
        }
        return view("pages.consulta-catalogo-cursos")
            ->with("users",$catalogos);
    }

    public function searchModulos(Request $request)
    {
      $arreglo_aux = array();
      $modulos = collect();
        if($request->type == "nombre"){
          $words=explode(" ", $request->pattern);
          foreach($words as $word){
              array_push($arreglo_aux, CatalogoCurso::whereRaw("lower(unaccent(nombre_curso)) ILIKE lower(unaccent('%".$word."%'))")->where('tipo', 'D')
                  ->get());
          }
          foreach ($arreglo_aux as $tmp) {
              $modulos = $modulos->concat($tmp);
          }

        } elseif($request->type == "clave"){
          $modulos = CatalogoCurso::whereRaw(
            "lower(unaccent(clave_curso)) ILIKE lower(unaccent('%".$request->pattern."%'))")->where('tipo', 'D')
            ->get();
        } elseif($request->type == "coordinacion"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                array_push($arreglo_aux, CatalogoCurso::join('coordinacions','coordinacions.id', '=', 'catalogo_cursos.coordinacion_id')
                  ->whereRaw("lower(unaccent(coordinacions.nombre_coordinacion)) ILIKE lower(unaccent('%".$word."%'))")
                  ->where('catalogo_cursos.tipo', 'D')
                  ->get()
                );
            }
            foreach ($arreglo_aux as $tmp) {
              $modulos = $modulos->concat($tmp);
            }
        }

        $coordinaciones = Coordinacion::where('nombre_coordinacion','<>', 'Coordinación Del Centro de Docencia')->get();
        if($modulos->isEmpty()){
          return redirect()->route('catalogo.modulo.consulta')
            ->with('warning', 'No se encontraron resultados');
        }
        return view("pages.consulta-catalogo-modulos")
            ->with("coordinaciones",$coordinaciones)
            ->with("modulos",$modulos);
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

    public function deleteModulo($catalogo_modulo_id)
    {
      try{
        $catalogoCurso = CatalogoCurso::findOrFail($catalogo_modulo_id);
        $catalogoCurso->delete();
        return redirect()->route('catalogo.modulo.consulta')->with('success',
          'Se ha dado de baja el módulo'
        );
      }catch (\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 
          'El catálogo de módulo no puede ser eliminado porque tiene módulos programados asignados.');
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
        if($request->tipo === 'S'){
            return redirect()->route('catalogo-curso.ver-ts',$catalogoCurso->id)->with('success','Catálogo de curso creado');
        }
        return redirect('catalogo-cursos')->with('success','Se ha dado de alta el curso: '.$catalogoCurso->nombre_curso.' exitosamente.');
    }

    public function createModulo(Request $request)
    {
        if(CatalogoCurso::where('clave_curso', $request->clave_curso)->exists())
          return redirect()->back()->with('danger', 'Error al crear el módulo: '.$request->nombre_curso.'. La clave ya está en uso');
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
            return redirect()->route('catalogo.modulo.consulta')->with('success','Se ha dado de alta el módulo: '.$catalogoCurso->nombre_curso.' exitosamente.');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('danger', 'Error al almacenar en la base de datos');
        }
      }
}
