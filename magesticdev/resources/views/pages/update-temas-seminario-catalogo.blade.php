@extends('layouts.principal')

@section('contenido')
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
            <h3>Temas del Seminario</h3>
        </div>
     </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('temas-catalogo.create', $ct) }}">
        {{ csrf_field() }}
          <div class="row form-group" style="margin-bottom: 25px;">
            <div class="col-md-2">
              {!! Form::label('namen', 'Añadir Nuevo Tema:', ["class"=>"form-group"]);!!}
            </div>
            <div class="col-md-5">
              {!! Form::text('namen',null, ["class"=>"form-control",'required', "placeholder"=>"Nombre del tema"]);!!}
            </div>
            <div class="col-md-1">
              {!! Form::label('duracion', 'Duración:', ["class"=>"form-group"]);!!}
            </div>
            <div class="col-md-1">
              {!! Form::number('duracion',null, ["class"=>"form-control",'required', "placeholder"=>"#", "min"=>"1"]);!!}
            </div>
            <div class="col-md-2">
              <button type="submit" style='margin: 3px;' class="btn btn-success">Añadir</a>
            </div>
          </div>
        </form>
        @if($ts->isNotEmpty())
          <div class="row form-group">
                <div class="col-md-5">
                  {!! Form::label('name', 'Nombre del Tema:',["class" =>"form-group"]);!!}
                </div>
                <div class="col-md-2">
                  {!! Form::label('duracion', 'Duración del Tema:',["class" =>"form-group"]);!!}
                </div>
          </div>
            @foreach ($ts as $tema_seminario)
              <form class="form-vertical" method="POST" action="{{ route('temas-catalogo.update', [$tema_seminario->id]) }}">
              {{ csrf_field() }}
                <div class="row form-group">
                  <div class="col-md-5">
                    {!! Form::text('name', $tema_seminario->nombre,["class" => "col-md-4 form-control", "placeholder" => "Tema",'required' => 'required']);!!}
                  </div>
                  <div class="col-md-2">
                    {!! Form::number('duracion', $tema_seminario->duracion,["class" => "col-md-4 form-control", "placeholder" => "#",'required' => 'required',"min"=>"1"]);!!}
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-info">Guardar</button>
                    <a href="{{ URL::to('catalogo-cursos/actualizar-temas-seminario/delete', $tema_seminario->id) }}" class="btn btn-danger">Eliminar</a>
                  </div>
                </div>
              </form>
            @endforeach
        @else
          Aún no hay temas registrados.
        @endif
          <div class="row form-group" style="margin: 15px;">
            <div class="col-md-6">
              <a href="{{ URL::to('catalogo-cursos') }}" class="btn btn-warning">Regresar</a>
            </div>
          </div>
      </div>
@endsection