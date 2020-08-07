<?php

namespace App\Http\Controllers;

use PDF;
use App\Carrera;
use App\ParticipantesCurso;
use App\CategoriaNivel;
use App\Curso;
use App\Facultad;
use App\Profesor;
use App\ProfesoresCurso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;


class ProfesorController extends Controller
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
        $users = Profesor::all();
        return view("pages.consulta-profesores")
            ->with("users",$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {

        $facultades = Facultad::all();
        $carreras = Carrera::all();
        $categorias = CategoriaNivel::all();
        $id_fac = 0;
        return view("pages.alta-profesor")
            ->with("facultades",$facultades)
            ->with("carreras",$carreras)
            ->with("categorias",$categorias)
            ->with("id_fac",$id_fac);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Profesor::find($id);
        return view("pages.ver-profesor")
            ->with("user",$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Profesor::find($id);
        $carreras = Carrera::all();
        $facultades = Facultad::all();
        return view("pages.update-profesor")
            ->with("user",$user)
            ->with("facultades", $facultades)
            ->with("carreras", $carreras);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*dd($request);*/
        $user = Profesor::find($id);
        $user->nombres = $request->nombres;
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->rfc = $request->rfc;
        $user->numero_trabajador=$request->numero_trabajador;
        $user->telefono = $request->telefono;
        $user->curp = $request->curp;
        $user->categoria_nivel_id = $request->categoria_nivel_id;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->telefono = $request->telefono;
        $user->grado = $request->grado;
        $user->comentarios = $request->comentarios;
        $user->genero = $request->genero;
        $user->semblanza_corta = $request->semblanza_corta;
        $user->facebook = $request->facebook;
        $user->email = $request->email;
        $user->unam = $request->unam;
        if($user->unam == 1){
            $user->procedencia = null;
            $user->facultad_id = $request->facultad_id;
            $user->carrera_id = $request->carrera_id;
        }else if ($user->unam == 0){
            $user->procedencia = $request->procedencia;
            $user->facultad_id = null;
            $user->carrera_id = null;
        }
        $user->save();
        return view("pages.ver-profesor")
            ->with("user",$user);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->type == "nombre")
        {
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orWhereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orWhereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            

        }elseif($request->type == "correo"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            
        }elseif($request->type == "rfc"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            
        }elseif($request->type == "num"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
                    -> get();
            }
            
        }else{
            $users = Profesor::all();
        }
        return view("pages.consulta-profesores")
            ->with("users",$users);

    }
    /* Consulta-Alta */
    public function search1(Request $request)
    {
        $instruct = Profesor::join('profesor_curso', 'profesor_curso.profesor_id', 'profesors.id')
                ->where('curso_id', '=', $request->curso_id)
                ->select('profesors.id')->get();
        $instructores = array();
        foreach ($instruct as $instruct1) {
            array_push($instructores, $instruct1->id);
        }
        $inscritos = Profesor::join('participante_curso','participante_curso.profesor_id','profesors.id')
                ->where('participante_curso.curso_id', '=', $request->curso_id)
                ->select('profesors.rfc')->get();
        $curso = Curso::findOrFail($request->curso_id);
        $enLista = ParticipantesCurso::select('id')->where('estuvo_en_lista',true)->where('curso_id',$request->curso_id)->count();

        if($request->type == "nombre")
        {
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('rfc',$inscritos)->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('rfc',$inscritos)->orWhereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('rfc',$inscritos)->orWhereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('rfc',$inscritos)->get();

            }
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);

        }elseif($request->type == "correo"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('rfc',Profesor::join('participante_curso','participante_curso.profesor_id','profesors.id')
                ->where('participante_curso.curso_id',$request->curso_id)
                ->select('profesors.rfc')->get())->whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
                    ->get();
            }
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);
        }elseif($request->type == "rfc"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('rfc',Profesor::join('participante_curso','participante_curso.profesor_id','profesors.id')
                ->where('participante_curso.curso_id',$request->curso_id)
                ->select('profesors.rfc')->get())->whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
                ->get();
            }
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);
        }elseif($request->type == "num"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('numero_trabajador',Profesor::join('participante_curso','participante_curso.profesor_id','profesors.id')
                ->where('participante_curso.curso_id',$request->curso_id)
                ->select('profesors.numero_trabajador')->get())->whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
                ->get();
            }
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);
        }
        $users = Profesor::all();
        return view("pages.curso-inscripcion")
            ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
            ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);

    }

    public function delete($id)
    {

        try{$user = Profesor::findOrFail($id);
                $user -> delete();
                return redirect('/profesor');
            }catch (\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('msj', 'El profesor no puede ser eliminado porque tiene cursos asignados.');
            }
    }

    public function cursos($id){
        
            $cursos = Curso::leftJoin('participante_curso','participante_curso.curso_id', 'cursos.id')
                ->where('participante_curso.profesor_id',$id)
                ->select('cursos.*')->get();
            
            return view("pages.consulta-cursos")
                ->with("cursos",$cursos);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $bandera = false;
        $user = new Profesor;
        $user->nombres = $request->nombres;
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        if($request->grupoRFC == "a"){
            $user->rfc = $request->rfc1;
        }
        else if($request->grupoRFC == "b"){
            $user->rfc = $request->rfc2;
        }
        else{
            return $request->curp;
        }
        $user->telefono = $request->telefono;
        $user->curp = $request->curp;
        $user->categoria_nivel_id = $request->categoria_nivel_id;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->telefono = $request->telefono;
        $user->grado = $request->grado;
        $user->email = $request->email;
        $user->comentarios = $request->comentarios;
        $user->genero = $request->genero;
        $user->semblanza_corta = $request->semblanza_corta;
        $user->facebook = $request->facebook;
        $user ->unam = (int)$request -> unam;
        $user->numero_trabajador=$request->numero_trabajador;
        if($user->unam == 1){
            $user->procedencia = null;
            $user->facultad_id = $request->facultad_id;
            $user->carrera_id = $request->carrera_id;
        }else if ($user->unam == 0){
            $user->procedencia = $request->procedencia;
            $user->facultad_id = null;
            $user->carrera_id = null;
        }
        


        $bandera = Profesor::where('rfc', $user->rfc1)->exists();
        $bandera = $bandera or Profesor::where('rfc', $user->rfc2)->exists();
        $bandera = $bandera or Profesor::where('curp', $user->curp)->exists();
        $bandera = $bandera or Profesor::where('email', $user->email)->exists();
        $bandera = $bandera or Profesor::where('numero_trabajador', $user->numero_trabajador)->exists();
         if ($bandera) {
            return redirect()->back()->with('msj', 'Datos incorrectos. Alguno de los datos ingresados ya esta registrado en el sistema')->with('D','danger');
         }else{
            $user->save();
            return redirect()->back()->with('msj', 'Se ha dado de alta al profesor');
        }
    }

    public function generarhistorial($id){
        $profesor = Profesor::findOrFail($id);
        $cursos = Curso::leftJoin('participante_curso','participante_curso.curso_id', 'cursos.id')
                ->where('participante_curso.profesor_id',$id)
                ->where('participante_curso.acreditacion',TRUE)
                ->select('cursos.*')->get();
        $datos = array("profesor" =>$profesor, "cursos" => $cursos);
        $pdf = PDF::loadView("pages.pdf.historialprofesor", $datos)
        ->setPaper('letter');
        return $pdf->download('HistorialProfesor'.$id.'.pdf');
            
    }


}
