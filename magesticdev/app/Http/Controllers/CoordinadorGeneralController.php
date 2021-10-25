<?php

namespace App\Http\Controllers;

use App\CoordinadorGeneral;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;


class CoordinadorGeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = CoordinadorGeneral::where('nombre_coordinacion', 'Coordinación Del Centro de Docencia')->get()->first();
        if($user === null){
            $user = new CoordinadorGeneral();
            $user->coordinador = '';
        }

        return view("pages.consulta-coordinador-general")
                ->with("user",$user);

    }

    public function nuevo()
    {
        return view("pages.alta-coordinador-general");
    }

    public function edit($id)
    {
        $user = CoordinadorGeneral::findOrFail($id);
        return view("pages.update-coordinador-general")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = CoordinadorGeneral::findOrFail($id);
        $user->coordinador = $request->coordinador;
        $user->comentarios = $request->comentarios;
        if($request->password != '')
          $user->password = Hash::make($request->password);
        $user->grado = $request->grado;
        $user->es_admin = True;
        if($request->genero === 'M')
					$user->genero = 'M';
				elseif($request->genero === 'F')
					$user->genero = 'F';
				else
					$user->genero = null;
        $user->save();
        return redirect('/coordinador-general')
          ->with('success','Se han actualizado los datos correctamente');

    }

    public function delete($id)
    {
        $user = CoordinadorGeneral::findOrFail($id);
        $user->delete();
        return redirect('/coordinador-general')
          ->with('success','Se ha borrado el registro exitosamente');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = CoordinadorGeneral::where('nombre_coordinacion', 
          'Coordinación Del Centro de Docencia'
        )->get()->first();
        if(!$user){
            $user=new CoordinadorGeneral();
        }
        $user->coordinador = $request->coordinador;
        $user->nombre_coordinacion = 'Coordinación Del Centro de Docencia';
        $user->comentarios = $request->comentarios;
        $user->password = Hash::make($request->password);
        $user->grado = $request->grado;
        $user->es_admin = True;
        if($request->genero === 'M')
					$user->genero = 'M';
				elseif($request->genero === 'F')
					$user->genero = 'F';
				else
					$user->genero = null;
        $user->save();
        return redirect('coordinador-general')
            ->with("user",$user)
            ->with('success','Se ha creado el registro correctamente');
    }
}
