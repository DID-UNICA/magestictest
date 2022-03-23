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
                <h3>Catálogo de cursos</h3>

                {!! Form::open(["route" => "catalogo-cursos.consulta", "method" => "POST"]) !!}
                {{ csrf_field() }}
                <div class="input-group">
                    {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Curso"])!!}
                    {!! Form::select('type', array(
                      'nombre' => 'Por nombre',
                      'clave' => 'Por clave',
                      'coordinacion' => 'Por coordinación',),
                      null,['class' => 'btn dropdown-toggle pull-left'] ) !!}
                    {!! Form::close() !!}
                    <span class="input-group-btn col-md-2">
                         <button class="btn btn-search " type="submit">Buscar</button>
                    </span>
                </div>
            </div>
            <div class="panel-body tablaFija">

                <table class="col-md-12">
                    <tr>
                        <th>Clave</th>
                        <th>Nombre del curso</th>
                        <th>Coordinación</th>

                    </tr>
                    @foreach($users as $user )
                        <tr>
                            <td>{{$user->clave_curso}}</td>
                            <td>{{$user->nombre_curso}}</td>
                            <td>{{$user->getCoordinacion()}}</td>
                            <td><a href="{{ URL::to('curso/nuevo', $user->id) }}" style="margin: 10px;" class="btn btn-success">Dar de alta</a>
                                <a href="{{ URL::to('catalogo-cursos', $user->id) }}" style="margin: 10px;" class="btn btn-info">Detalles</a>
                                <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$user->clave_curso}}">Dar de baja</button>
                            </td>
                        </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$user->clave_curso}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Curso</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar el curso {{$user->nombre_curso}}, con clave: {{$user->clave_curso}}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('catalogo-cursos/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                </table>
            </div>
    </section>
@endsection

