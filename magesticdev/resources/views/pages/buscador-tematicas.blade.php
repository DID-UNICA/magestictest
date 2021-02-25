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
    @if(session()->has('msj'))
            <div class="alert alert-danger" role='alert'>{{session('msj')}}</div>
    @endif
    <div class="panel panel-default">
    @include ('partials.messages')
      <div class="panel-heading">
        <div class="container">
          <h3>Búsqueda de palabras clave</h3>
          {!! Form::open(["route" => ["formatos.correos",$curso_id,"B2"], "method" => "POST"]) !!}
            <div class="col-md-12">
              <div class="form-group">
                <label for="words">Ingrese palabras clave (Separadas por #):</label>
                <input type="text" class="form-control" id="words" name=words 
                  required placeholder="#palabra1 #palabra2">
              </div>
              <input class="btn btn-primary" type="submit" value="Generar Formato">
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
@endsection
