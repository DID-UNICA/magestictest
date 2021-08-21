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
        return view("pages.alta-carrera");
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
      if($user->clave != $request->clave){
        if(Carrera::where('clave', $request->clave)->exists())
            return redirect()->back()->with('danger', 'Error al actualizar los datos. La clave ya está en uso');
        else
            $user->clave = $request->clave;
      }
      $user->nombre = $request->nombre;
      $user->save();
      return redirect('/carrera')
        ->with('success', 'Los cambios han sido actualizados correctamente')
        ->with("user",$user);
    }


    public function delete($id)
    {
        $user = Carrera::findOrFail($id);
        $user -> delete();
        return redirect()->back()
          ->with('success', 'Se ha borrado la carrera correctamente');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $bandera = Carrera::where('clave',$request->clave)->exists();
        if($bandera)
            return redirect()->back()
              ->with('danger', 'La clave ya fue asignada a otra carrera');
        $user = new Carrera;
        $user->nombre = $request->nombre;
        $user->clave = $request->clave;
        $user->save();
        return redirect('/carrera')
          ->with('success', 'La carrera se ha creado exitosamente');
    }
    public function destroy(Carrera $carrera)
    {
        //
    }
}
