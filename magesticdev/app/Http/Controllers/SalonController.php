<?php
namespace App\Http\Controllers;
use App\Salon;
use Illuminate\Http\Request;
use Session;

class SalonController extends Controller
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
        $users = Salon::all();
        return view("pages.consulta-salon")
            ->with("users",$users);
    }
    
    public function nuevo()
    {
        return view("pages.alta-salon");
    }
 
    public function search(Request $request)
    {
        
        if($request->type == "sede")
        {
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Salon::whereRaw("lower(unaccent(sede)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            return view("pages.consulta-salon")
            ->with("users",$users);

        $users = Salon::all();
        return view("pages.consulta-salon")
            ->with("users",$users);

         }elseif($request->type == "capacidad"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Salon::whereRaw("lower(unaccent(capacidad)) ILIKE lower(unaccent('".$word."'))")
                    -> get();
            }
            return view("pages.consulta-salon")
            ->with("users",$users);
        }
        elseif($request->type == "ubicacion"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Salon::whereRaw("lower(unaccent(ubicacion)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            return view("pages.consulta-salon")
            ->with("users",$users);
        }

        $users = Salon::all();
        return view("pages.consulta-catalogo-cursos")
            ->with("users",$users);

    }

    public function show($id)
    {
        $user = Salon::find($id);
        return view("pages.ver-salon")
            ->with("user",$user);
    }
    public function edit($id)
    {
        $user = Salon::find($id);
        return view("pages.update-salon")
            ->with("user",$user);
    }
    public function update(Request $request, $id)
    {
        $user = Salon::find($id);
        $user->sede = $request->sede;
        $user->capacidad= $request->capacidad;
        $user->ubicacion= $request->ubicacion;
        $user->save();
        Session::flash('update', 'Se han actualizado los datos correctamente');
        return view("pages.update-salon")
            ->with("user",$user);
    }
    public function delete($id)
    {

        try{$user = Salon::findOrFail($id);
            $user -> delete();
            return redirect('/salon');
        }catch (\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('msj', 'El salon no puede ser eliminado porque tiene cursos asignados.');
            }
    }
    public function create(Request $request)
    {
        $user = new Salon;
        $salones = Salon::all();

        $user->sede = $request->sede;
        foreach($salones as $salon){
            if($salon->sede == $user->sede){
                Session::flash('error_salon', '¡ERROR! El salón ya está asignado');
                return redirect()->back();
            }
        }
        $user->capacidad= $request->capacidad;
        $user->ubicacion= $request->ubicacion;
        $user->save();
        Session::flash('create', 'Se ha creado el registro correctamente');
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salon $salon)
    {
        //
    }
}