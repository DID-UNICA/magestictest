<?php

namespace App\Http\Controllers;

use App\Carrera;
use App\Facultad;
use App\Division;
use Illuminate\Http\Request;
use Session;

class CarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $users = Carrera::all();
        return view("pages.consulta-carrera")
            ->with("users",$users);

    }

    public function nuevo()
    {
        $users = Division::all();
        $facultades = Facultad::all();

        return view("pages.alta-carrera")->with("users",$users)->with("facultades",$facultades);
;
    }

    public function show($id)
    {
        $user = Carrera::find($id);
        return view("pages.ver-carrera")
            ->with("user",$user);
    }

    public function edit($id)
    {
        $user = Carrera::find($id);
        return view("pages.update-carrera")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = Carrera::find($id);
        $user->nombre = $request->nombre;
        $user->clave = $request->clave;
        $user->id_division= $request->id_division;
        $user->save();
        Session::flash('update', 'Se han actualizado los datos correctamente');
        return view("pages.update-carrera")
            ->with("user",$user);
    }


    public function delete($id)
    {
        $user = Carrera::findOrFail($id);
        $user -> delete();
        Session::flash('delete', 'Se ha borrado el registro exitosamente');
        return redirect('/carrera');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new Carrera;
        $carreras = Carrera::all();
        $user->nombre = $request->nombre;
        $user->clave = $request->clave;
        foreach($carreras as $carrera){
            if($carrera->clave == $user->clave){
                Session::flash('error_carrera', '¡ERROR! La clave ya está asignada');
                return redirect()->back();
            }
        }
        $user->id_division= $request->id_division;
        $user->id_facultad = $request->id_facultad;

        $user->save();
        Session::flash('create', 'Se ha creado el registro correctamente');
        return redirect()->back();
    }


    public function destroy(Carrera $carrera)
    {
        //
    }
}
