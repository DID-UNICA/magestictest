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
                    <h3>Temas Seminario</h3>
                </div>
     </div>
                <div class="panel-body">
        <form class="form-vertical" method="POST" action="{{ route('temas.update', [$catalogo_id, $num_temas]) }}">
        {{ csrf_field() }}
          @for($i = 0; $i < intval($num_temas); $i++)
          <div class="form-group">
          <div class="col-md-6">
            {!! Form::label('namet'.$i, 'Nombre del Tema:',["class" =>"form-group"]);!!}
            @if(isset($temas[$i]))
                {!! Form::text('nombre'.$i, $temas[$i]->nombre,["class" => "col-md-4 form-control", "placeholder" => "Tema",'required' => 'required']);!!}
            @else
                {!! Form::text('nombre'.$i, null,["class" => "col-md-4 form-control", "placeholder" => "Tema",'required' => 'required']);!!}
            @endif
          </div>
          <div class="col-md-6" style="padding: 2px;">
            {!! Form::label('durat'.$i, 'Duración (Hrs.):',["class" =>"form-group"]);!!}
            @if(isset($temas[$i]))
                {!! Form::number('duracion'.$i, $temas[$i]->duracion,["class" => "col-md-4 form-control", "placeholder" => "Duración",'required' => 'required', 'min'=>1]);!!}
            @else
                {!! Form::number('duracion'.$i, null,["class" => "col-md-4 form-control", "placeholder" => "Duración",'required' => 'required','min'=>1]);!!}
            @endif
          </div>
          </div>
          @endfor
          <button type="submit" class="btn btn-primary btn-sm col-md-1" style="margin:15px;">Guardar</button>
        </form>
</div>
@endsection