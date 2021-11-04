<?php

namespace App\Http\Controllers;

use PDF;
use App\Carrera;
use App\Division;
use App\ParticipantesCurso;
use App\ProfesoresCarreras;
use App\ProfesoresDivisiones;
use App\CategoriaNivel;
use App\Curso;
use App\Facultad;
use App\Profesor;
use App\ProfesoresCurso;
use App\ProfesorCategoria;
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
        $divisiones = Division::all();
        $categorias = CategoriaNivel::all();
        $id_fac = 0;
        return view("pages.alta-profesor")
            ->with("facultades",$facultades)
            ->with("carreras",$carreras)
            ->with("divisiones",$divisiones)
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
        $divisiones = Division::all();
        $facultades = Facultad::all();
        return view("pages.update-profesor")
            ->with("user",$user)
            ->with("facultades", $facultades)
            ->with("carreras", $carreras)
            ->with("divisiones", $divisiones);
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
        $bandera = FALSE;
        $bandera2 = FALSE;
        if($user->rfc != "")
          $bandera = Profesor::where('rfc', $user->rfc)->where('id','<>',$user->id)->exists();
        if($user->numero_trabajador != "")
          $bandera2 = Profesor::where('numero_trabajador', $user->numero_trabajador)->where('id','<>',$user->id)->exists();
         if ($bandera or $bandera2)
            return redirect()->back()->with('danger', 'Datos incorrectos. Alguno de los datos ingresados ya esta registrado en el sistema');
        $user->telefono = $request->telefono;
        $categoria_1 = ProfesorCategoria::where('profesor_id',$user->id)->where('numero',1)->get()->first();
        if(!$categoria_1){
          $categoria_1 = new ProfesorCategoria();
          $categoria_1->profesor_id = $user->id;
          $categoria_1->numero = 1;
        }
        $categoria_1->categoria_nivel_id = $request->categoria_nivel_id;
        $categoria_1->save();
  
        $categoria_2 = ProfesorCategoria::where('profesor_id',$user->id)->where('numero',2)->get()->first();
        if(!$categoria_2){
          $categoria_2 = new ProfesorCategoria();
          $categoria_2->profesor_id = $user->id;
          $categoria_2->numero = 2;
        }
        $categoria_2->categoria_nivel_id = $request->categoria_nivel_2_id;
        $categoria_2->save();

        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->telefono = $request->telefono;
        $user->grado = $request->grado;
        $user->grado = $request->grado;
        if($request->grado == 'Otro')
          $user->abreviatura_grado = $request->abr_grado;
        else if ($request->grado == "Licenciatura")
          $user->abreviatura_grado = "Lic.";
        else if ($request->grado == "Ingeniería")
          $user->abreviatura_grado= "Ing.";
        else if ($request->grado == "Maestría" and $request->genero == "masculino")
          $user->abreviatura_grado = "Mtro.";
        else if($request->grado == "Maestría" and $request->genero == "femenino")
          $user->abreviatura_grado="Mtra.";
        else if ($request->grado == "Doctorado" and $request->genero == "masculino")
          $user->abreviatura_grado="Dr.";
        else if($request->grado == "Doctorado" and $request->genero == "femenino")
          $user->abreviatura_grado="Dra.";
        else
          $user->abreviatura_grado="";
        $user->genero = $request->genero;
        $user->semblanza_corta = $request->semblanza_corta;
        $user->facebook = $request->facebook;
        $user->email = $request->email;
        $user->unam = $request->unam;
        if($user->unam == 1 and $request->facultad_id != 0){
            $user->procedencia = null;
            $user->facultad_id = $request->facultad_id;
        }else{
            $user->procedencia = $request->procedencia;
            $user->facultad_id = null;
        }
        $user->save();
				$carreras_old = ProfesoresCarreras::where('id_profesor', $user->id)->get();
          foreach($carreras_old as $old){
            $old->delete();
          }
          $divisiones_old = ProfesoresDivisiones::where('id_profesor', $user->id)->get();
          foreach($divisiones_old as $old){
            $old->delete();
          }
        $fac_ing = Facultad::where('nombre', '=', 'Facultad de Ingeniería')->first();
        if($user->facultad_id == $fac_ing->id){
          $num_carreras = Carrera::count();
          $num_divisiones = Division::count();
          for($i = 0; $i<$num_carreras; $i++){
              $value = $request->{"carrera_option".$i};
              if(!is_null($value)){
                $profesor_carrera = new ProfesoresCarreras;
                $profesor_carrera->id_profesor = $user->id;
                $profesor_carrera->id_carrera = $value;
                $profesor_carrera->save();
              }
            }
            for($i = 0; $i<$num_divisiones; $i++){
              $value = $request->{"division_option".$i};
              if(!is_null($value)){
                $profesor_division = new ProfesoresDivisiones;
                $profesor_division->id_profesor = $user->id;
                $profesor_division->id_division = $value;
                $profesor_division->save();
              }
            }
        }
        return redirect()->route('profesor.show', $user->id)
            ->with("user",$user)
            ->with('success', 'Se han actualizado los cambios');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $arreglo_aux = array();
        $users = collect();
        if($request->type == "nombre")
        {
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                array_push($arreglo_aux, Profesor::whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orWhereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orWhereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                    ->get());
            }
            foreach ($arreglo_aux as $usuarios) {
                $users = $users->concat($usuarios);
            }

        }elseif($request->type == "correo"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                array_push($arreglo_aux, Profesor::whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                    -> get());
            }
            foreach ($arreglo_aux as $usuarios) {
                $users = $users->concat($usuarios);
            }
            
        }elseif($request->type == "rfc"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                array_push($arreglo_aux, Profesor::whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                    -> get());
            }
            foreach ($arreglo_aux as $usuarios) {
                $users = $users->concat($usuarios);
            }
            
        }elseif($request->type == "num"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                array_push($arreglo_aux, Profesor::whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                    -> get());
            }
            foreach ($arreglo_aux as $usuarios) {
                $users = $users->concat($usuarios);
            }
            
        }else{
            $users = Profesor::orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                    ->get();
        }
        return view("pages.consulta-profesores")
            ->with("users",$users->unique());

    }
    /*Busqueda de profesores para su inscripción como instructores*/
    //TODO crear solo un metodo dividiendo la tarea de busqueda

    public function search4(Request $request, $id,$tema_id)
    {
      $curso = Curso::findOrFail($id);
      $instructores = ProfesoresCurso::where('curso_id',$id)
        ->where('tema_seminario_id', $tema_id)->get();
      $words = explode(" ", $request->pattern);
      $arreglo_aux = array();
      $profesores = collect();
      foreach($words as $word){
        if($request->type == "nombre")
        {
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
            ->whereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

        }elseif($request->type == "correo"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

        }elseif($request->type == "rfc"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());
        }elseif($request->type == "num"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());
        }
      }
      foreach ($arreglo_aux as $profesoresword) {
        $profesores = $profesores->concat($profesoresword);
      }
      $profesores = $profesores->unique();
      return view('pages.curso-inscribir-instructores-seminario')
        ->with('curso', $curso)
        ->with('profesores', $profesores)
        ->with('tema_id', $tema_id)
        ->with('instructores', $instructores);
    }

    public function search3(Request $request, $id,$tema_id)
    {
      $curso = Curso::findOrFail($id);
      $instructores = Profesor::whereIn('id',
        ProfesoresCurso::select('profesor_id')->where('curso_id',$id)
        ->where('tema_seminario_id', $tema_id)->get())
      ->get();
      $words = explode(" ", $request->pattern);
      $arreglo_aux = array();
      $profesores = collect();
      foreach($words as $word){
        if($request->type == "nombre")
        {
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
            ->whereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

        }elseif($request->type == "correo"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

        }elseif($request->type == "rfc"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());
        }elseif($request->type == "num"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());
        }
      }
      foreach ($arreglo_aux as $profesoresword) {
        $profesores = $profesores->concat($profesoresword);
      }
      $profesores = $profesores->unique();
      return view('pages.curso-inscribir-instructores')
        ->with('curso', $curso)
        ->with('profesores', $profesores)
        ->with('tema_id', $tema_id)
        ->with('instructores', $instructores);
    }

    public function search2(Request $request, $id)
    {
      $curso = Curso::findOrFail($id);
      $instructores = Profesor::whereIn('id',
        ProfesoresCurso::select('profesor_id')->where('curso_id',$id)->get())
      ->get();
      $words = explode(" ", $request->pattern);
      $arreglo_aux = array();
      $profesores = collect();
      foreach($words as $word){
        if($request->type == "nombre")
        {
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
            ->whereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

        }elseif($request->type == "correo"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());

        }elseif($request->type == "rfc"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());
        }elseif($request->type == "num"){
          array_push($arreglo_aux, Profesor::whereNotIn('id', 
            ProfesoresCurso::select('profesor_id')
            ->where('curso_id',$id)->get())
          ->whereRaw("lower(unaccent(numero_trabajador)) ILIKE lower(unaccent('%".$word."%'))")
          ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
          ->get());
        }
      }
      foreach ($arreglo_aux as $profesoresword) {
        $profesores = $profesores->concat($profesoresword);
      }
      $profesores = $profesores->unique();
      return view('pages.curso-inscribir-instructores')
        ->with('curso', $curso)
        ->with('profesores', $profesores)
        ->with('instructores', $instructores);
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
                ->select('profesors.id')->get();
        $curso = Curso::findOrFail($request->curso_id);
        $enLista = ParticipantesCurso::select('id')->where('estuvo_en_lista',true)->where('curso_id',$request->curso_id)->count();

        if($request->type == "nombre")
        {
            $arreglo_aux = array();
            $users = collect();
            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                array_push($arreglo_aux, Profesor::select('*')->whereNotIn('id',$inscritos)->whereRaw("lower(unaccent(nombres)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('id',$inscritos)->orWhereRaw("lower(unaccent(apellido_paterno)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('id',$inscritos)->orWhereRaw("lower(unaccent(apellido_materno)) ILIKE lower(unaccent('%".$word."%'))")
                ->whereNotIn('id',$inscritos)
                ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                ->get());

            }
            foreach ($arreglo_aux as $usuarios) {
              $users = $users->concat($usuarios);
          }
          $users = $users->unique();
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);

        }elseif($request->type == "correo"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('id',Profesor::join('participante_curso','participante_curso.profesor_id','profesors.id')
                ->where('participante_curso.curso_id',$request->curso_id)
                ->select('profesors.id')->get())->whereRaw("lower(unaccent(email)) ILIKE lower(unaccent('%".$word."%'))")
                    ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                    ->get();
            }
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);
        }elseif($request->type == "rfc"){

            $words=explode(" ", $request->pattern);
            foreach($words as $word){
                $users = Profesor::select('*')->whereNotIn('id',Profesor::join('participante_curso','participante_curso.profesor_id','profesors.id')
                ->where('participante_curso.curso_id',$request->curso_id)
                ->select('profesors.id')->get())->whereRaw("lower(unaccent(rfc)) ILIKE lower(unaccent('%".$word."%'))")
                ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
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
                ->orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")
                ->get();
            }
            return view("pages.curso-inscripcion")
                ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
                ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);
        }
        $users = Profesor::orderByRaw("lower(unaccent(apellido_paterno)),lower(unaccent(apellido_materno)),lower(unaccent(nombres))")->get();
        return view("pages.curso-inscripcion")
            ->with("users",$users->whereNotIn('id',$instructores))->with("count", $request->count)->with("cupo", $request->cupo)->with("curso_id", $request->curso_id)
            ->with("nombre_curso", $request->nombre_curso)->with("curso",$curso)->with("lista",$enLista);
    }

    public function delete($id)
    {
        try{
            $user = Profesor::findOrFail($id);

            $divisions = ProfesoresDivisiones::where('id_profesor', $id)->get();
            foreach($divisions as $division)
              $division->delete();
            
            $carreras = ProfesoresCarreras::where('id_profesor', $id)->get();
            foreach($carreras as $carrera)
              $carrera->delete();

            $categorias = ProfesorCategoria::where('profesor_id', $id)->get();
            foreach($categorias as $categoria)
              $categoria->delete();
            $user->delete();
            return redirect('/profesor')->with('success', 'El profesor fue dado de baja correctamente.');
        }catch (\Illuminate\Database\QueryException $e){
            return redirect('/profesor')->with('danger', 'El profesor no puede ser eliminado porque tiene cursos asignados.');
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
        $user->telefono = $request->telefono;
        if($request->grupoRFC == "a"){
          $user->rfc = $request->rfc1;
        }
        else if($request->grupoRFC == "b"){
          $user->rfc = $request->rfc2;
        }
/*        else{
          return $request->curp;
        } 
*/

        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->telefono = $request->telefono;
        $user->grado = $request->grado;
        if($request->grado == 'Otro')
          $user->abreviatura_grado = $request->abr_grado;
        else if ($request->grado == "Licenciatura")
          $user->abreviatura_grado = "Lic.";
        else if ($request->grado == "Ingeniería")
          $user->abreviatura_grado= "Ing.";
        else if ($request->grado == "Maestría" and $request->genero == "masculino")
          $user->abreviatura_grado = "Mtro.";
        else if($request->grado == "Maestría" and $request->genero == "femenino")
          $user->abreviatura_grado="Mtra.";
        else if ($request->grado == "Doctorado" and $request->genero == "masculino")
          $user->abreviatura_grado="Dr.";
        else if($request->grado == "Doctorado" and $request->genero == "femenino")
          $user->abreviatura_grado="Dra.";
        else
          $user->abreviatura_grado="";
        $user->email = $request->email;
        $user->genero = $request->genero;
        $user->semblanza_corta = $request->semblanza_corta;
        $user->facebook = $request->facebook;
        $user ->unam = (int)$request -> unam;
        $user->numero_trabajador=$request->numero_trabajador;
        if($user->unam == 1 and $request->facultad_id != 0){
            $user->procedencia = null;
            $user->facultad_id = $request->facultad_id;
        }else{
            $user->procedencia = $request->procedencia;
            $user->facultad_id = null;
        }

        $bandera = FALSE;
        $bandera2 = FALSE;
        if($user->rfc != "")
          $bandera = Profesor::where('rfc', $user->rfc)->exists();
        if($user->numero_trabajador != "")
          $bandera2 = Profesor::where('numero_trabajador', $user->numero_trabajador)->exists();

          if ($bandera or $bandera2) {
            return redirect()->back()->with('danger', 'Datos incorrectos. Alguno de los datos ingresados ya esta registrado en el sistema');
          }
          else{
            $user->save();
            $fac_ing = Facultad::where('nombre', '=', 'Facultad de Ingeniería')->first();
            if($user->facultad_id == $fac_ing->id){
              $num_carreras = Carrera::count();
              $num_divisiones = Division::count();
              for($i = 0; $i<$num_carreras; $i++){
                  $value = $request->{"carrera_option".$i};
                  if(!is_null($value)){
                    $profesor_carrera = new ProfesoresCarreras;
                    $profesor_carrera->id_profesor = $user->id;
                    $profesor_carrera->id_carrera = $value;
                    $profesor_carrera->save();
                  }
                }
                for($i = 0; $i<$num_divisiones; $i++){
                  $value = $request->{"division_option".$i};
                  if(!is_null($value)){
                    $profesor_division = new ProfesoresDivisiones;
                    $profesor_division->id_profesor = $user->id;
                    $profesor_division->id_division = $value;
                    $profesor_division->save();
                  }
                }
            }
            $categoria_1 = new ProfesorCategoria();

            $categoria_1->profesor_id = $user->id;
            $categoria_1->categoria_nivel_id = $request->categoria_nivel_id;
            $categoria_1->numero = 1;
            $categoria_1->save();

            $categoria_2 = new ProfesorCategoria();
            $categoria_2->profesor_id = $user->id;
            $categoria_2->categoria_nivel_id = $request->categoria_nivel_2_id;
            $categoria_2->numero = 2;
            $categoria_2->save();

            return redirect('profesor')->with('success', 'Se ha dado de alta al profesor');
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
