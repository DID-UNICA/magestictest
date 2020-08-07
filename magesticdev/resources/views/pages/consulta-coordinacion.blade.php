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
     @if(session()->has('msjMalo'))
        <div class="alert alert-danger" role='alert'>{{session('msjMalo')}}</div>
      @endif
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
            @include ('partials.messages')
                <h3>Coordinaciones</h3> 
                </div>
            </div>
            <div class="panel-body">

                <table class="col-md-12 col-sm-6">
                    <tr>
                        <th>Nombre</th>
                        <th>Abreviatura</th>
                        <th>Coordinador</th>
                        <th></th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->nombre_coordinacion }} </td>
                            <td>{{ $user->abreviatura }} </td>
                            <td>{{ $user->coordinador}}</td>
                            <td><a href="{{ URL::to('coordinacion', $user->id) }}" style="margin: 10px;" class="btn btn-info">Detalles</a></td>
                            <td><button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$user->id}}">Dar de baja</button></td>
                        </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Coordinación</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar la coordinación {{ $user->nombre_coordinacion }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('coordinacion/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>

                          </div>
                        </div>
                      </div>
                    </div>

                    @endforeach
                </table>




            </div>

    </section>

@endsection

