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
              <h1>Diplomado: {{ $diplomado->nombre_diplomado }}</h1>
        </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12 ">
            {!! Form::open(['route' => array('diplomado.update', $diplomado->id), "method" => "PUT"]) !!}
            <div class="col-md-12 row">
              <div class="form-group col-md-6">
                {!!Form::label("nombre", "Nombre:")!!}
                {!!Form::text("nombre", $diplomado->nombre_diplomado, [ "class" => "form-control", "placeholder" => "Nombre de Diplomado", "required"])!!}
              </div>
            <div>
            <div class="form-group col-md-12 row">
              <button type="submit" class="btn btn-info col-md-offset-1">Actualizar</button>
              <a href="{{ route('diplomado.consulta') }}" class="btn btn-danger">Regresar</a>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </section>
@endsection