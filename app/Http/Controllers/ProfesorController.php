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
use Illuminate\Support\Facades\DB;



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

  /**
   *  Search engine for professors used for different URL's.
   * 
   * @return App\Profesor;
   */
  public function search(String $type=NULL, String $pattern='')
  {
    $profesores = collect([]);
    if($type === 'nombre'){

      //Buscamos por apellido y sin espacios para evitar conflictos.
      $profesores = Profesor::whereRaw("unaccent(replace(concat(apellido_paterno,apellido_materno,nombres),' ','')) ILIKE (unaccent('".str_replace(" ", "", $pattern)."%'))");

    } elseif ($type == "correo") {

      //Buscamos el patron en cualquier parte de la cadena del correo
      $profesores = Profesor::whereRaw("unaccent(email) ILIKE unaccent('%" . $pattern . "%')");

    } elseif ($type == "rfc") {

      //Buscamos el patron en cualquier parte de la cadena del rfc
      $profesores = Profesor::whereRaw("unaccent(rfc) ILIKE unaccent('%" . $pattern . "%')");
    } elseif ($type == "num") {
      
      //Buscamos el patron en cualquier parte de la cadena del numero_trabajador
      $profesores = Profesor::whereRaw("unaccent(numero_trabajador) ILIKE unaccent('%" . $pattern . "%')");
    } else {

      //El ID jamás será NULL. Traemos a todos los profesores
      $profesores = Profesor::where('id','<>', NULL);
    }

    //Ordenamos por nombres sin espacios, para evitar conflictos
    return $profesores->orderByRaw(
      "lower(unaccent(replace(concat(apellido_paterno,apellido_materno,nombres), ' ', '')))"
    )->selectRaw("id,concat_ws(' ',apellido_paterno,apellido_materno,nombres) as nombre, email,
              rfc, numero_trabajador")
    ->get();

  }


  public function index(Request $request)
  {
    if($request->type && $request->pattern)
      $profesores = $this->search($request->type, $request->pattern);
    else
      $profesores = $this->search();
    return view("pages.consulta-profesores")
      ->with("profesores", $profesores);
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
      ->with("facultades", $facultades)
      ->with("carreras", $carreras)
      ->with("divisiones", $divisiones)
      ->with("categorias", $categorias)
      ->with("id_fac", $id_fac);
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
      ->with("user", $user);
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
      ->with("user", $user)
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
    $user->numero_trabajador = $request->numero_trabajador;
    $bandera = FALSE;
    $bandera2 = FALSE;
    if ($user->rfc != "")
      $bandera = Profesor::where('rfc', $user->rfc)->where('id', '<>', $user->id)->exists();
    if ($user->numero_trabajador != "")
      $bandera2 = Profesor::where('numero_trabajador', $user->numero_trabajador)->where('id', '<>', $user->id)->exists();
    if ($bandera or $bandera2)
      return redirect()->back()->with('danger', 'Datos incorrectos. Alguno de los datos ingresados ya esta registrado en el sistema');
    $user->telefono = $request->telefono;
    $categoria_1 = ProfesorCategoria::where('profesor_id', $user->id)->where('numero', 1)->get()->first();
    if (!$categoria_1) {
      $categoria_1 = new ProfesorCategoria();
      $categoria_1->profesor_id = $user->id;
      $categoria_1->numero = 1;
    }
    $categoria_1->categoria_nivel_id = $request->categoria_nivel_id;
    $categoria_1->save();

    $categoria_2 = ProfesorCategoria::where('profesor_id', $user->id)->where('numero', 2)->get()->first();
    if (!$categoria_2) {
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
    if ($request->grado == 'Otro')
      $user->abreviatura_grado = $request->abr_grado;
    else if ($request->grado == "Licenciatura")
      $user->abreviatura_grado = "Lic.";
    else if ($request->grado == "Ingeniería")
      $user->abreviatura_grado = "Ing.";
    else if ($request->grado == "Maestría" and $request->genero == "masculino")
      $user->abreviatura_grado = "Mtro.";
    else if ($request->grado == "Maestría" and $request->genero == "femenino")
      $user->abreviatura_grado = "Mtra.";
    else if ($request->grado == "Doctorado" and $request->genero == "masculino")
      $user->abreviatura_grado = "Dr.";
    else if ($request->grado == "Doctorado" and $request->genero == "femenino")
      $user->abreviatura_grado = "Dra.";
    else
      $user->abreviatura_grado = "";
    $user->genero = $request->genero;
    $user->semblanza_corta = $request->semblanza_corta;
    $user->facebook = $request->facebook;
    $user->email = $request->email;
    $user->unam = $request->unam;
    if ($user->unam == 1 and $request->facultad_id != 0) {
      $user->procedencia = null;
      $user->facultad_id = $request->facultad_id;
    } else {
      $user->procedencia = $request->procedencia;
      $user->facultad_id = null;
    }
    $user->save();
    $carreras_old = ProfesoresCarreras::where('id_profesor', $user->id)->get();
    foreach ($carreras_old as $old) {
      $old->delete();
    }
    $divisiones_old = ProfesoresDivisiones::where('id_profesor', $user->id)->get();
    foreach ($divisiones_old as $old) {
      $old->delete();
    }
    $fac_ing = Facultad::where('nombre', '=', 'Facultad de Ingeniería')->first();
    if ($user->facultad_id == $fac_ing->id) {
      $num_carreras = Carrera::count();
      $num_divisiones = Division::count();
      for ($i = 0; $i < $num_carreras; $i++) {
        $value = $request->{"carrera_option" . $i};
        if (!is_null($value)) {
          $profesor_carrera = new ProfesoresCarreras;
          $profesor_carrera->id_profesor = $user->id;
          $profesor_carrera->id_carrera = $value;
          $profesor_carrera->save();
        }
      }
      for ($i = 0; $i < $num_divisiones; $i++) {
        $value = $request->{"division_option" . $i};
        if (!is_null($value)) {
          $profesor_division = new ProfesoresDivisiones;
          $profesor_division->id_profesor = $user->id;
          $profesor_division->id_division = $value;
          $profesor_division->save();
        }
      }
    }
    return redirect()->route('profesor.show', $user->id)
      ->with("user", $user)
      ->with('success', 'Se han actualizado los cambios');
  }

  public function vistaInstructores(Request $request, $curso_id)
  {

    //Instructores del curso
    $instructores = DB::table('profesor_curso as pc')
                      ->join('profesors as p', 'pc.profesor_id', 'p.id')
                      ->where('pc.curso_id', $curso_id)
                      ->selectRaw("p.id, 
                        concat_ws(' ', p.apellido_paterno, p.apellido_materno, 
                                   p.nombres)
                                  as nombre,
                        p.email, p.rfc,p.numero_trabajador")
                      ->get();

    //Participantes del curso
    $participantes = DB::table('participante_curso as pc')
                       ->join('profesors as p', 'pc.profesor_id', 'p.id')
                       ->where('pc.curso_id', $curso_id)
                       ->select('p.id as profesor_id', 
                                'pc.id as participante_id', 'estuvo_en_lista', 
                                'cancelacion')
                       ->get()
                       ->map(fn($e) => $e->profesor_id);

    //Datos del curso y cantidad de participantes
    $curso = DB::table('cursos as c')
               ->join('catalogo_cursos as cc', 'cc.id', '=', 'c.catalogo_id')
               ->where('c.id', $curso_id)
               ->select('c.id','cc.nombre_curso as nombre','cc.tipo','c.cupo_maximo',)
               ->get()
               ->first();

    if($request->type && $request->pattern)
      $profesores = $this->search($request->type, $request->pattern);
    else
      $profesores = $this->search();

    if($curso->tipo === 'S')
      return view("pages.curso-inscribir-instructores")
        	->with("instructores", $instructores)
          ->with("profesores", $profesores->whereNotIn('id', 
                                  $instructores->map(fn($e) => $e->id)
                                ))
          ->with("curso", $curso);

    else
      return view("pages.curso-inscribir-instructores")
          ->with("instructores", $instructores)
          ->with("profesores", $profesores
            ->whereNotIn('id', $instructores->map(fn($e) => $e->id))
            ->whereNotIn('id', $participantes)
            )
          ->with("curso", $curso);
  }
  /* Consulta-Alta */
  public function inscribirParticipante(Request $request, $curso_id)
  {
    //ID's de Instructores
    $instructores = DB::table('profesor_curso as pc')
                      ->join('profesors as p', 'pc.profesor_id', 'p.id')
                      ->where('pc.curso_id', $curso_id)
                      ->select('p.id')
                      ->get()
                      ->map(fn($e) => $e->id);

    //Participantes inscritos al curso
    $participantes = DB::table('participante_curso as pc')
                       ->join('profesors as p', 'pc.profesor_id', 'p.id')
                       ->where('pc.curso_id', $curso_id)
                       ->select('p.id as profesor_id', 
                                'pc.id as participante_id', 'estuvo_en_lista', 
                                'cancelacion')
                       ->get();

    //Datos del curso y cantidad de participantes
    $curso = DB::table('cursos as c')
               ->join('catalogo_cursos as cc', 'cc.id', '=', 'c.catalogo_id')
               ->where('c.id', $curso_id)
               ->select('c.id','cc.nombre_curso','cc.tipo','c.cupo_maximo',)
               ->get()
               ->first();

    $curso->participant_count = $participantes
      ->where('cancelacion', '<>', true)
      ->where('estuvo_en_lista', '<>', true)
      ->count();
    
    $curso->list_count = $participantes
      ->where('estuvo_en_lista', true)
      ->count();
    
    $participantes = $participantes->map(fn($e) => $e->profesor_id);

    if($request->type && $request->pattern)
      $profesores = $this->search($request->type, $request->pattern);
    else
      $profesores = $this->search();

    if($curso->tipo === 'S')
      return view("pages.curso-inscripcion")
          ->with("profesores", $profesores->whereNotIn('id', $participantes))
          ->with("curso", $curso);

    else
      return view("pages.curso-inscripcion")
          ->with("profesores", $profesores
            ->whereNotIn('id', $instructores)
            ->whereNotIn('id', $participantes)
            )
          ->with("curso", $curso);
  }

  public function delete($id)
  {
    try {
      $user = Profesor::findOrFail($id);

      $divisions = ProfesoresDivisiones::where('id_profesor', $id)->get();
      foreach ($divisions as $division)
        $division->delete();

      $carreras = ProfesoresCarreras::where('id_profesor', $id)->get();
      foreach ($carreras as $carrera)
        $carrera->delete();

      $categorias = ProfesorCategoria::where('profesor_id', $id)->get();
      foreach ($categorias as $categoria)
        $categoria->delete();
      $user->delete();
      return redirect()->route('profesor.consulta')->with('success', 'El profesor fue dado de baja correctamente.');
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect()->route('profesor.consulta')->with('danger', 'El profesor no puede ser eliminado porque tiene cursos asignados.');
    }
  }

  public function cursos($id)
  {

    $cursos = Curso::leftJoin('participante_curso', 'participante_curso.curso_id', 'cursos.id')
      ->where('participante_curso.profesor_id', $id)
      ->select('cursos.*')->get();

    return view("pages.consulta-cursos")
      ->with("cursos", $cursos);
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
    if ($request->grupoRFC == "a") {
      $user->rfc = $request->rfc1;
    } else if ($request->grupoRFC == "b") {
      $user->rfc = $request->rfc2;
    }
    /*        else{
          return $request->curp;
        } 
*/

    $user->fecha_nacimiento = $request->fecha_nacimiento;
    $user->telefono = $request->telefono;
    $user->grado = $request->grado;
    if ($request->grado == 'Otro')
      $user->abreviatura_grado = $request->abr_grado;
    else if ($request->grado == "Licenciatura")
      $user->abreviatura_grado = "Lic.";
    else if ($request->grado == "Ingeniería")
      $user->abreviatura_grado = "Ing.";
    else if ($request->grado == "Maestría" and $request->genero == "masculino")
      $user->abreviatura_grado = "Mtro.";
    else if ($request->grado == "Maestría" and $request->genero == "femenino")
      $user->abreviatura_grado = "Mtra.";
    else if ($request->grado == "Doctorado" and $request->genero == "masculino")
      $user->abreviatura_grado = "Dr.";
    else if ($request->grado == "Doctorado" and $request->genero == "femenino")
      $user->abreviatura_grado = "Dra.";
    else
      $user->abreviatura_grado = "";
    $user->email = $request->email;
    $user->genero = $request->genero;
    $user->semblanza_corta = $request->semblanza_corta;
    $user->facebook = $request->facebook;
    $user->unam = (int)$request->unam;
    $user->numero_trabajador = $request->numero_trabajador;
    if ($user->unam == 1 and $request->facultad_id != 0) {
      $user->procedencia = null;
      $user->facultad_id = $request->facultad_id;
    } else {
      $user->procedencia = $request->procedencia;
      $user->facultad_id = null;
    }

    $bandera = FALSE;
    $bandera2 = FALSE;
    if ($user->rfc != "")
      $bandera = Profesor::where('rfc', $user->rfc)->exists();
    if ($user->numero_trabajador != "")
      $bandera2 = Profesor::where('numero_trabajador', $user->numero_trabajador)->exists();

    if ($bandera or $bandera2) {
      return redirect()->back()->with('danger', 'Datos incorrectos. Alguno de los datos ingresados ya esta registrado en el sistema');
    } else {
      $user->save();
      $fac_ing = Facultad::where('nombre', '=', 'Facultad de Ingeniería')->first();
      if ($user->facultad_id == $fac_ing->id) {
        $num_carreras = Carrera::count();
        $num_divisiones = Division::count();
        for ($i = 0; $i < $num_carreras; $i++) {
          $value = $request->{"carrera_option" . $i};
          if (!is_null($value)) {
            $profesor_carrera = new ProfesoresCarreras;
            $profesor_carrera->id_profesor = $user->id;
            $profesor_carrera->id_carrera = $value;
            $profesor_carrera->save();
          }
        }
        for ($i = 0; $i < $num_divisiones; $i++) {
          $value = $request->{"division_option" . $i};
          if (!is_null($value)) {
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

      return redirect()->route('profesor.consulta')->with('success', 'Se ha dado de alta al profesor');
    }
  }

  public function generarhistorial($id)
  {
    $profesor = Profesor::findOrFail($id);
    $cursos = Curso::leftJoin('participante_curso', 'participante_curso.curso_id', 'cursos.id')
      ->where('participante_curso.profesor_id', $id)
      ->where('participante_curso.acreditacion', TRUE)
      ->select('cursos.*')->get();
    $datos = array("profesor" => $profesor, "cursos" => $cursos);
    $pdf = PDF::loadView("pages.pdf.historialprofesor", $datos)
      ->setPaper('letter');
    return $pdf->download('HistorialProfesor' . $id . '.pdf');
  }
}
