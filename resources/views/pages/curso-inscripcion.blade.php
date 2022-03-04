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
                <h2>{{ $curso->getNombreCurso()}}</h2>
                <h3>Lista de profesores</h3>
                <h3>Cupo máximo: {{$count}}/{{$curso->cupo_maximo}}</h3><h3>Lista de espera: {{$lista}}</h3>
                @if($count >= $curso->cupo_maximo)<div class="alert alert-danger" role='alert'>El curso ya está lleno, las siguientes inscripciones entrarán a lista de espera.</div>@endif
                {!! Form::open(["route" => ["profesor.consulta1", $curso->id], "method" => "POST"]) !!}
                {{ csrf_field() }}
                <div class="input-group">
                    {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Profesor"])!!}
                    {!! Form::select('type', array(
                      'nombre' => 'Por nombre',
                      'correo' => 'Por correo',
                      'rfc' => 'Por RFC',
                        'num' => 'Por número trabajador'),
                      null,['class' => 'btn dropdown-toggle pull-left', 'style'=>'margin:5px;'] ) !!}
                    {!!Form::hidden('count',$count)!!}
                    {!!Form::hidden('cupo',$curso->cupo_maximo)!!}
                    {!!Form::hidden('curso',$curso)!!}
                    {!!Form::hidden('nombre_curso',$curso->getNombreCurso())!!}
                {!! Form::close() !!}
                    <div class="row form-group">
                         <button style="margin:5px;" class="btn btn-success " type="submit">Buscar</button>
                          @if($curso->getTipo() === 'D')
                            <a style="margin: 5px;" href="{{ route('modulo.consulta') }}" class="btn btn-info">Regresar</a>
                          @else
                            <a style="margin:5px;" href="{{ route('curso.consulta') }}" class="btn btn-info">Regresar</a>
                          @endif

                    </div>
                </div>
            </div>
            <div class="panel-body tablaFija">

                <table class="col-md-12">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>RFC</th>
                        <th>Número Trabajador</th>
                    </tr>
                    @foreach($users as $user)
                    {!! Form::open(array('class' => 'form-horizontal', 'role' =>'form', 'route'=> ['curso.registrar', $user->id,$curso->id] ,'files' => true, 'method' => 'POST' )) !!}
                    {{ csrf_field() }}
                        <tr>
                            <td>{{ $user->apellido_paterno }} {{ $user->apellido_materno }} {{ $user->nombres }}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->rfc}}</td>
                            <td>{{ $user->numero_trabajador}}</td>
                            <td>
                                <button class="btn btn-success" style="margin-bottom: 15px;" type="submit">Dar de Alta</button>
                            </td>
                        </tr>
                    {!! Form::close() !!}
                    @endforeach
                </table>
            </div>
    </section>
@endsection
