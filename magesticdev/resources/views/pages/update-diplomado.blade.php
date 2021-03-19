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
                      <h1>Diplomado: {{ $diplomado->nombre_diplomado }}</h1>
                </div>
                <div class="panel-body">




<div class="row">
<div class="row">
  <div class="row col-md-12 ">{!! Form::open(['route' => array('diplomado.actualizar', $diplomado->id), "method" => "PUT"]) !!}
    <div class="col-md-12 row">
      <div class="form-group col-md-6">
          {!!Form::label("nombre", "Nombre:")!!}
        {!!Form::text("nombre", $diplomado->nombre_diplomado, [ "class" => "form-control", "placeholder" => "Nombre de Diplomado", "required"])!!}
      </div>
    <div class="form-group col-md-4">
      {!!Form::label("cupo_maximo", "Cupo Máximo:")!!}
      {!!Form::number("cupo_maximo", $diplomado->cupo_maximo, [ "oninvalid"=>"this.setCustomValidity('Ingrese un valor mayor a 0 por favor')", "oninput"=>"this.setCustomValidity('')", "class" => "form-control", "placeholder" => "Cupo Máximo", "required",'min'=>0])!!}
    </div>


    <div>
    <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
    <a href="{{ URL::to('diplomado', $diplomado->id) }}" class="btn btn-info">Regresar</a>

  </div>
  {!! Form::close() !!}
</div>



      </div>

     </section>

@endsection