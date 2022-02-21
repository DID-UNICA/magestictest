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
                <h3>Escoger instructores del tema</h2>
                <h3>Lista de de instructores</h3>
                  {!! Form::open(["route" => ["profesor.consulta4", $curso->id, $tema_id], "method" => "POST"]) !!}
                <div class="input-group">
                    {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Profesor"])!!}
                    {!! Form::select('type', array(
                      'nombre' => 'Por nombre',
                      'correo' => 'Por correo',
                      'rfc' => 'Por RFC',
                        'num' => 'Por número trabajador'),
                      null,['class' => 'btn dropdown-toggle pull-left', 'style' => 'margin-top:3px'] ) !!}
                    <span class="col-md-6" style='padding-top:3px'>
                        <button class="btn btn-info" type="submit">Buscar</button>
                          <a href="{{ route('curso.consulta') }}" class="btn btn-danger">Regresar</a>
                    </span>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="panel-body tablaFija">
                <table class="col-md-6">
                    <tr>
                      <th style='text-align:center;'>Profesores</th>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Fecha de exposición</th>
                        <th>Número Trabajador</th>
                    </tr>
                    @foreach($profesores as $profesor)
                        {!! Form::open(array('class' => 'form-horizontal', 'role' =>'form', 'route'=> ['curso.altaInstructorSeminario', $curso->id,$profesor->id, $tema_id] ,'files' => true, 'method' => 'POST' )) !!}
                        <tr>
                            <td>{{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }} {{ $profesor->nombres }}</td>
                            <td>{{ $profesor->email}}</td>
                            <td>
                              {!! Form::date('fecha_exposicion',null, array('class'=>'form-control form-horizontal','required'))!!}
                            </td>
                            <td>{{ $profesor->numero_trabajador}}</td>
                            <td>
                                <button class="btn btn-success" style="margin-bottom: 15px;" type="submit">Asignar</button>
                            </td>
                        </tr>
                    {!! Form::close() !!}
                    @endforeach
                </table>

                <table class="col-md-6">
                    <tr>
                      <th style='text-align:center;'>Instructores</th>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Fecha asignada</th>
                        <th>Número Trabajador</th>
                    </tr>
                    @foreach($instructores as $instructor)
                        {!! Form::open(array('class' => 'form-horizontal', 'role' =>'form', 'route'=> ['curso.bajaInstructorSeminario', $curso->id,$instructor->getProfesor()->id, $tema_id] ,'files' => true, 'method' => 'POST' )) !!}
                        <tr>
                            <td>{{ $instructor->getProfesor()->apellido_paterno }} {{ $instructor->getProfesor()->apellido_materno }} {{ $instructor->getProfesor()->nombres }}</td>
                            <td>{{ $instructor->getProfesor()->email}}</td>
                            <td>{{ $instructor->fecha_exposicion}}</td>
                            <td>{{ $instructor->getProfesor()->numero_trabajador}}</td>
                            <td>
                                <button class="btn btn-danger" style="margin-bottom: 15px;" type="submit">Eliminar</button>
                            </td>
                        </tr>
                    {!! Form::close() !!}
                    @endforeach
                </table>
            </div>
    </section>
@endsection
