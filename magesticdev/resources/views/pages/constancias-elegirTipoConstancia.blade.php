@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<style>
    nav.navbar{
      background-color: #FAF8F8;
    }
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
				<div class="collapse navbar-collapse" id="menuCurso">
					<form id="form" class="form-horizontal" method="GET" action="{{ route('constancias.generar.b', $curso->id)}}">
						{{ csrf_field() }}
            <!-- Seleccionar el tipo de constancia -->
						<div class="form-group row">
                {!!Form::label("type", "Tipo de constancia:", ["class=col-md-4 col-form-label"])!!}
                <div class="col-md-6">
                  <select id="type" class="form-control" name="type" value="{{ old('type')}}" onchange="determinarFirmantes()">
                    @if($count_profesores > 3)
                      <option value="AA">Coordinación del Área</option>
                      <option value="D">Coordinación del Centro de Docencia</option>
                      <option value="I">Coordinación del Área y Coordinación del Centro de Docencia</option>
                      <option value="E">Director</option>
                      <option value="F">Coordinación del Centro de Docencia y Secretaría de Apoyo a la Docencia</option>
                      <option value="G">Secretaría de Apoyo a la Docencia y Director</option>
                      <option value="H">UNICA</option>
                      <option value="f1">Un firmante</option>
                      <option value="f2">Dos firmantes</option>
                      <option value="f3">Tres firmantes</option>
                      <option value="f4">Cuatro firmantes</option>
                      <option value="f5">Cinco firmantes</option>
                    @else
                      <option value="A">Instructores y Coordinación del Área</option>
                      <option value="B">Instructores y Coordinación del Centro de Docencia</option>
                      <option value="C">Instructores y Secretaría de Apoyo a la Docencia</option>
                      <option value="AA">Coordinación del Área</option>
                      <option value="D">Coordinación del Centro de Docencia</option>
                      <option value="I">Coordinación del Área y Coordinación del Centro de Docencia</option>
                      <option value="E">Director</option>
                      <option value="F">Coordinación del Centro de Docencia y Secretaría de Apoyo a la Docencia</option>
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

            <!-- Seleccionar si se desea folio institucional -->
            <div class= "form-group row">
              {!!Form::label("gen_folio", "Generar folio institucional:", ["class=col-md-4"])!!}
              <div class= "col-md-6">
                {!!Form::checkbox("gen_folio", true, ["class=form-control"])!!}
              </div>
            </div>
            
            
            <!-- Ingresar el folio institucional -->
            <div id="folioInst" style="block">
              <div class= "form-group row">
                {!!Form::label("typeid", "Folio institucional (Número consecutivo):",["class=col-md-4"])!!}
                <div class= "col-md-6">
                    {!!Form::text("typeid", null, [ "required","class=form-control","placeholder" => "Caracteres hasta antes del número de lista"])!!}
                </div>
              </div>
            </div>
            

            <!-- Seleccionar si se desea folio pequeño -->
            <div class= "form-group row">
              {!!Form::label("gen_folio_peq", "Generar folio pequeño:", ["class=col-md-4"])!!}
              <div class= "col-md-6">
                {!!Form::checkbox("gen_folio_peq", true, ["class=form-control"])!!}
              </div>
            </div>

            <!-- Ingresar el folio pequeño -->
            <div id="folioPeque" style="block">
              <div class= "form-group row">
                {!!Form::label("numero", "Folio pequeño:", ["class=col-md-4"])!!}
                <div class= "col-md-6">
                    {!!Form::text("numero", null, [ "required","class=form-control","placeholder" => "Número inicial"])!!}
                </div>
              </div>
            </div>

            <!-- Texto intermedio -->
            <div class= "form-group row">
              {!!Form::label("texto_int", "Texto intermedio:", ["class=col-md-4"])!!}
							<div class="col-md-6">
								<select id="texto1" style="margin-bottom:15px;" class="form-control" name="texto1" value="{{ old('texto1')}}" onchange="determinarTexto()">
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
								<div id="div_tp" style="display:none; margin-top:5px;">
										<input placeholder="Texto personalizado" id="texto_per" type="text" class="form-control" name="texto_per" value="{{ old('texto_per') }}" >
								</div>
							</div>
            </div>

            <!-- Firmante número cinco (1) -->
						<div style="display: none;" id=firmanteUno>
							<div class="form-group row">
									<label for="name5" class="col-md-4">Nombre:</label>
                  <div class="col-md-6">
                    <input placeholder="Nombre del primer firmante" id="name5" type="text" class="form-control" name="name5" value="{{ old('name5') }}">
                    @if ($errors->has('name5'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name5') }}</strong>
                        </span>
                    @endif
							    </div>
							</div>
							<div class="form-group row">
								<label for="posicion5" class="col-md-4">Cargo:</label>
                <div class="col-md-6">
                    <input placeholder="Descripción del primer firmante" id="posicion5" type="text" class="form-control" name="posicion5" value="{{ old('posicion5') }}" >
                    @if ($errors->has('posicion5'))
                    <span class="help-block">
                        <strong>{{ $errors->first('posicion5') }}</strong>
                    </span>
                    @endif
                </div>
              </div>
						</div>

            <!-- Firmante número cuatro (2) -->
						<div style="display: none;" id=firmanteDos>
							<div class="form-group row">
								<label for="name4" class="col-md-4">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del segundo firmante" id="name4" type="text" class="form-control" name="name4" value="{{ old('name4') }}" >
                  @if ($errors->has('name4'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name4') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
							<div class="form-group row">
								<label for="posicion4" class="col-md-4">Cargo:</label>
                <div class="col-md-6">
                  <input placeholder="Descripción del segundo firmante" id="posicion4" type="text" class="form-control" name="posicion4" value="{{ old('posicion4') }}" >
                  @if ($errors->has('posicion4'))
                      <span class="help-block">
                          <strong>{{ $errors->first('posicion4') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
						</div>

            <!-- Firmante número tres (3) -->
						<div style="display: none;" id=firmanteTres>
							<div class="form-group row">
                <label for="name3" class="col-md-4">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del tercer firmante" id="name3" type="text" class="form-control" name="name3" value="{{ old('name3') }}" >
                  @if ($errors->has('name3'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name3') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
							<div class="form-group row">
								<label for="posicion3" class="col-md-4">Cargo:</label>
  							<div class="col-md-6">
	  							<input placeholder="Descripción del tercer firmante" id="posicion3" type="text" class="form-control" name="posicion3" value="{{ old('posicion3') }}" >
		  						@if ($errors->has('posicion3'))
			  							<span class="help-block">
				  								<strong>{{ $errors->first('posicion3') }}</strong>
					  					</span>
						  		@endif
							  </div>
							</div>
						</div>

            <!-- Firmante número dos (4) -->
						<div style="display: none;" id=firmanteCuatro>
							<div class="form-group row">
								<label for="name2" class="col-md-4">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del cuarto firmante" id="name2" type="text" class="form-control" name="name2" value="{{ old('name2') }}" >
                  @if ($errors->has('name2'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name2') }}</strong>
                      </span>
                  @endif
                </div>
							</div>
              
							<div class="form-group row">
								<label for="posicion2" class="col-md-4">Cargo:</label>
                <div class="col-md-6">
                  <input placeholder="Descripción del cuarto firmante" id="posicion2" type="text" class="form-control" name="posicion2" value="{{ old('posicion2') }}" >
                  @if ($errors->has('posicion2'))
                      <span class="help-block">
                          <strong>{{ $errors->first('posicion2') }}</strong>
                      </span>
                  @endif
                </div>
							</div>
						</div>

            <!-- Firmante uno (5) -->
						<div style="display: none;" id=firmanteCinco>
							<div class="form-group row">
								<label for="name1" class="col-md-4">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del quinto firmante" id="name1" type="text" class="form-control" name="name1" value="{{ old('name1') }}" >
                  @if ($errors->has('name1'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name1') }}</strong>
                      </span>
                  @endif
                </div>
							</div>
              
							<div class="form-group row">
								<label for="posicion1" class="col-md-4">Cargo:</label>
                <div class="col-md-6">
                  <input placeholder="Descripción del quinto firmante" id="posicion1" type="text" class="form-control" name="posicion1" value="{{ old('posicion1') }}" >
                  @if ($errors->has('posicion1'))
                      <span class="help-block">
                          <strong>{{ $errors->first('posicion1') }}</strong>
                      </span>
                  @endif
                </div>
							</div>
						</div>

            <!-- Generacion UNICA -->
						<div style="display: none;" id=generacionUNICA>
							<div class="form-group row">
								<label for="generacion" class="col-md-4">Generación: </label>
                <div class="col-md-6">
                    <input min="1" id="numgen" type="number" class="form-control" placeholder="Número de la generación" name="generacion" value="{{ old('generacion') }}" >
                </div>
							</div>
						</div>

            <!-- Botones -->
						<div class="form-group row">
							<div class="col-md-5">
								<a href="{{ route('constancias.fecha',[$curso->id]) }}"><button type="button" style="margin: 3px;" class="btn btn-warning">Fecha de envío</button></a>
								<button type="submit" style="margin: 3px;" class="btn btn-primary">Generar</button>
							</div> 
						</div>

					</form>
				</div>
		  </div>
	</section>

  <!-- Funciones de JS para el ocultamiento de divs -->
	<script type="text/javascript">
		// Esconde los divs necesarios en caso de que la casilla de generar folios no esté marcada
    function folioInst(){
      let checkboxFolioInst = document.getElementById("gen_folio");
      let divFolioInst = document.getElementById("folioInst");
      let folioInst = document.getElementById("typeid")
      checkboxFolioInst.addEventListener('change', () => {
        if(checkboxFolioInst.checked === false){
          divFolioInst.style.display="none";
          folioInst.required=false;
        }else{
          divFolioInst.style.display="block";
          folioInst.required=true;
        }
      });
    }
    function folioPeque(){
      let divFolioPeque = document.getElementById("folioPeque");
      let checkboxFolioPeque = document.getElementById("gen_folio_peq");
      let folioPeque = document.getElementById("numero")
      checkboxFolioPeque.addEventListener('change', () => {
        if(checkboxFolioPeque.checked === false){
          divFolioPeque.style.display="none";
          folioPeque.required=false;
        }else{
          divFolioPeque.style.display="block";
          folioPeque.required=true;
        }
      });
    }
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
				var divUnFirmante = document.getElementById("firmanteUno");
				var divDosFirmantes = document.getElementById("firmanteDos");
				var divTresFirmantes = document.getElementById("firmanteTres");
				var divCuatroFirmantes = document.getElementById("firmanteCuatro");
				var divCincoFirmantes = document.getElementById("firmanteCinco");
				var divUNICA = document.getElementById("generacionUNICA");
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
    determinarFirmantes();
    determinarTexto();
    folioInst();
    folioPeque();
	</script>
@endsection