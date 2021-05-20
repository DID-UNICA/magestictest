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
                <div class="panel-heading">
                      <h1>Actualizar</h1>
                      <h2>{{ $user->nombre_curso}}</h2>
                </div>
<div class="panel-body">
  <div>{!! Form::open(['route' => array('catalogo-cursos.actualizar', $user->id), "method" => "PUT"]) !!}
	<div class="row col-md-12 ">
		<div class="form-group col-md-3">
        {!!Form::label("clave_curso", "Clave:")!!}
        {!!Form::text("clave_curso",$user->clave_curso , [ "class" => "form-control", "required"])!!}
    </div>
		<div class="form-group col-md-9">
				{!!Form::label("nombre_curso", "Nombre del curso:")!!}
				{!!Form::text("nombre_curso", $user->nombre_curso, [ "class" => "form-control", "placeholder" => "Nombre del curso", "required"])!!}
		</div>
	</div>
	<div class="row col-md-12 ">
		<div class="form-group col-md-3">
				{!!Form::label("duracion_curso", "Duración del curso:")!!}
				{!!Form::text("duracion_curso", $user->duracion_curso, [ "class" => "form-control", "placeholder" => "Duracion_curso", "required"])!!}
		</div>
		<div class="form-group col-md-3">
				{!!Form::label("coordinacion_id", "Coordinación:")!!}
				{!!Form::select("coordinacion_id", $user->allCoordinacion()->pluck('nombre_coordinacion','id'),$user->getIdCoordinacion(),['class'=>'form-control'])!!}
		</div>
		<div class="form-group col-md-3">
				{!!Form::label("tipo", "Tipo:")!!}
				{!!Form::select('tipo', array('S' => 'Seminario','CT' => 'Curso-Taller',  'T' => 'Taller','F' => 'Foro', 'C' => 'Curso','E' => 'Evento', 'D' => 'Módulo de diplomado'),$user->tipo,['id' =>'tipoT', 'class'=>'form-control', 'onchange'=>'cantidadtemas()']) !!}
		</div>
		<div class="form-group col-md-3">
        {!!Form::label("institucion", "Institución:")!!}
        {!!Form::select('institucion', array('DGAPA' => 'DGAPA','CDD' => 'Centro de Docencia'),$user->institucion,['class'=>'form-control']) !!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div id="NumTemas" style="display:none;"class="form-group col-md-4">
        {!!Form::label("temasl", "Número de Temas:")!!}
        {!!Form::number('num_temas',$user->getNumTemas(),['id'=>'cantidadTemas','class'=>'form-control', 'required'=>'required','min'=>1]) !!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div class="form-group col-md-5">
        {!!Form::label("dirigido", "Dirigido a:")!!}
        {!!Form::textarea("dirigido", $user->dirigido, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
		<div class="form-group col-md-5 ">
        {!!Form::label("objetivo", "Objetivo:")!!}
        {!!Form::textarea("objetivo", $user->objetivo, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div class="form-group col-md-5">
        {!!Form::label("contenido", "Contenido:")!!}
        {!!Form::textarea("contenido", $user->contenido, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
		<div class="form-group col-md-5">
        {!!Form::label("antecedentes", "Antecedentes:")!!}
        {!!Form::textarea("antesc", $user->antecedentes, ["cols"=>"90", "wrap"=>"hard", "class" => "form-control"])!!}
    </div>
	</div>
	<div class="row col-md-12 ">
    <div class="form-group col-md-3">
        {!!Form::label("fecha_disenio", "Fecha de diseño:")!!}
        {!!Form::date("fecha_disenio",$user->fecha_disenio , [ "class" => "form-control", "required"])!!}
		</div>
		<div class="form-group col-md-5">
    	<a href="{{ URL::to('catalogo-cursos', $user->id) }}" style='margin-top: 15px;' class="btn btn-warning">Regresar</a>
    	<button type="submit" style='margin-top: 15px;' class="btn btn-primary col-md-offset-1">Actualizar</button>
  	</div>
	</div>
  {!! Form::close() !!}
	</div>
</div>
      <script type="text/javascript">
      window.onload =  cantidadtemas;
            function cantidadtemas(){
                var tipo;
                var cantidadTemas;
                tipo = document.getElementById("tipoT").value;
                cantidadTemas = document.getElementById("cantidadTemas");
                if (tipo == "S"){
                    document.getElementById('NumTemas').style.display = 'block';
                    cantidadTemas.setAttribute("min", 1);
                    cantidadTemas.setAttribute("required", "");
                }
                else{
                    document.getElementById('NumTemas').style.display = 'none';
                    cantidadTemas.removeAttribute("min");
                    cantidadTemas.removeAttribute("required");
                }
            }
            
        </script>
     </section>
     
@endsection
  
