<?php

namespace App\Http\Controllers;

use App\Coordinacion;
use Illuminate\Http\Request;
use Session; 

class CoordinacionController extends Controller
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
        $users = Coordinacion::all();
        return view("pages.consulta-coordinacion")
            ->with("users",$users);
    }

    public function nuevo()
    {
        return view("pages.alta-coordinacion");
    }

    public function updatepassword($id)
    {
        $user = Coordinacion::find($id);
        return view("pages.coordinacion-password-update")
        ->with("user",$user);
    }

    public function show($id)
    {
        $user = Coordinacion::find($id);
        return view("pages.ver-coordinacion")
            ->with("user",$user);
    }

    public function edit($id)
    {
        $user = Coordinacion::find($id);
        return view("pages.update-coordinacion")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = Coordinacion::find($id);
        $user->nombre_coordinacion = $request->nombre_coordinacion;
        $user->abreviatura= $request->abreviatura;
        $user->coordinador= $request->coordinador;
        $user->usuario= $request->usuario;
        $user->password= bcrypt($request->password);
        $user->comentarios = $request->comentarios;
        $user->grado = $request->grado;
				if($request->genero === 'M')
					$user->genero = 'M';
				elseif($request->genero === 'F')
					$user->genero = 'F';
				else
					$user->genero = null;
        $user->save();
        return redirect('/coordinacion')
            ->with("user",$user)
            ->with("success",'Se han actualizado los datos correctamente');
    }

    public function updatepass(Request $request, $id)
    {
        $user = Coordinacion::find($id);
        $user->password= bcrypt($request->password);
        $user->save();
        return redirect('/coordinacion')
            ->with("user",$user)
            ->with("success",'Se han actualizado los datos correctamente');;
    }


    public function delete($id)
    {
        try{
            $user = Coordinacion::findOrFail($id);
            $user -> delete();
            return redirect('/coordinacion')
              ->with("success",'Se ha eliminado la coordinación correctamente');;
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()
              ->with('danger', 
                'No se puede dar de baja ya que hay cursos asignados a dicha coordinacion');    
        }

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new Coordinacion;
        $user->nombre_coordinacion = $request->nombre_coordinacion;
        $user->abreviatura= $request->abreviatura;
        $user->coordinador= $request->coordinador;
        $user->usuario= $request->usuario;
        $user->password= bcrypt($request->password);
        $user->comentarios = $request->comentarios;
        $user->grado = $request->grado;
				if($request->genero === 'M')
					$user->genero = 'M';
				elseif($request->genero === 'F')
					$user->genero = 'F';
				else
					$user->genero = null;
        $user->save();
        return redirect('/coordinacion')
          ->with("success",'Se ha creado el registro correctamente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coordinacion  $coordinacion
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coordinacion  $coordinacion
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coordinacion  $coordinacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coordinacion $coordinacion)
    {
        //
    }
}
