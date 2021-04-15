<?php

namespace App\Http\Controllers;

use App\Division;
use Illuminate\Http\Request;
use Session;

class DivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $users = Division::all();
        return view("pages.consulta-division")
            ->with("users",$users);
    }

    public function nuevo()
    {
        return view("pages.alta-division");
    }

    public function show($id)
    {
        $user = Division::find($id);
        return view("pages.ver-division")
            ->with("user",$user);
    }

    public function edit($id)
    {
        $user = Division::find($id);
        return view("pages.update-division")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = Division::find($id);
        $user->nombre = $request->nombre;
        $user->save();
        return redirect('/division')
          ->with('success','Se han actualizado los datos correctamente');

    }


    public function delete($id)
    {
        $user = Division::findOrFail($id);
        $user -> delete();
        return redirect('/division')
          ->with('success','Se ha borrado el registro exitosamente');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new Division;
        $user->nombre= $request->nombre;
        $user->save();
        return redirect('/division')
          ->with('success','Se ha creado el registro correctamente');
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
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        //
    }
}
