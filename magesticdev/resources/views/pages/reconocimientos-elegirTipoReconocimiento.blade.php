@extends('layouts.principal')

@section('contenido')
<style>
    nav.navbar{
        background-color: #FAF8F8;
    }
    tr, th {
      padding: 10px;
    }
    td {
      padding: 6px;
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
          <img class="img-escudo" src="{{ asset('img/cdd.png') }}">
          <h3>Manejo y Gestión de información del Centro de Docencia.</h3>
        </div>
        <hr>
        <h2>Reconocimientos<span class="fa fa-file-pdf-o"></span></h2>
          <table class="table table-hover">
            <tr>
              <th>Nombre</th>
              <th>Instructor</th>
              <th>Periodo</th>
              <th>Tipo</th>
            </tr>
            <tr>
              <td>{{ $curso->getNombreCurso() }}</td>
              <td>{{ $curso->getProfesores() }}</td>
              <td>{{ $curso->getSemestre() }}</td>
              <td>{{ $curso->getTipoCadenaUpper() }}</td>
            </tr>
          </table>
          <form class="form-horizontal" method="GET" action="{{ route('reconocimientos.generar',[$curso->id])}}">
            <!-- Escoger firmantes -->
            <div class="form-group row">
              {!!Form::label("tipof", "Firmantes:", ["class=col-md-3 col-form-label"])!!}
              <div class="col-md-6">
              {!!Form::select('tipof', array(
                        'A' => 'Coordinación del Centro de Docencia',
                        'B' => 'Coordinación del Área y Coordinación del Centro de Docencia',
                        'C' => 'Coordinación del Centro de Docencia y Secretaría de Apoyo a la Docencia',
                        'D' => 'Secretaría de Apoyo a la Docencia y Dirección',
                        'E' => 'Un firmante',
                        'F' => 'Dos firmantes',
                        'G' => 'Tres firmantes',
                        'H' => 'Cuatro firmantes',
                        'I' => 'Cinco firmantes'
                      ), 'A', ["class" => "form-control","onchange"=>"determinarFirmantes()"])!!}
              </div>
            </div>

            <!-- Seleccionar si se desea folio institucional -->
            <div class= "form-group row">
              {!!Form::label("gen_folio_inst", "Generar folio institucional:", ["class=col-md-3"])!!}
              <div class= "col-md-6">
                {!!Form::checkbox("gen_folio_inst", true, ["class=form-control"])!!}
              </div>
            </div>

            <!-- Ingresar el folio institucional -->
            <div id="folioInst" style="block">
              <div class= "form-group row">
                {!!Form::label("folio_inst", "Folio institucional (Número consecutivo):",["class=col-md-3"])!!}
                <div class= "col-md-6">
                    {!!Form::text("folio_inst", null, [ "required","class=form-control","placeholder" => "Caracteres hasta antes del número de lista"])!!}
                </div>
              </div>
            </div>

            <!-- Seleccionar si se desea folio pequeño -->
            <div class= "form-group row">
                {!!Form::label("gen_folio_peq", "Generar folio pequeño:", ["class=col-md-3"])!!}
                <div class= "col-md-6">
                  {!!Form::checkbox("gen_folio_peq", true, ["class=form-control"])!!}
                </div>
            </div>

            <!-- Ingresar el folio pequeño -->
            <div id="folioPeque" style="block">
              <div class= "form-group row">
                {!!Form::label("folio_peq", "Folio pequeño:", ["class=col-md-3"])!!}
                <div class= "col-md-6">
                    {!!Form::text("folio_peq", null, [ "required","class=form-control","placeholder" => "Número inicial"])!!}
                </div>
              </div>
            </div>

            <!-- Texto personalizado si el tipo es Seminario -->
            <div class="form-group row">
              {!!Form::label("texto_pers", "Texto personalizado del reconocimiento:", ["class"=>"col-md-3"])!!}
              <div class="col-md-6">
                {!!Form::text("texto_pers",null,["placeholder"=>"Ingrese leyenda personalizada para el reconocimiento","required","class"=>"form-control"])!!}
              </div>
            </div>

            <!-- Texto personalizado si el tipo es evento -->
            @if ($curso->getTipo()=='D')
              <div class="form-group row">
                {!!Form::label("diplomado", "Nombre del diplomado:", ["class"=>"col-md-3"])!!}
                <div class="col-md-6">
                    {!!Form::text('diplomado', $diplomado->nombre_diplomado,["class" => "form-control", 'disabled'])!!}
                  </div>
              </div>
            @endif
            
            <!-- Firmante número cinco (1) -->
						<div style="display: none;" id=firmanteUno>
							<div class="form-group row">
									<label for="name5" class="col-md-3">Nombre:</label>
                  <div class="col-md-6">
                    <input placeholder="Nombre del primer firmante" id="name5" type="text" class="form-control" name="name5" value="{{ old('name5') }}">
							</div>
							</div>
							<div class="form-group row">
								<label for="posicion5" class="col-md-3">Cargo:</label>
                <div class="col-md-6">
                    <input placeholder="Descripción del primer firmante" id="posicion5" type="text" class="form-control" name="posicion5" value="{{ old('posicion5') }}" >
                </div>
              </div>
						</div>

            <!-- Firmante número cuatro (2) -->
						<div style="display: none;" id=firmanteDos>
							<div class="form-group row">
								<label for="name4" class="col-md-3">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del segundo firmante" id="name4" type="text" class="form-control" name="name4" value="{{ old('name4') }}" >
                </div>
              </div>
							<div class="form-group row">
								<label for="posicion4" class="col-md-3">Cargo:</label>
                <div class="col-md-6">
                  <input placeholder="Descripción del segundo firmante" id="posicion4" type="text" class="form-control" name="posicion4" value="{{ old('posicion4') }}" >
                </div>
              </div>
						</div>

            <!-- Firmante número tres (3) -->
						<div style="display: none;" id=firmanteTres>
							<div class="form-group row">
                <label for="name3" class="col-md-3">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del tercer firmante" id="name3" type="text" class="form-control" name="name3" value="{{ old('name3') }}" >
                </div>
              </div>
							<div class="form-group row">
								<label for="posicion3" class="col-md-3">Cargo:</label>
  						  <div class="col-md-6">
	  				      <input placeholder="Descripción del tercer firmante" id="posicion3" type="text" class="form-control" name="posicion3" value="{{ old('posicion3') }}" >
							  </div>
							</div>
						</div>

            <!-- Firmante número dos (4) -->
						<div style="display: none;" id=firmanteCuatro>
							<div class="form-group row">
								<label for="name2" class="col-md-3">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del cuarto firmante" id="name2" type="text" class="form-control" name="name2" value="{{ old('name2') }}" >
                </div>
							</div>
              
							<div class="form-group row">
								<label for="posicion2" class="col-md-3">Cargo:</label>
                <div class="col-md-6">
                  <input placeholder="Descripción del cuarto firmante" id="posicion2" type="text" class="form-control" name="posicion2" value="{{ old('posicion2') }}" >
                </div>
							</div>
						</div>

            <!-- Firmante uno (5) -->
						<div style="display: none;" id=firmanteCinco>
							<div class="form-group row">
								<label for="name1" class="col-md-3">Nombre:</label>
                <div class="col-md-6">
                  <input placeholder="Nombre del quinto firmante" id="name1" type="text" class="form-control" name="name1" value="{{ old('name1') }}" >
                </div>
							</div>
              
							<div class="form-group row">
								<label for="posicion1" class="col-md-3">Cargo:</label>
                <div class="col-md-6">
                  <input placeholder="Descripción del quinto firmante" id="posicion1" type="text" class="form-control" name="posicion1" value="{{ old('posicion1') }}" >
                </div>
							</div>
						</div>
            <div style="margin-left: 5px" class="row form-group">
              <div class="col-md-4">
                <a style="margin: 3px;" href="{{ route('reconocimientos.fecha',[$curso->id]) }}" class="btn btn-warning">Fecha de envío</a>
                <button style="margin: 3px;" type="submit" class="btn btn-primary" name="id" value="{{ $curso->id }}">
                    Generar
                </button>  
              </div>
            </div>
          </form>
      </div>
<script>
  function folioInst(){
    let checkboxFolioInst = document.getElementById("gen_folio_inst");
    let divFolioInst = document.getElementById("folioInst");
    let folioInst = document.getElementById("folio_inst")
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
    let folioPeque = document.getElementById("folio_peq")
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

  function determinarFirmantes(){
    let e = document.getElementById("tipof");
    let strE = e.options[e.selectedIndex].text;
    let divUnFirmante = document.getElementById("firmanteUno");
    let divDosFirmantes = document.getElementById("firmanteDos");
    let divTresFirmantes = document.getElementById("firmanteTres");
    let divCuatroFirmantes = document.getElementById("firmanteCuatro");
    let divCincoFirmantes = document.getElementById("firmanteCinco");
    if(strE == "Un firmante"){
      divUnFirmante.style.display = "block";
      divDosFirmantes.style.display = "none";
      divTresFirmantes.style.display = "none";
      divCuatroFirmantes.style.display = "none";
      divCincoFirmantes.style.display = "none";
    }else if(strE == "Dos firmantes"){
      divDosFirmantes.style.display = "block";
      divUnFirmante.style.display = "block";
      divTresFirmantes.style.display = "none";
      divCuatroFirmantes.style.display = "none";
      divCincoFirmantes.style.display = "none";
    }else if(strE == "Tres firmantes"){
      divTresFirmantes.style.display = "block";
      divUnFirmante.style.display = "block";
      divDosFirmantes.style.display = "block";
      divCuatroFirmantes.style.display = "none";
      divCincoFirmantes.style.display = "none";
    }else if(strE == "Cuatro firmantes"){
      divCuatroFirmantes.style.display = "block";
      divUnFirmante.style.display = "block";
      divDosFirmantes.style.display = "block";
      divTresFirmantes.style.display = "block";
      divCincoFirmantes.style.display = "none";
    }else if(strE == "Cinco firmantes"){
      divCincoFirmantes.style.display = "block";
      divUnFirmante.style.display = "block";
      divDosFirmantes.style.display = "block";
      divTresFirmantes.style.display = "block";
      divCuatroFirmantes.style.display = "block";
    }else{
      divUnFirmante.style.display = "none";
      divDosFirmantes.style.display = "none";
      divTresFirmantes.style.display = "none";
      divCuatroFirmantes.style.display = "none";
      divCincoFirmantes.style.display = "none";
    }
	}
folioInst();
folioPeque();
</script>
@endsection