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
                <h1>{{ $user->nombre_coordinacion }}</h1>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="row col-md-12 ">{!! Form::open(['route' => array('coordinacion.actualizar', $user->id), "method" => "PUT"]) !!}

                        <div class="form-group col-md-4">
                            {!!Form::label("nombre_coordinacion", "Nombre de coordinación")!!}
                            {!!Form::text("nombre_coordinacion", $user->nombre_coordinacion, [ "class" => "form-control", "placeholder" => "Nombre", "required",""])!!}
                        </div>
                        <div class="form-group col-md-4">
                            {!!Form::label("abreviatura", "Abreviatura")!!}
                            {!!Form::text("abreviatura", $user->abreviatura, [ "class" => "form-control", "placeholder" => "Abreviatura", "required",""])!!}
                        </div>
                        <div class="form-group col-md-4">
                            {!!Form::label("coordinador", "Coordinador")!!}
                            {!!Form::text("coordinador", $user->coordinador, [ "class" => "form-control", "placeholder" => "Coordinador", "required",""])!!}
                        </div>
                        <div class="form-group col-md-4">
                          <div class="col-md-3">
                            {!!Form::label("genero_l", "Género:")!!}
                          </div>
                            <div class="col-md-3">
                              <div class="row">
                                <label class="radio-inline">
                                  @if($user->genero === 'M')
                                    <input id="genero_M" type="radio" name="genero" value = 'M' checked required>
                                  @else
                                    <input id="genero_M" type="radio" name="genero" value = 'M' required>
                                  @endif
                                  Masculino
                                </label>
                              </div>
                              <div class="row">
                                <label class="radio-inline">
                                  @if($user->genero === 'F')
                                    <input id="genero_F" type="radio" name="genero" value='F' checked>
                                  @else
                                    <input id="genero_F" type="radio" name="genero" value='F'>
                                  @endif
                                  Femenino
                                </label>
                              </div>
                            </div>
                          </div>
                        <div class="form-group col-md-4">
                            {!!Form::label("usuario", "Usuario")!!}
                            {!!Form::text("usuario", $user->usuario, [ "class" => "form-control", "placeholder" => "Usuario", "required",""])!!}
                        </div>
                        <div class="form-group col-md-8">
                            {!!Form::label("comentarios", "Comentario")!!}
                            {!!Form::text("comentarios", $user->comentarios, [ "class" => "form-control", "placeholder" => "Comentario", ""])!!}
                        </div>
                        <div class="form-group col-md-8">
                            {!!Form::label("grado", "Abreviatura de grado del Coordinador")!!}
                            {!!Form::text("grado", $user->grado, [ "class" => "form-control", "placeholder" => "Abreviatura", "required",""])!!}
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
                            <a href="{{ URL::to('coordinacion',$user->id) }}" class="btn btn-danger">Regresar</a>
                            <a href="{{ URL::to('coordinacion/password',$user->id) }}" class="btn btn-warning">Cambiar Contraseña</a>

                        </div>
                        {!! Form::close() !!}
                    </div>



                </div>

    </section>

@endsection

