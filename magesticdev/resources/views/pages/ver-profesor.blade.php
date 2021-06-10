<!-- Guardado en resources/views/pages/admin.blade.php -->

@extends('layouts.principal')

@section('contenido')
  <!--Body content-->

  <div class="content">
    <div class="top-bar">       
      <a href="#menu" class="side-menu-link burger"> 
        <span class='burger_inside' id='bgrOne'></span>
        <span class='burger_inside' id='bgrTwo'></span>
        <span class='burger_inside' id='bgrThree'></span>
      </a>      
    </div>
    <section class="content-inner">
    <br>
    @include ('partials.messages')
      <div class="panel panel-default">
                <div class="panel-heading">
                      <h1>{{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</h1>
                </div>
                <div class="panel-body">

  <div class="row col-md-12 ">
    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("nombre", "Nombre:")!!}
      {!!Form::text("nombre", $user->nombres, [ "class" => "form-control", "placeholder" => "Nombre", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("ap_pat", "Apellido Paterno:")!!}
      {!!Form::text("ap_pat", $user->apellido_paterno, [ "class" => "form-control", "placeholder" => "Apellido Paterno", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("ap_mat", "Apellido Materno:")!!}
      {!!Form::text("ap_mat", $user->apellido_materno, [ "class" => "form-control", "placeholder" => "Apellido Materno", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
        {!!Form::label("numero_trabajador", "Núm. Trabajador:")!!}
        {!!Form::text("numero_trabajador", $user->numero_trabajador, [ "class" => "form-control", "placeholder" => "Número de Trabajador", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("rfc", "RFC:")!!}
      {!!Form::text("rfc", $user->rfc, [ "class" => "form-control", "placeholder" => "RFC", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("fecha_nacimiento", "Fecha de Nacimiento:")!!}
      {!!Form::text("fecha_nacimiento", $user->fecha_nacimiento, [ "class" => "form-control", "placeholder" => "Fecha de nacimiento", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("genero", "Género:")!!}
      {!!Form::text("genero", $user->genero, [ "class" => "form-control", "placeholder" => "Genero", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("categoria_nivel_id", "Primer Categoría y Nivel:")!!}
      {!!Form::text("categoria_nivel_id", $user->getCategoria_1(), [ "class" => "form-control", "placeholder" => "Primer Categoría y nivel", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("categoria_nivel_2_id", "Segunda Categoría y Nivel:")!!}
      {!!Form::text("categoria_nivel_2_id", $user->getCategoria_2(), [ "class" => "form-control", "placeholder" => "Segunda Categoría y nivel", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("grado", "Grado:")!!}
      {!!Form::text("grado", $user->grado, [ "class" => "form-control", "placeholder" => "Grado", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("abreviatura_grado", "Abreviatura de grado:")!!}
      {!!Form::text("abreviatura_grado", $user->abreviatura_grado, [ "class" => "form-control", "placeholder" => "Abreviatura", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-3 col-sm-6">
      {!!Form::label("created_at", "Fecha de Alta:")!!}
      {!!Form::text("created_at", $user->created_at, [ "class" => "form-control", "placeholder" => "Fecha de alta", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("email", "Email:")!!}
      {!!Form::text("email", $user->email, [ "class" => "form-control", "placeholder" => "Email", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("telefono", "Número de Teléfono:")!!}
      {!!Form::text("telefono", $user->telefono, [ "class" => "form-control", "placeholder" => "Número de Teléfono", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("facebook", "Facebook:")!!}
      {!!Form::text("facebook", $user->facebook, [ "class" => "form-control", "placeholder" => "Facebook", "required","disabled"])!!}
    </div>
    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("unam_bool", "UNAM:")!!}
    @if($user->facultad_id)
      {!!Form::text("unam_bool", "Sí", [ "class" => "form-control", "placeholder" => "Sí", "required","disabled"])!!}
    </div>
    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("carrera", "Carrera(s):")!!}
      {!!Form::text("carrera", $user->getCarrerasPorNombre(), [ "class" => "form-control", "placeholder" => "Carrera", "required","disabled"])!!}
    </div>
    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("division", "Division(es):")!!}
      {!!Form::text("division", $user->getDivisionesPorNombre(), [ "class" => "form-control", "placeholder" => "Division", "required","disabled"])!!}
    </div>
    <div class="form-group col-md-4 col-sm-6">
      {!!Form::label("facultad", "Facultad:")!!}
      {!!Form::text("facultad", $user->getFacultad(), [ "class" => "form-control", "placeholder" => "Facultad", "required","disabled"])!!}
    </div>
    @else
      {!!Form::text("unam_bool", "No", [ "class" => "form-control", "placeholder" => "No", "required","disabled"])!!}
    </div>
    <div class="form-group col-md-8 col-sm-6">
      {!!Form::label("procedencia", "Procedencia:")!!}
      {!!Form::text("procedencia", $user->procedencia, [ "class" => "form-control", "placeholder" => "Procedencia", "required","disabled"])!!}
    </div>
    @endif

   <div class="form-group col-md-6 col-sm-6">
    {!!Form::label("semblanza_corta", "Semblanza corta:")!!}
    {!!Form::textarea("semblanza_corta", $user->semblanza_corta, [ "cols"=>"90", "wrap"=>"hard", "class" => "form-control", "placeholder" => "Semblanza", "required","disabled"])!!}
  </div>
<div class="row col-md-3 "> 
  <a href="{{ URL::to('profesor/actualizar', $user->id) }}" class="btn btn-info btn-block">Actualiza información</a>
  <a href="{{ URL::to('profesor/baja', $user->id) }}" class="btn btn-danger btn-block">Dar de baja</a>
</div>
</div>
</div>
</div>
@endsection
