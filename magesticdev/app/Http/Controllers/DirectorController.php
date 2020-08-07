<?php

namespace App\Http\Controllers;

use App\Director;
use Illuminate\Http\Request;
use Session;

class DirectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = Director::all()->last();
        if($user == null){
            $user = new Director();
            $user->coordinador = '';

            return view("pages.consulta-director")
                ->with("user",$user);
        }else{
            return view("pages.consulta-director")
                ->with("user",$user);
        }
    }

    public function nuevo()
    {
        return view("pages.alta-director");
    }

    public function edit($id)
    {
        $user = Director::find($id);
        return view("pages.update-director")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = Director::find($id);
        $user->director = $request->director;
        $user->comentarios = $request->comentarios;
        $user->grado = $request->grado;
        $user->save();
        Session::flash('update', 'Se han actualizado los datos correctamente');
        return redirect('/direccion');

    }

    public function delete($id)
    {
        $user = Director::findOrFail($id);
        $user -> delete();
        Session::flash('delete', 'Se ha borrado el registro exitosamente');
        return redirect('/direccion');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Director::find(1);
        if(!$user){
            $user=new Director();
        }
            $user->director = $request->director;
            $user->comentarios = $request->comentarios;
            $user->grado = $request->grado;
            $user->save();

        /*Session::flash('flash_message', 'Usuario agregado!');*/
        Session::flash('create', 'Se ha creado el registro correctamente');
        return view("pages.consulta-director")
            ->with("user",$user);
    }

}