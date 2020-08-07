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

<div class="row">
<div class="row">
  <div class="row col-md-12 ">
    <div class="form-group col-md-4">
      {!!Form::label("sede", "Sede")!!}
      {!!Form::text("Sede", $user->sede, [ "class" => "form-control", "placeholder" => "Sede", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4">
      {!!Form::label("capacidad", "Capacidad")!!}
      {!!Form::text("capacidad", $user->capacidad, [ "class" => "form-control", "placeholder" => "Capacidad", "required","disabled"])!!}
    </div>

    <div class="form-group col-md-4">
      {!!Form::label("ubicacion", "Ubicacion")!!}
      {!!Form::text("ubicacion", $user->ubicacion, [ "class" => "form-control", "placeholder" => "Ubicacion", "required","disabled"])!!}
    </div>
  </div>

  <div class="form-group col-md-6">
    {!!Form::label("sigla", "Sigla")!!}
    {!!Form::text("sigla", $user->sigla, [ "class" => "form-control", "placeholder" => "Sigla", "required","disabled"])!!}
  </div>

  

 <td><a href="{{ URL::to('salon/actualizar', $user->id) }}" class="btn btn-info">Actualiza información</a>
            <a href="{{ URL::to('salon/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a></td>
    
</div>



      </div>

     </section>
     
@endsection