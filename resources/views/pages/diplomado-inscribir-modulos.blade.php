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
                <h2>{{ $diplomado->nombre_diplomado}}</h2>
                <h3>Lista de Módulos</h3>
                  {!! Form::open(["route" => ["modulo.search.diplomado", $diplomado->id], "method" => "POST"]) !!}
                  {{ csrf_field() }}
                <div class="input-group">
                    {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Módulo"])!!}
                    {!! Form::select('type', array(
                      'nombre_curso' => 'Por nombre',
                      'titular' => 'Por instructor',
                      'clave' => 'Por clave'),
                      null,['class' => 'btn dropdown-toggle pull-left', 'style' => 'margin-top:3px'] ) !!}
                    <span class="col-md-6" style='padding-top:3px'>
                        <button class="btn btn-info" type="submit">Buscar</button>
                          <a href="{{ route('diplomado.consulta') }}" class="btn btn-danger">Regresar</a>
                    </span>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="panel-body tablaFija">
                <table class="col-md-6">
                    <tr>
                      <th style='text-align:center;'>Módulos programados</th>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Periodo</th>
                    </tr>
                      @foreach($modulos as $modulo)
                        {!! Form::open(array('class' => 'form-horizontal', 'role' =>'form', 'route'=> ['diplomado.modulo.create', $diplomado->id,$modulo->id] ,'files' => true, 'method' => 'POST' )) !!}
                        {{ csrf_field() }}
                          <tr>
                              <td>{{ $modulo->getNombreCurso() }}</td>
                              <td>{{ $modulo->getSemestre()}}</td>
                              <td>
                                  <button class="btn btn-success" style="margin-bottom: 15px;" type="submit">Asignar</button>
                              </td>
                          </tr>
                      {!! Form::close() !!}
                      @endforeach
                </table>

                <table class="col-md-6">
                    <tr>
                      <th style='text-align:center;'>Módulos asignados</th>
                    </tr>
                    <tr>
                        <th>Número de módulo</th>
                        <th>Nombre</th>
                        <th>Periodo</th>
                    </tr>
                    @foreach($modulos_dip as $modulo_dip)
                      {!! Form::open(array('class' => 'form-horizontal', 'role' =>'form', 'route'=> ['diplomado.modulo.delete',$diplomado->id, $modulo_dip->id] ,'files' => true, 'method' => 'GET' )) !!}
                        <tr>
                          <td>{{ $modulo_dip->num_modulo }}
                          <td>{{ $modulo_dip->getNombreCurso() }}</td>
                          <td>{{ $modulo_dip->getSemestre() }}</td>
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
