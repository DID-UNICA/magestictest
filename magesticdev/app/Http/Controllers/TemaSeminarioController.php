<?php

namespace App\Http\Controllers;

use App\TemaSeminario;
use App\Coordinacion;
use App\CatalogoCurso;

use Illuminate\Http\Request;

class TemaSeminarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, $catalogo_id)
    {
      try{
        $ts = new TemaSeminario;
        $ts->nombre = $request->namen;
        $ts->duracion = intval($request->duracion);
        $ts->catalogo_id = $catalogo_id;
        $ts->save();
        return redirect()->back()->with('success', 'Nuevo tema de seminario creado exitosamente.');
      }catch (\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 'Problemas al crear el nuevo tema del seminario.');
      }
    }

    public function update(Request $request, $id)
    {
      try{
        $ts = TemaSeminario::findOrFail($id);
        $ts->nombre = $request->name;
        $ts->duracion = $request->duracion;
        $ts->save();
        return redirect()->back()->with('success', 'Tema de seminario actualizado exitosamente.');
      }catch (\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 'Problemas al actualizar del seminario.');
      }
    }

    public function delete($id){
      $ts = TemaSeminario::findOrFail($id);
      try{
        $ts->delete();
        return redirect()->back()->with('success', 'Tema de seminario eliminado exitosamente.');
      }catch(\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 'Problemas al eliminar el tema del seminario,'.
                                                  ' verifique que no esté asociado a ningún instructor.');
      }
    }

    public function index($cat_curso_id){
      $cat_curso = CatalogoCurso::findOrFail($cat_curso_id);
      return view('pages.update-temas-seminario-catalogo')
        ->with('ts',TemaSeminario::where('catalogo_id', $cat_curso->id)->get()->sortBy('id'))
        ->with('ct', $cat_curso->id);
    }

}
