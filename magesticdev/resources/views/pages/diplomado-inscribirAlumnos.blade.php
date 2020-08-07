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
     @if(session()->has('msj'))
        <div class="alert alert-success" role='alert'>{{session('msj')}}</div>
      @endif
     @if(session()->has('msjMalo'))
        <div class="alert alert-danger" role='alert'>{{session('msjMalo')}}</div>
      @endif
    <br>
      <div class="panel panel-default">
      @include ('partials.messages')
      <div class="panel-heading">
            <h1>Diplomado: {{ $diplomado->nombre_diplomado }}</h1>
            <h2>Inscripción de Alumnos</h2>
            <h3>Cupo maximo: {{$count}}/{{$cupo}}</h3>
            <div class="input-group">
            {!! Form::open(["route" => ["diplomado.buscarCandidatos", $diplomado->id], "method" => "GET"]) !!}
              {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Profesor"])!!}
              {!! Form::select('type', array(
                'nombre' => 'Por nombre',
                'correo' => 'Por correo',
                'rfc' => 'Por RFC',
                  'num' => 'Por número trabajador'),
                null,['class' => 'btn dropdown-toggle pull-left'] ) !!}
              {!!Form::hidden('count',$count)!!}
              {!!Form::hidden('cupo',$cupo)!!}
              {!!Form::hidden('diplomado_id',$diplomado->id)!!}
            {!! Form::close() !!}
            <button class="btn btn-search " type="submit">Buscar</button>
            <a href="{{ URL::to('diplomado') }}" class="btn btn-info">Regresar</a>
          </div>


      </div>
      <div class="panel-body">
      <table class="col-md-12">
          <tr>
              <th>Nombre</th>
              <th>Correo</th>
              <th>RFC</th>
          </tr>
          @foreach($profesores as $profesor)
          {!! Form::open(array('class' => 'form-horizontal', 'role' =>'form', 'route'=> ['diplomado.registrar', $profesor->id,$diplomado->id] ,'files' => true, 'method' => 'POST' )) !!}
              <tr>
                  <td>{{ $profesor->nombres }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</td>
                  <td>{{ $profesor->email}}</td>
                  <td>{{ $profesor->rfc}}</td>
                  <td><button class="btn btn-success" type="submit">Dar de Alta</button></td>
              </tr>
              {!! Form::close() !!}
          @endforeach
      </table>
      </div>


      </div>

     </section>

@endsection