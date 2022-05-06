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
        @if($user->genero === 'F')
        <h3>Coordinadora del Centro de Docencia</h3>
        @else
        <h3>Coordinador del Centro de Docencia</h3>
        @endif

      </div>
    </div>
    <div class="panel-body">
      <table class="col-md-12 container-fluid">
        @if($user->id != null)
        <tr>
          @if($user->genero === "F")
          <th>Coordinadora</th>
          @else
          <th>Coordinador</th>
          @endif
          <th>Género</th>
        </tr>
        <tr>
          <td>{{ $user->grado}} {{ $user->coordinador}}</td>
          @if($user->genero === 'F')
          <td>Femenino</td>
          @elseif($user->genero === 'M')
          <td>Masculino</td>
          @endif
        </tr>
        <tr>
          <td>
            <a href="{{ URL::to('coordinador-general/actualizar', $user->id) }}" style="margin: 10px;" class="btn btn-info">Editar</a>
            <button type="button" class="btn btn-danger" data-toggle="modal" style="margin: 10px;" data-target="#myModal{{$user->id}}">Eliminar</button>
          </td>
        </tr>
        @else
        <tr>
          <th>No hay un Coordinador del Centro de Docencia aún.</th>
        </tr>
        <tr>
          <td>
            <a href="{{route('coordinador-general.nuevo')}}" style="margin: 10px;" class="btn btn-success">Nuevo</a>
          </td>
        </tr>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Coordinador</h4>
              </div>
              <div class="modal-body">
                <p>¿Está seguro de eliminar al coordinador {{ $user->coordinador}}?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                <a href="{{ URL::to('coordinador-general/baja', $user->id) }}" class="btn btn-danger">Eliminar</a>
              </div>
            </div>
          </div>
        </div>

      </table>
    </div>

  </section>

  @endsection
