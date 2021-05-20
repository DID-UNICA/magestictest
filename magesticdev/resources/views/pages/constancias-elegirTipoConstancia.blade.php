@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<style>
    nav.navbar{
      background-color: #FAF8F8;
    }
</style>

<style type="text/javascript">
    determinarFirmantes();
    determinarTexto();
</style>

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
				<h3>Coordinación de Gestión y Vinculación</h3>
		</div>
		<div class="panel-body">
			@include('flash::message')
			<div class="logos col-md-12 col-center">
				<h3>
					<img class="img-escudo" src="{{ asset('img/cdd.png') }}">
					Manejo y Gestión de información del Centro de Docencia.
				</h3>
			</div>
			<hr>
			<h2>Constancias <span class="fa fa-file-pdf-o"></span></h2>
			<table class="table table-hover">
				<div class="collapse navbar-collapse" id="menuCurso">
					<form id="form" class="form-horizontal" method="GET" action="{{ route('constancias.generar.b', $curso->id)}}">
						{{ csrf_field() }}
						<div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Tipo de constancia: </label>
							<div class="col-md-6">
								<input type="hidden" name="id" id="auxiliar">
									<select id="type" class="form-control" name="type" value="{{ old('type')}}" onchange="determinarFirmantes()">
									@if($count_profesores > 3)
										<option value="AA">Coordinación</option>
										<option value="D">Coordinación General</option>
										<option value="I">Coordinación y Coordinador general</option>
										<option value="E">Director</option>
										<option value="F">Coordinación General  y Secretaría de Apoyo a la Docencia</option>
										<option value="G">Secretaría de Apoyo a la Docencia y Director</option>
										<option value="H">UNICA</option>
										<option value="f1">Un firmante</option>
										<option value="f2">Dos firmantes</option>
										<option value="f3">Tres firmantes</option>
										<option value="f4">Cuatro firmantes</option>
										<option value="f5">Cinco firmantes</option>
									@else
										<option value="A">Instructores y Coordinación</option>
										<option value="B">Instructores y Coordinación General</option>
										<option value="C">Instructores y Secretaría de Apoyo a la Docencia</option>
										<option value="AA">Coordinación</option>
										<option value="D">Coordinación General</option>
										<option value="I">Coordinación y Coordinación General</option>
										<option value="E">Director</option>
										<option value="F">Coordinación General y Secretaría de Apoyo a la Docencia</option>
										<option value="G">Secretaría de Apoyo a la Docencia y Director</option>
										<option value="H">UNICA</option>
										<option value="f1">Un firmante</option>
										<option value="f2">Dos firmantes</option>
										<option value="f3">Tres firmantes</option>
										<option value="f4">Cuatro firmantes</option>
										<option value="f5">Cinco firmantes</option>
									@endif
									</select>
									@if ($errors->has('type'))
											<span class="help-block">
													<strong>{{ $errors->first('type') }}</strong>
											</span>
									@endif
							</div>
						</div>
						<div class="form-group col-md-4">
								{!!Form::label("typeId_label", "Folio institucional (Número consecutivo):")!!}
						</div>
						<div class="form-group col-md-6">
								{!!Form::text("typeid", null, [ "class" => "form-control", "placeholder" => "Dígitos nueve, diez y once del folio"])!!}
						</div>
						<div class="form-group col-md-4">
								{!!Form::label("numero", "Folio pequeño:")!!}
						</div>
						<div class="form-group col-md-6">
								{!!Form::text("numero", null, [ "class" => "form-control", "placeholder" => "Número inicial"])!!}
						</div>
						<div class="form-group{{ $errors->has('texto_int') ? ' has-error' : '' }}">
							<label for="texto_int" class="col-md-4 control-label">Texto Intermedio: </label>
							<div class="col-md-6">
								<select id="texto1" class="form-control" name="texto1" value="{{ old('texto1')}}" onchange="determinarTexto()">
									<option value="por acreditar el ">por acreditar el <<i>tipo de curso</i>></option>
									<option value="por haber asistido al ">por haber asistido al <<i>tipo de curso</i>></option>
									<option value="por haber sido parte del ">por haber sido parte del <<i>tipo de curso</i>></option>
									<option value="D">Personalizado</option>
								</select>
								@if ($errors->has('texto_int'))
								<span class="help-block">
										<strong>{{ $errors->first('texto_int') }}</strong>
								</span>
								@endif
								<div id="div_tp" style="display:none; margin-top:5px;" class="form-group{{ $errors->has('texto_per') ? ' has-error' : '' }}">
										<input id="texto_per" type="text" class="form-control" name="texto_per" value="{{ old('texto_per') }}" >
								</div>
							</div>
						</div>
						<div style="display: none;" id=firmanteUno>
							<div class="col-md-4">
									<label for="name1" class="control-label">Nombre:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('name1') ? ' has-error' : '' }}">
								<input id="name1" type="text" class="form-control" name="name1" value="{{ old('name1') }}" >
								@if ($errors->has('name1'))
										<span class="help-block">
												<strong>{{ $errors->first('name1') }}</strong>
										</span>
								@endif
							</div>
							<div class="col-md-4">
								<label for="posicion1" class="control-label">Cargo:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('posicion1') ? ' has-error' : '' }}">
									<input id="posicion1" type="text" class="form-control" name="posicion1" value="{{ old('posicion1') }}" >
									@if ($errors->has('posicion1'))
									<span class="help-block">
											<strong>{{ $errors->first('posicion1') }}</strong>
									</span>
									@endif
							</div>
						</div>
						<div style="display: none;" id=firmanteDos>
							<div class="col-md-4">
								<label for="name2" class="control-label">Nombre:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('name2') ? ' has-error' : '' }}">
								<input id="name2" type="text" class="form-control" name="name2" value="{{ old('name2') }}" >
								@if ($errors->has('name2'))
										<span class="help-block">
												<strong>{{ $errors->first('name2') }}</strong>
										</span>
								@endif
							</div>
							<div class="col-md-4">
								<label for="posicion2" class="control-label">Cargo:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('posicion2') ? ' has-error' : '' }}">
								<input id="posicion2" type="text" class="form-control" name="posicion2" value="{{ old('posicion2') }}" >
								@if ($errors->has('posicion2'))
										<span class="help-block">
												<strong>{{ $errors->first('posicion2') }}</strong>
										</span>
								@endif
							</div>
						</div>
						<div style="display: none;" id=firmanteTres>
							<div class="col-md-4">
									<label for="name3" class="control-label">Nombre:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('name3') ? ' has-error' : '' }}">
								<input id="name3" type="text" class="form-control" name="name3" value="{{ old('name3') }}" >
								@if ($errors->has('name3'))
										<span class="help-block">
												<strong>{{ $errors->first('name3') }}</strong>
										</span>
								@endif
							</div>
							<div class="col-md-4">
								<label for="posicion3" class="control-label">Cargo:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('posicion3') ? ' has-error' : '' }}">
								<input id="posicion3" type="text" class="form-control" name="posicion3" value="{{ old('posicion3') }}" >
								@if ($errors->has('posicion3'))
										<span class="help-block">
												<strong>{{ $errors->first('posicion3') }}</strong>
										</span>
								@endif
							</div>
						</div>
						<div style="display: none;" id=firmanteCuatro>
							<div class="col-md-4">
									<label for="name4" class="control-label">Nombre:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('name4') ? ' has-error' : '' }}">
								<input id="name4" type="text" class="form-control" name="name4" value="{{ old('name4') }}" >
								@if ($errors->has('name4'))
										<span class="help-block">
												<strong>{{ $errors->first('name4') }}</strong>
										</span>
								@endif
							</div>
							<div class="col-md-4">
									<label for="posicion4" class="control-label">Cargo:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('posicion4') ? ' has-error' : '' }}">
								<input id="posicion4" type="text" class="form-control" name="posicion4" value="{{ old('posicion4') }}" >
								@if ($errors->has('posicion4'))
										<span class="help-block">
												<strong>{{ $errors->first('posicion4') }}</strong>
										</span>
								@endif
							</div>
						</div>
						<div style="display: none;" id=firmanteCinco>
							<div class="col-md-4">
									<label for="name5" class="control-label">Nombre:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('name5') ? ' has-error' : '' }}">
								<input id="name5" type="text" class="form-control" name="name5" value="{{ old('name5') }}" >
								@if ($errors->has('name5'))
										<span class="help-block">
												<strong>{{ $errors->first('name5') }}</strong>
										</span>
								@endif
							</div>
							<div class="col-md-4">
									<label for="posicion5" class="control-label">Cargo:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('posicion5') ? ' has-error' : '' }}">
								<input id="posicion5" type="text" class="form-control" name="posicion5" value="{{ old('posicion5') }}" >
								@if ($errors->has('posicion5'))
										<span class="help-block">
												<strong>{{ $errors->first('posicion5') }}</strong>
										</span>
								@endif
							</div>
						</div>
						<div style="display: none;" id=firmanteUNICA>
							<div class="col-md-4">
									<label for="generacion" class="control-label">Generación: </label>
							</div>
							<div class="col-md-6 form-group {{ $errors->has('generacion') ? ' has-error' : '' }}">
									<input id="numgen" type="number" class="form-control" name="generacion" value="{{ old('generacion') }}" >
							</div>
							<div class="col-md-4">
									<label for="nameU" class="control-label">Nombre:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('nameU') ? ' has-error' : '' }}">
									<input id="nameU" type="text" class="form-control" name="nameU" value="{{ old('nameU') }}" >
									@if ($errors->has('nameU'))
											<span class="help-block">
													<strong>{{ $errors->first('nameU') }}</strong>
											</span>
									@endif
							</div>
							<div class="col-md-4">
									<label for="posicionU" class="control-label">Cargo:</label>
							</div>
							<div class="col-md-6 form-group{{ $errors->has('posicionU') ? ' has-error' : '' }}">
									<input id="posicionU" type="text" class="form-control" name="posicionU" value="{{ old('posicionU') }}" >
									@if ($errors->has('posicionU'))
											<span class="help-block">
													<strong>{{ $errors->first('posicionU') }}</strong>
											</span>
									@endif
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-2">
								<button type="submit" class="btn btn-primary btn-block">Generar</button>
							</div>
							<div class="col-md-2">
								<a href="{{ route('constancias.fecha',[$curso->id]) }}" class="btn btn-warning">Fecha de envío</a></td>
							</div>
						</div>
					</form>
				</div>
			</table>
		</div>
	</section>
	<script type="text/javascript">
		function determinarTexto(){
			var select_texto_int = document.getElementById("texto1");
			var value_select_ti = select_texto_int.options[select_texto_int.selectedIndex].value;
			var textoPersonalizado1 = document.getElementById("div_tp");
			if(value_select_ti == "D"){
				textoPersonalizado1.style.display = "block";
			}else{
				textoPersonalizado1.style.display = "none";
			}
		}
		function determinarFirmantes(){
				var e = document.getElementById("type");
				var strE = e.options[e.selectedIndex].text;
				console.log(strE);
				var divUnFirmante = document.getElementById("firmanteUno");
				var divDosFirmantes = document.getElementById("firmanteDos");
				var divTresFirmantes = document.getElementById("firmanteTres");
				var divCuatroFirmantes = document.getElementById("firmanteCuatro");
				var divCincoFirmantes = document.getElementById("firmanteCinco");
				var divUNICA = document.getElementById("firmanteUNICA");
				if(strE == "Un firmante"){
						divUnFirmante.style.display = "block";
						divDosFirmantes.style.display = "none"
						divTresFirmantes.style.display = "none"
						divCuatroFirmantes.style.display = "none"
						divCincoFirmantes.style.display = "none"
						divUNICA.style.display = "none"
				}else if(strE == "Dos firmantes"){
						divDosFirmantes.style.display = "block";
						divUnFirmante.style.display = "block"
						divTresFirmantes.style.display = "none"
						divCuatroFirmantes.style.display = "none"
						divCincoFirmantes.style.display = "none"
						divUNICA.style.display = "none"
				}else if(strE == "Tres firmantes"){
						divTresFirmantes.style.display = "block";
						divUnFirmante.style.display = "block"
						divDosFirmantes.style.display = "block"
						divCuatroFirmantes.style.display = "none"
						divCincoFirmantes.style.display = "none"
						divUNICA.style.display = "none"
				}else if(strE == "Cuatro firmantes"){
						divCuatroFirmantes.style.display = "block";
						divUnFirmante.style.display = "block"
						divDosFirmantes.style.display = "block"
						divTresFirmantes.style.display = "block"
						divCincoFirmantes.style.display = "none"
						divUNICA.style.display = "none"
				}else if(strE == "Cinco firmantes"){
						divCincoFirmantes.style.display = "block";
						divUnFirmante.style.display = "block"
						divDosFirmantes.style.display = "block"
						divTresFirmantes.style.display = "block"
						divCuatroFirmantes.style.display = "block"
						divUNICA.style.display = "none"
				}else if(strE == "UNICA"){
					divUnFirmante.style.display = "none"
					divDosFirmantes.style.display = "none"
					divTresFirmantes.style.display = "none"
					divCuatroFirmantes.style.display = "none"
					divCincoFirmantes.style.display = "none"
					divUNICA.style.display = "block"
					divNombre.style.display = "none"
					divCargo.style.display = "none"
				}else{
					divUnFirmante.style.display = "none"
					divDosFirmantes.style.display = "none"
					divTresFirmantes.style.display = "none"
					divCuatroFirmantes.style.display = "none"
					divCincoFirmantes.style.display = "none"
					divUNICA.style.display = "none"
				}
		}
	</script>
@endsection