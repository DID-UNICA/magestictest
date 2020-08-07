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
      <div class="panel panel-default">
      @include ('partials.messages')
                <div class="panel-heading">
                      <h1>{{ $user->sede }}</h1>
                </div>
                <div class="panel-body">



 
<div class="row">{!! Form::open(['route' => array('salon.actualizar', $user->id), "method" => "PUT"]) !!}
  <div class="row col-md-12 ">
    <div class="form-group col-md-4">
      {!!Form::label("sede", "Sede")!!}
      {!!Form::text("sede", $user->sede, [ "class" => "form-control", "placeholder" => "Sede", "required",""])!!}
    </div>

    <div class="form-group col-md-4">
      {!!Form::label("capacidad", "Capacidad")!!}
      {!!Form::text("capacidad", $user->capacidad, [ "class" => "form-control", "placeholder" => "Capacidad", "required",""])!!}
    </div>

    <div class="form-group col-md-4">
      {!!Form::label("ubicacion", "Ubicacion")!!}
      {!!Form::text("ubicacion", $user->ubicacion, [ "class" => "form-control", "placeholder" => "Ubicacion", "required",""])!!}
    </div>
  </div>

  <div class="form-group col-md-6">
    {!!Form::label("sigla", "Sigla")!!}
    {!!Form::text("sigla", $user->sigla, [ "class" => "form-control", "placeholder" => "Sigla", "required",""])!!}
  </div>

  
 <div>
    <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
  </div>
  {!! Form::close() !!}
           
    
</div>


      </div>

     </section>
     
@endsection