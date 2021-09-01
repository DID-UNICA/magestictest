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

    public function create($catalogo_id, $num_temas, Request $request)
    {
        
        for($i = 0; $i < intval($num_temas); $i++){
            $nombre = "nombre".$i;
            $duracion = "duracion".$i;
            $tema = new TemaSeminario;
            $tema->nombre = $request->$nombre;
            $tema->duracion = $request->$duracion;
            $tema->catalogo_id = $catalogo_id;
            $tema->save();
        }
        return redirect()
            ->route('catalogo-cursos.consulta')
            ->with('success', 'El catálogo se ha creado exitosamente.');
    }

    public function update($catalogo_id, $num_temas, Request $request)
    {
        $antiguosTemas = TemaSeminario::where('catalogo_id', $catalogo_id)->get();
        foreach($antiguosTemas as $tema){
          try{
            $tema->delete();
          } catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()
            ->with('danger', 'Existen instructores de algún curso asociados a los temas anteriores, primero elimínelos');
          }
        }
        for($i=0; $i<intval($num_temas); $i++){
            $tema = new TemaSeminario;
            $nombre = "nombre".$i;
            $duracion = "duracion".$i;
            $tema->nombre = $request->$nombre;
            $tema->duracion = $request->$duracion;
            $tema->catalogo_id = $catalogo_id;
            $tema->save();
        }
        return redirect()
            ->route('catalogo-cursos.consulta')
            ->with('success', 'El catálogo se ha actualizado exitosamente.');
    }

    public function delete($id){
        try{
            $tema = TemaSeminario::findOrFail($id);
            try{
              $tema->delete();
            } catch(\Illuminate\Database\QueryException $e){
              return redirect()->back()
              ->with('danger', 'Existen instructores de algún curso asociados a este tema, primero elimínelos');
            }
            return;
        }catch (\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('danger', 'El tema de seminario no pudo ser eliminado.');
            }
    }

}
