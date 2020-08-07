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
      <div class="panel panel-default">
                <div class="panel-heading">
                @include ('partials.messages')
                    <h3>Asignar los Temas del Seminario</h3>
                </div>
     </div>
                <div class="panel-body">
        <form class="form-vertical" method="POST" action="{{ route('profesorts.store.save', $curso_id) }}">
        {{ csrf_field() }}     
          <div class="form-group">
          <div class="col-md-6">
            {!! Form::label('namet', 'Nombre del Tema:',["class" =>"form-group"]);!!}
          </div>
          <div class="col-md-6" style="padding: 2px;">
            {!! Form::label('proft', 'Expositor:',["class" =>"form-group"]);!!}
          </div>
        @foreach($temas as $tema)
          <div class="col-md-6">
            {!! Form::label('namet', $tema->nombre,["class" =>"form-group"]);!!}
            {!! Form::hidden('tema'.$loop->index, $tema->id) !!}
          </div>
          <div class="btn-group col-md-6" style="padding: 2px;">
            {!! Form::select('proft'.$loop->index, $profesores,null ,["class" =>"btn btn-default dropdown-toggle"]);!!}
          </div>
        @endforeach
          </div>
          <button type="submit" class="btn btn-primary btn-sm col-md-1" style="margin:15px;">Guardar</button>
        </form>
</div>
@endsection