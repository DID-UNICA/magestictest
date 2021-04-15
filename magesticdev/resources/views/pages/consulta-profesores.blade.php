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
              <h3>Lista de profesores</h3>
              {!! Form::open(["route" => "profesor.consulta", "method" => "GET"]) !!}
              <div class="input-group">
                  {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Profesor"])!!}
                  {!! Form::select('type', array(
                         'nombre' => 'Por nombre',
                         'correo' => 'Por correo',
                         'rfc' => 'Por RFC',
                         'num' => 'Por número trabajador'),
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
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>RFC</th>
                      <th>Número Trabajador</th>
                  </tr>
                  @foreach($users->sortBy('apellido_paterno') as $user)
                      <tr>
                          <td> {{ $user->apellido_paterno }} {{ $user->apellido_materno }} {{ $user->nombres }}</td>
                          <td>{{ $user->email}}</td>
                          <td>{{ $user->rfc}}</td>
                          <td align="center">{{ $user->numero_trabajador}}</td>
                          <td>
                              <a href="{{ URL::to('profesor/cursos', $user->id) }}" style="margin: 10px;" class="btn btn-warning">Cursos</a>
                              <a href="{{ URL::to('profesor', $user->id) }}" style="margin: 10px;" class="btn btn-info">Detalles</a>
                              <a href="{{ URL::to('historialprofesor', $user->id) }}" style="margin: 10px;" class="btn btn-success">Historial</a>
                              <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$user->id}}">Dar de baja</button>
                          </td>
                      </tr>
                  
                  <!-- Modal -->
                    <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Profesor</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar al profesor {{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('profesor/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>

                  @endforeach
              </table>
          </div>
     </section>
     
@endsection
  
