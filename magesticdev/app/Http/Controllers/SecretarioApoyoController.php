<?php

namespace App\Http\Controllers;

use App\SecretarioApoyo;
use Illuminate\Http\Request;
use Session;

class SecretarioApoyoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = SecretarioApoyo::all()->last();
        if($user == null){
            $user = new SecretarioApoyo();
            $user->coordinador = '';

            return view("pages.consulta-secretario-apoyo")
                ->with("user",$user);
        }else{
            return view("pages.consulta-secretario-apoyo")
                ->with("user",$user);
        }
    }

    public function nuevo()
    {
        return view("pages.alta-secretario-apoyo");
    }

    public function edit($id)
    {
        $user = SecretarioApoyo::find($id);
        return view("pages.update-secretario-apoyo")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = SecretarioApoyo::find($id);
        $user->secretario = $request->secretario;
        $user->comentarios = $request->comentarios;
        $user->grado = $request->grado;
        $user->save();
        Session::flash('update', 'Se han actualizado los datos correctamente');
        return redirect('/secretario-apoyo');

    }

    public function delete($id)
    {
        $user = SecretarioApoyo::findOrFail($id);
        $user -> delete();
        Session::flash('delete', 'Se ha borrado el registro exitosamente');
        return redirect('/secretario-apoyo');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = SecretarioApoyo::find(1);
        if(!$user){
            $user=new SecretarioApoyo();
        }
            $user->secretario = $request->secretario;
            $user->comentarios = $request->comentarios;
            $user->grado = $request->grado;
            $user->save();

        /*Session::flash('flash_message', 'Usuario agregado!');*/
        Session::flash('create', 'Se ha creado el registro correctamente');
        return view("pages.consulta-secretario-apoyo")
            ->with("user",$user);
    }

}
