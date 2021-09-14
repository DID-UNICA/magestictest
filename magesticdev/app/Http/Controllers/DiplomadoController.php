<?php

namespace App\Http\Controllers;

use App\Diplomado;
use App\Curso;
use App\ParticipantesCurso;
use App\Profesor;
use App\ProfesoresCurso;
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
    public function search(Request $request)
    {
      $diplomados = Diplomado::whereRaw("lower(unaccent(nombre_diplomado)) ILIKE lower(unaccent('%".$request->pattern."%'))")->get();
      if($diplomados->isEmpty())
        return redirect()->route('diplomado.consulta')
          ->with("warning","No se encontraron resultados");
      return view("pages.consulta-diplomados")
          ->with("diplomados",$diplomados);
    }

    public function searchModulo(Request $request, $diplomado_id){
      $diplomado = Diplomado::findOrFail($diplomado_id);
      $modulos_dip = Curso::where('diplomado_id', $diplomado->id)->get();
      if ($request->type == "nombre_curso") {
          $catalogos_res = CatalogoCurso::select('id')->whereRaw("lower(unaccent(nombre_curso)) ILIKE lower(unaccent('%".$request->pattern."%'))")
            ->where('tipo','D')->get();
          $res_busqueda = Curso::whereIn('catalogo_id', $catalogos_res)
            ->where('diplomado_id', null)
            ->get();
          return view('pages.diplomado-inscribir-modulos')->with("modulos",$res_busqueda)
            ->with('modulos_dip', $modulos_dip)
            ->with('diplomado',$diplomado);
      }elseif ($request->type=="titular") {
          $words=explode(" ", $request->pattern);
          foreach($words as $word){
              $profesores = Profesor::select('id')->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
              ->orWhereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
              ->orWhereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
              ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
              ->get();
          }
          $curso_prof = ProfesoresCurso::select('curso_id')->whereIn('profesor_id', $profesores)->get();
          $res_busqueda = Curso::whereIn('cursos.id',$curso_prof)
            ->join('catalogo_cursos','catalogo_cursos.id', '=','cursos.catalogo_id')
            ->where('catalogo_cursos.tipo', 'D')
            ->where('cursos.diplomado_id', null)
            ->get();
          return view('pages.diplomado-inscribir-modulos')->with("modulos",$res_busqueda)
          ->with('modulos_dip', $modulos_dip)
          ->with('diplomado',$diplomado);
      }elseif ($request->type=="clave") {
          $catalogos_res = CatalogoCurso::select('id')->whereRaw("lower(unaccent(clave_curso)) ILIKE lower(unaccent('%".$request->pattern."%'))")->get();
          $res_busqueda = Curso::whereIn('catalogo_id', $catalogos_res)
            ->join('catalogo_cursos','catalogo_cursos.id', '=','cursos.catalogo_id')
            ->where('catalogo_cursos.tipo', 'D')
            ->where('cursos.diplomado_id', null)
            ->get();
          return view('pages.diplomado-inscribir-modulos')->with("modulos",$res_busqueda)
          ->with('modulos_dip', $modulos_dip)
          ->with('diplomado',$diplomado);
      }
  }

    public function nuevo()
    {
      return view("pages.alta-diplomado");
    }

    public function show($id){
        $diplomado = Diplomado::find($id);
        return view("pages.ver-diplomado")
            ->with("diplomado",$diplomado);
    }

    public function edit($id){
        $diplomado = Diplomado::findOrFail($id);
        return view("pages.update-diplomado")
            ->with("diplomado",$diplomado);
    }

    public function update(Request $request, $id){
      $diplomado = Diplomado::findOrFail($id);
      $diplomado->nombre_diplomado = $request->nombre;
      $diplomado->save();
      return redirect()->route('diplomado.consulta')->with('success', 'El diplomado ha sido actualizado exitosamente');
  }

    public function create(Request $request)
    {
        $diplomado = new Diplomado;
        $diplomado->nombre_diplomado = $request->nombre;
        $diplomado->save();
        return redirect()->route('diplomado.consulta')
          ->with('success', 'El diplomado: '.$diplomado->nombre_diplomado.' ha sido dado de alta exitosamente');
    }

    public function delete($id)
    {
      try{
        $diplomado = Diplomado::findOrFail($id);
        $diplomado -> delete();
        return redirect()->route('diplomado.consulta')
          ->with('success', 'El diplomado ha sido eliminado exitosamente');
      }catch (\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 
          'El Diplomado no puede eliminarse porque tiene módulos asociados a él, primero cambie el diplomado al que pertenecen o elimínelos');
      }
    }

    public function asignarModulo($diplomado_id){
      $diplomado = Diplomado::findOrFail($diplomado_id);
      $modulos = Curso::join('catalogo_cursos','catalogo_cursos.id', '=', 'cursos.catalogo_id')
        ->where('catalogo_cursos.tipo', 'LIKE', 'D')
        ->where('cursos.diplomado_id',null)
        ->select('cursos.*')->get();
      $modulos_dip = Curso::join('catalogo_cursos','catalogo_cursos.id', '=', 'cursos.catalogo_id')
        ->where('catalogo_cursos.tipo', 'LIKE', 'D')
        ->where('cursos.diplomado_id',$diplomado->id)
        ->select('cursos.*')->get();

      return view("pages.diplomado-inscribir-modulos")
        ->with("modulos",$modulos)
        ->with("diplomado",$diplomado)
        ->with("modulos_dip", $modulos_dip);
    }

    public function createModulo($diplomado_id, $modulo_id){
      $modulo = Curso::findOrFail($modulo_id);
      $modulo->num_modulo = Curso::where('diplomado_id',$diplomado_id)->count()+1;
      $modulo->diplomado_id = $diplomado_id;
      $modulo->save();

      return redirect()->route("diplomado.modulo.asignar", $diplomado_id)
        ->with("success", "El módulo se ha asignado correctamente");
    }

    public function deleteModulo($diplomado_id, $modulo_id){
      $modulo = Curso::findOrFail($modulo_id);
      $modulos_dip = Curso::where('diplomado_id', $diplomado_id)->where('num_modulo','>',$modulo->num_modulo)->get();
      $modulo->num_modulo = null;
      $modulo->diplomado_id = null;
      $modulo->save();
      foreach($modulos_dip as $modulo_dip){
        $modulo_dip->num_modulo-=1;
        $modulo_dip->save();
      }

      return redirect()->route("diplomado.modulo.asignar",$diplomado_id)
        ->with("success", "El módulo se ha desasignado correctamente");
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
            ->whereNotIn('id',$inscritos)
            ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
            ->get();

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


}