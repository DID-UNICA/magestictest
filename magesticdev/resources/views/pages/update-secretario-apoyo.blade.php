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
        @include('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
            <h1>Secretario de Apoyo a la Docencia</h1>
                <h2>{{ $user->secretario }}</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="row col-md-12 ">
                        {!! Form::open(['route' => array('secretario-apoyo.actualizar', $user->id), "method" => "PUT"]) !!}
                        
                        <div class="form-group col-md-4">
                            {!!Form::label("secretario", "Secretario:")!!}
                            {!!Form::text("secretario", $user->secretario, [ "class" => "form-control", "placeholder" => "Secretario", "required",""])!!}
                        </div>

                        <div class="form-group col-md-4">
                            {!!Form::label("comentarios", "Comentarios:")!!}
                            {!!Form::text("comentarios", $user->comentarios, [ "class" => "form-control", "placeholder" => "Comentarios",""])!!}
                        </div>

                        <div class="form-group col-md-4">
                            {!!Form::label("grado", "Abreviatura de grado:")!!}
                            {!!Form::text("grado", $user->grado, [ "class" => "form-control", "placeholder" => "Abreviatura", "required",""])!!}
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
    </section>

@endsection
