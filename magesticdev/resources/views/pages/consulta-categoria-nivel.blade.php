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
        <div class="panel panel-default">
        @include ('partials.messages')
            <div class="panel-heading">
                <h3>Categoría y Nivel</h3>

            </div>
        </div>
        <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('categoria.store') }}">
                        {{ csrf_field() }}



                        <div class="form-group{{ $errors->has('categoria') ? ' has-error' : '' }}">
                            <label for="categoria" class="col-md-4 control-label">Nombre de la Categoría o Nivel</label>

                            <div class="col-md-6">
                                <input id="categoria" type="text" class="form-control" name="categoria" value="{{ old('catgeoria') }}"  required>

                                @if ($errors->has('categoria'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoria') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('abreviatura') ? ' has-error' : '' }}">
                            <label for="abreviatura" class="col-md-4 control-label">Abreviatura de la Categoría o Nivel</label>

                            <div class="col-md-6">
                                <input id="abreviatura" type="text" class="form-control" name="abreviatura" value="{{ old('abreviatura') }}" required >

                                @if ($errors->has('abreviatura'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('abreviatura') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Categoría
                                </button>
                            </div>
                        </div>
                    </form>
            <div class="panel-body">
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