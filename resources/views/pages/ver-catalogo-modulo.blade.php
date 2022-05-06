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
        <h1>Módulo</h1>
        <h2>{{ $modulo->nombre_curso }} </h2>
      </div>
      <div class="panel-body">
        <div class="row col-md-12 ">
          <div class="form-group col-md-3">
            {!!Form::label("clave_curso", "Clave:")!!}
            {!!Form::text("clave_curso",$modulo->clave_curso , [ "class" => "form-control", "required","disabled"])!!}
          </div>
          <div class="form-group col-md-9">
            {!!Form::label("nombre_curso", "Nombre del curso:")!!}
            {!!Form::text("nombre_curso", $modulo->nombre_curso, [ "class" => "form-control", "required","disabled"])!!}
          </div>
        </div>
        <div class="row col-md-12 ">
          <div class="form-group col-md-3">
            {!!Form::label("duracion_curso", "Duración del curso:")!!}
            {!!Form::text("duracion_curso", $modulo->duracion_curso, [ "class" => "form-control", "required","disabled"])!!}
          </div>
          <div class="form-group col-md-3">
            {!!Form::label("coordinacion_id", "Coordinación:")!!}
            {!!Form::text("coordinacion_id", $modulo->getCoordinacion(), [ "class" => "form-control", "required","disabled"])!!}
          </div>
          <div class="form-group col-md-3">
            {!!Form::label("tipo", "Tipo:")!!}
            {!!Form::select('tipo', array('D' => 'Módulo de diplomado'),$modulo->tipo, ['id' =>'tipoT', "disabled", 'class'=>'form-control']) !!}
          </div>
          <div class="form-group col-md-3">
            {!!Form::label("institucion", "Institución:")!!}
            {!!Form::select('institucion', array('DGAPA' => 'DGAPA','CDD' => 'Centro de Docencia'),$modulo->institucion, ["disabled", 'class'=>'form-control']) !!}
          </div>
        </div>
        <div class="row col-md-12 ">
          <div class="form-group col-md-5">
            {!!Form::label("dirigido", "Dirigido a:")!!}
            {!!Form::textarea("dirigido", $modulo->dirigido, [ "class" => "form-control", "required","disabled"])!!}
          </div>
          <div class="form-group col-md-5">
            {!!Form::label("objetivo", "Objetivo:")!!}
            {!!Form::textarea("objetivo", $modulo->objetivo, [ "class" => "form-control", "required","disabled"])!!}
          </div>
        </div>
        <div class="row col-md-12 ">
          <div class="form-group col-md-5">
            {!!Form::label("contenido", "Contenido:")!!}
            {!!Form::textarea("contenido", $modulo->contenido, [ "class" => "form-control", "required","disabled"])!!}
          </div>
          <div class="form-group col-md-5">
            {!!Form::label("antecedentes", "Antecedentes:")!!}
            {!!Form::textarea("antesc", $modulo->antecedentes, [ "class" => "form-control", "required","disabled"])!!}
          </div>
        </div>
        <div class="row col-md-12 ">
          <div class="form-group col-md-3">
            {!!Form::label("fecha_disenio", "Fecha de diseño:")!!}
            {!!Form::date("fecha_disenio",$modulo->fecha_disenio , [ "class" => "form-control", "required","disabled"])!!}
          </div>
          <div class="form-group col-md-5">
            <a style='margin: 3px;' href="{{ route('catalogo.modulo.consulta') }}" class="btn btn-warning">Regresar</a>
            <a style='margin: 3px;' href="{{ route('catalogo.modulo.edit', $modulo->id) }}" class="btn btn-info">Actualizar información</a>
            <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$modulo->id}}">Dar de baja</button>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="myModal{{$modulo->id}}" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminar Catálogo de Módulo</h4>
            </div>
            <div class="modal-body">
              <p>¿Está seguro de eliminar el catálogo de módulo {{ $modulo->nombre_curso }}?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
              <a href="{{ route('catalogo.modulo.delete', $modulo->id) }}" class="btn btn-danger">Dar de baja</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection
