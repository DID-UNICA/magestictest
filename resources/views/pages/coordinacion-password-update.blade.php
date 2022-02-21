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
                <h1>{{ $user->nombre_coordinacion }}</h1>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="row col-md-12 ">{!! Form::open(['route' => array('coordinacion.updatepass', $user->id), "method" => "PUT"]) !!}

                        <div class="form-group col-md-4">
                            {!!Form::label("password", "Nueva Contraseña:")!!}
                            {!!Form::text("password", null, [ "class" => "form-control", "placeholder" => "Password", "required",""])!!}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
                            <a href="{{ URL::to('coordinacion',$user->id) }}" class="btn btn-danger">Regresar</a>

                        </div>
                        {!! Form::close() !!}
                    </div>



                </div>

    </section>

@endsection

