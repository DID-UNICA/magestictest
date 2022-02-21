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
                    <h3>Carreras</h3>
                    </span>
                </div>
            </div>
            <div class="panel-body tablaFija" >

                <table class="col-md-12" >
                    <tr>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->clave }} </td>
                            <td>{{ $user->nombre }} </td>

                            <td><a href="{{ URL::to('carrera/actualizar', $user->id) }}" style="margin: 10px;" class="btn btn-info">Modificar</a>
                                <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$user->id}}">Dar de baja</button></td>
                        </tr>
                        <!-- Modal -->
                    <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Carrera</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar la carrera {{ $user->clave }} {{ $user->nombre }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('carrera/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                </table>




            </div>

        </section>

@endsection

