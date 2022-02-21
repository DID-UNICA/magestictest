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
                      <h1>Actualizar</h1>
                      <h2>{{ $modulo->nombre_curso}}</h2>
                </div>
<div class="panel-body">
  <div>{!! Form::open(['route' => array('catalogo.modulo.update', $modulo->id), "method" => "PUT"]) !!}
	<div class="row col-md-12 ">
		<div class="form-group col-md-3">
        {!!Form::label("clave_curso", "Clave:")!!}
        {!!Form::text("clave_curso",$modulo->clave_curso , [ "class" => "form-control", "required", "maxlength"=>"25"])!!}
    </div>
		<div class="form-group col-md-9">
				{!!Form::label("nombre_curso", "Nombre del curso:")!!}
				{!!Form::text("nombre_curso", $modulo->nombre_curso, [ "class" => "form-control", "placeholder" => "Nombre del curso", "required"])!!}
		</div>
	</div>
	<div class="row col-md-12 ">
		<div class="form-group col-md-3">
				{!!Form::label("duracion_curso", "Duración del curso:")!!}
				{!!Form::text("duracion_curso", $modulo->duracion_curso, [ "class" => "form-control", "placeholder" => "Duracion_curso", "required"])!!}
		</div>
		<div class="form-group col-md-3">
				{!!Form::label("coordinacion_id", "Coordinación:")!!}
				{!!Form::select("coordinacion_id", $modulo->allCoordinacion()->pluck('nombre_coordinacion','id'),$modulo->getIdCoordinacion(),['class'=>'form-control'])!!}
		</div>
		<div class="form-group col-md-3">
				{!!Form::label("tipo", "Tipo:")!!}
				{!!Form::select('tipo', array('D' => 'Módulo de diplomado'),$modulo->tipo,['id' =>'tipoT', 'class'=>'form-control']) !!}
		</div>
		<div class="form-group col-md-3">
        {!!Form::label("institucion", "Institución:")!!}
        {!!Form::select('institucion', array('DGAPA' => 'DGAPA','CDD' => 'Centro de Docencia'),$modulo->institucion,['class'=>'form-control']) !!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div class="form-group col-md-5">
        {!!Form::label("dirigido", "Dirigido a:")!!}
        {!!Form::textarea("dirigido", $modulo->dirigido, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
		<div class="form-group col-md-5 ">
        {!!Form::label("objetivo", "Objetivo:")!!}
        {!!Form::textarea("objetivo", $modulo->objetivo, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div class="form-group col-md-5">
        {!!Form::label("contenido", "Contenido:")!!}
        {!!Form::textarea("contenido", $modulo->contenido, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
		<div class="form-group col-md-5">
        {!!Form::label("antecedentes", "Antecedentes:")!!}
        {!!Form::textarea("antesc", $modulo->antecedentes, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div class="form-group col-md-3">
        {!!Form::label("fecha_disenio", "Fecha de diseño:")!!}
        {!!Form::date("fecha_disenio",$modulo->fecha_disenio , [ "class" => "form-control", "required"])!!}
		</div>
	  <div class="row col-md-12 ">
		  <div class="form-group col-md-5">
    	  <a href="{{ route('catalogo.modulo.ver', $modulo->id) }}" style='margin-top: 15px;' class="btn btn-warning">Regresar</a>
    	  <button type="submit" style='margin-top: 15px;' class="btn btn-primary">Actualizar</button>
  	</div>
	</div>
  {!! Form::close() !!}
	</div>
</div>
     </section>
     
@endsection
  
