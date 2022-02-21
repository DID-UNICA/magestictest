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
                <h3>Categoría y Nivel</h3>
                <a href="{{ URL::to('categoria-nivel/nuevo')}}" class="btn btn-primary">Crear</a>
            </div>
        </div>
            <div class="panel-body tablaFija">
                <table class="col-md-12">
                    <tr>
                        <th>Categoría</th>
                        <th>Abreviatura</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->categoria }} </td>
                            <td>{{ $user->abreviatura}}</td>
                            <td><a href="{{ URL::to('categoria-nivel/actualizar', $user->id) }}" style="margin: 10px;" class="btn btn-info">Editar</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"  style="margin: 10px;" data-target="#myModal{{$user->id}}">Eliminar</button>
                            </td>
                        </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Categoría</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar la categoria {{ $user->categoria }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('categoria-nivel/baja', $user->id) }}" class="btn btn-danger">Eliminar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach

                </table>




            </div>

    </section>

@endsection