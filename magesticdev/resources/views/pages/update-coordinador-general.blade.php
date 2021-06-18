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
                <h1>Coordinador General</h1>
                <h2>{{ $user->coordinador }}</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div>
                        {!! Form::open(['route' => array('coordinador-general.actualizar', $user->id), "method" => "PUT"]) !!}
                        
                        <div class="form-group col-md-4">
                            {!!Form::label("coordinador", "Coordinador:")!!}
                            {!!Form::text("coordinador", $user->coordinador, [ "class" => "form-control", "placeholder" => "coordinador", "required",""])!!}
                        </div>
                        <div class="form-group col-md-6">
                          <div>
                            {!!Form::label("genero_l", "Género:")!!}
                          </div>
                          <div>
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
                            {!!Form::label("comentarios", "Comentarios:")!!}
                            {!!Form::text("comentarios", $user->comentarios, [ "class" => "form-control", "placeholder" => "comentarios", ""])!!}
                        </div>
                        <div class="form-group col-md-4">
                            {!!Form::label("grado", "Abreviatura de Grado:")!!}
                            {!!Form::text("grado", $user->grado, [ "class" => "form-control", "placeholder" => "Abreviatura", "required",""])!!}
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
    </section>

@endsection
