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
                <h1>Curso</h1>
                <h2>{{ $user->nombre_curso }} </h2>
            </div>
            <div class="panel-body">




                <div class="row">
                    <div class="row">
                        <div class="row col-md-12 ">

                        <div class="form-group col-md-6">
                            {!!Form::label("clave_curso", "Clave:")!!}
                            {!!Form::text("clave_curso",$user->clave_curso , [ "class" => "form-control", "required","disabled"])!!}
                        </div>

                            <div class="form-group col-md-4">
                                {!!Form::label("nombre_curso", "Nombre del curso:")!!}
                                {!!Form::text("nombre_curso", $user->nombre_curso, [ "class" => "form-control", "required","disabled"])!!}
                            </div>
                            <div class="form-group col-md-4">
                                {!!Form::label("duracion_curso", "Duración del curso:")!!}
                                {!!Form::text("duracion_curso", $user->duracion_curso, [ "class" => "form-control", "required","disabled"])!!}
                            </div>

                            <div class="form-group col-md-4">
                                {!!Form::label("coordinacion_id", "Coordinación:")!!}
                                {!!Form::text("coordinacion_id", $user->getCoordinacion(), [ "class" => "form-control", "required","disabled"])!!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            {!!Form::label("tipo", "Tipo:")!!}
                            {!!Form::select('tipo', array('S' => 'Seminario','CT' => 'Curso-Taller',  'T' => 'Taller','F' => 'Foro', 'C' => 'Curso','E' => 'Evento', 'D' => 'Módulo de diplomado'),$user->tipo, ["disabled", 'class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!!Form::label("institucion", "Institución:")!!}
                            {!!Form::select('institucion', array('DGAPA' => 'DGAPA','CDD' => 'Centro de Docencia'),$user->institucion, ["disabled", 'class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!!Form::label("presentacion", "Presentación:")!!}
                            {!!Form::text("presentacion", $user->presentacion, [ "class" => "form-control", "required","disabled"])!!}
                        </div>

                        <div class="form-group col-md-6">
                            {!!Form::label("dirigido", "Dirigido a:")!!}
                            {!!Form::textarea("dirigido", $user->dirigido, [ "class" => "form-control", "required","disabled"])!!}
                        </div>

                        <div class="form-group col-md-6 ">
                            {!!Form::label("objetivo", "Objetivo:")!!}
                            {!!Form::textarea("objetivo", $user->objetivo, [ "class" => "form-control", "required","disabled"])!!}
                        </div>


                        <div class="form-group col-md-6">
                            {!!Form::label("contenido", "Contenido:")!!}
                            {!!Form::textarea("contenido", $user->contenido, [ "class" => "form-control", "required","disabled"])!!}
                        </div>
                        <div class="form-group col-md-6">
                            {!!Form::label("antescedentes", "Otros antecedentes:")!!}
                            {!!Form::textarea("antesc", $user->previo, [ "class" => "form-control", "required","disabled"])!!}
                        </div>

                        <div class="form-group col-md-6">
                            {!!Form::label("fecha_disenio", "Fecha de diseño:")!!}
                            {!!Form::date("fecha_disenio",$user->fecha_disenio , [ "class" => "form-control", "required","disabled"])!!}
                        </div>

                        <td>
                            <a href="{{ URL::to('catalogo-cursos') }}" class="btn btn-info">Regresar</a>
                            <a href="{{ URL::to('catalogo-cursos/ver-antescedentes',$user->id) }}" class="btn btn-primary">Ver Antecedentes</a>
                            <a href="{{ URL::to('catalogo-cursos/actualizar', $user->id) }}" class="btn btn-primary">Actualizar información</a>
                            <a href="{{ URL::to('catalogo-cursos/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a></td>

                    </div>



                </div>

    </section>

@endsection

