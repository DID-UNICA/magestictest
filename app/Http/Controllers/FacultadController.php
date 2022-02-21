<?php

namespace App\Http\Controllers;

use App\Facultad;
use Illuminate\Http\Request;

class FacultadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $users = Facultad::all();
        return view("pages.consulta-facultad")
            ->with("users",$users);
    }

    public function nuevo()
    {
        return view("pages.alta-facultad");
    }

    public function show($id)
    {
        $user = Facultad::find($id);
        return view("pages.ver-facultad")
            ->with("user",$user);
    }

    public function edit($id)
    {
        $user = Facultad::find($id);
        return view("pages.update-facultad")
            ->with("user",$user);
    }

    public function update(Request $request, $id)
    {
        $user = Facultad::find($id);
        $user->nombre = $request->nombre;
        $user->save();
        return redirect('/facultad');

    }


    public function delete($id)
    {
        $user = Facultad::findOrFail($id);
        $user -> delete();
        return redirect('/facultad');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new Facultad;
        $user->nombre= $request->nombre;
        $user->save();
        /*Session::flash('flash_message', 'Usuario agregado!');*/
        return redirect()->back();
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
     * @param  \App\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facultad $facultad)
    {
        //
    }
}
