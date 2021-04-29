<!-- Guardado en resources/views/pages/admin.blade.php -->
@extends('layouts.principal')

@section('contenido')
<script>
window.onload =  procedencia_carrera;
var id_fac = 50;
var carreras = [];
var divisiones = [];
var facultades = [];
var i = 0;
var ingenieria_id = 0;
@for($i = 0; $i<sizeof($carreras); $i++)
  carreras[{{$i}}] = {
    id: {{ $carreras[$i]->id}},
    nombre: "{{ $carreras[$i]->nombre}}"
  }
@endfor

@for($i = 0; $i<sizeof($divisiones); $i++)
  divisiones[{{$i}}] = {
    id: {{ $divisiones[$i]->id}},
    nombre: "{{ $divisiones[$i]->nombre}}"
  }
@endfor

@for($i = 0; $i<sizeof($facultades); $i++)
  @if($facultades[$i]->nombre == "Facultad de Ingeniería")
    ingenieria_id = {{$facultades[$i]->id}};
  @endif;
  facultades[{{$i}}] = {
    id: {{ $facultades[$i]->id}},
    nombre: "{{ $facultades[$i]->nombre}}"
    }
@endfor
function changeFunc() {
  var selectBox = document.getElementById("facultad_option");
  var selectedValue = selectBox.options[selectBox.selectedIndex].value;
  id_fac = selectedValue;
  showCarreras();
}

function showCarreras() {
  selectElement = document.querySelector('#facultad_option'); 
  output = selectElement.value;
  if(output == ingenieria_id){
    document.getElementById("carreras").style.display = "initial";
    document.getElementById("divisiones").style.display = "initial";
  }
  else{
    document.getElementById("carreras").style.display = "none";
    document.getElementById("divisiones").style.display = "none";
  }
}

function changeGrado(){
    var grado = document.getElementById("grado");
    var abre = document.getElementById("abr_grado_div");
    var opc = grado.selectedIndex;
    abre.style.display="none";
    if (opc==4){
      abre.style.display="block";
    }
}

function procedencia_carrera() {
    var procedencia = document.getElementById("procedencia");
    //var carrera = document.getElementById("carrera_option");
    var facultad = document.getElementById("facultad_option");
    var procedencia_n = document.getElementById("procedencia_n");
    var carrera_n = document.getElementById("carreras");
    var facultad_n = document.getElementById("facultad_n");
    var unam_no = document.getElementById("unam_no");
    var unam_si = document.getElementById("unam_si");
    if (unam_no.checked == true && unam_si.checked == false) {
       // carrera.style.display = "none";
        facultad.style.display = "none";
        procedencia.style.display = "block";

        carrera_n.style.display = "none";
        facultad_n.style.display = "none";
        procedencia_n.style.display = "block";

        //$('#procedencia').prop("required", true);
      //  $('#carrera').removeAttr("required");
        $('#facultad').removeAttr("required");
    } 
    if (unam_no.checked == false && unam_si.checked == true) {
     // carrera.style.display = "initial";
      facultad.style.display = "initial";
      procedencia.style.display = "none";

      carrera_n.style.display = "initial";
      facultad_n.style.display = "initial";
      procedencia_n.style.display = "none";

  //   $('#carrera').prop("required", true);
      $('#facultad').prop("required", true);
      //$('#procedencia').removeAttr("required");
      changeFunc();
      changeGrado();
    }
}

</script>

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
              <h1>{{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</h1>
          </div>
          <div class="panel-body">

    <div class="row">{!! Form::open(['route' => array('profesor.actualizar', $user->id), "method" => "PUT"]) !!}

        <div class="row col-md-12 ">
             <div class="form-group col-md-4">
                 {!!Form::label("nombres", "Nombre:")!!}
                 {!!Form::text("nombres", $user->nombres, [ "class" => "form-control", "placeholder" => "Nombre", "required",""])!!}
             </div>
            <div class="form-group col-md-4">
                 {!!Form::label("apellido_paterno", "Apellido Paterno:")!!}
                 {!!Form::text("apellido_paterno", $user->apellido_paterno, [ "class" => "form-control", "placeholder" => "Apellido Paterno", "required",""])!!}
            </div>
             <div class="form-group col-md-4">
                {!!Form::label("apellido_materno", "Apellido Materno:")!!}
                {!!Form::text("apellido_materno", $user->apellido_materno, [ "class" => "form-control", "placeholder" => "Apellido Materno", ""])!!}
            </div>
         </div>

         <div class="form-group col-md-3">
           {!!Form::label("rfc", "RFC:")!!}
           {!!Form::text("rfc", $user->rfc, [ "class" => "form-control", "placeholder" => "RFC","required",""])!!}
         </div>

         <div class="form-group col-md-3">
           {!!Form::label("numero_trabajador", "Número de Trabajador:")!!}
           {!!Form::text("numero_trabajador", $user->numero_trabajador, [ "class" => "form-control", "placeholder" => "Núm. de Trabajador", ""])!!}
         </div>

         <div class="form-group col-md-3">
            {!!Form::label("categoria_nivel_id", "Categoría y Nivel:")!!}
            {!!Form::select("categoria_nivel_id", $user->allCategoria()->pluck('categoria','id'),$user->getIdCategoria(),['class'=>'form-control'])!!}
         </div>

          <div class="form-group col-md-4">
              <label for="name" class="control-label">Fecha de nacimiento:</label>
                <input id="fecha_nacimiento" type="date" class="form-control" name="fecha_nacimiento" value="{{ $user->fecha_nacimiento }}" >
          </div>

        <div class="form-group col-md-4">
            {!!Form::label("grado", "Grado:")!!}
            {!!Form::select("grado", $user->allGrado(), $user->grado, [ "class" => "form-control", "onchange"=>"changeGrado()" ])!!}
        </div>

        <div id="abr_grado_div" style="display:none" class="form-group col-md-4">
            {!!Form::label("abr_grado", "Abreviatura de Grado:")!!}
            {!!Form::text("abr_grado", $user->abreviatura_grado, [ "class" => "form-control", "id" => "abr_grado"])!!}
        </div>

        <div class="form-group col-md-4 ">
            {!!Form::label("telefono", "Número de Teléfono:")!!}
            {!!Form::text("telefono", $user->telefono, [ "class" => "form-control", "placeholder" => "Número de Teléfono", ""])!!}
        </div>

        <div class="form-group col-md-4 ">
            {!!Form::label("email", "Email:")!!}
            {!!Form::text("email", $user->email, [ "class" => "form-control", "placeholder" => "example@hotmail.com", ""])!!}
        </div>

       <div class="form-group col-md-4">
        {!!Form::label("facebook", "Facebook:")!!}
        {!!Form::text("facebook", $user->facebook, [ "class" => "form-control", "placeholder" => "Facebook", ""])!!}
       </div>

      <div class="form-group col-md-4">
        <div class="col-md-4">
          {!!Form::label("genero", "Género:")!!}
        </div>
          <div class="col-md-4">
            <div class="row">
              <label class="radio-inline">
                @if($user->genero === "masculino")
                <input id="femenino" type="radio" name="genero" value="femenino">
                @else
                <input id="femenino" type="radio" name="genero" value="femenino" checked>
                @endif
                Femenino
              </label>
            </div>
            <div class="row">
              <label class="radio-inline">
                @if($user->genero === "masculino")
                <input id="masculino" type="radio" name="genero" value="masculino" checked>
                @else
                <input id="masculino" type="radio" name="genero" value="masculino">
                @endif
                Masculino
              </label>
          </div>
          </div>
      </div>

       <div class="form-group col-md-6">
        {!!Form::label("semblanza_corta", "Semblanza corta:")!!}
        {!!Form::textarea("semblanza_corta", $user->semblanza_corta, [ "class" => "form-control", "placeholder" => "Semblanza", ""])!!}
      </div>

      <div class="form-group col-md-4">
        <div class="col-md-3">
          {!!Form::label("unam", "UNAM:")!!}
        </div>
          <div class="col-md-1">
            <div class="row">
              <label class="radio-inline">
                @if($user->unam == 1)
                <input id="unam_si" onclick="procedencia_carrera()" type="radio" name="unam" value = 1 checked>
                @else
                <input id="unam_si" onclick="procedencia_carrera()" type="radio" name="unam" value = 1 >
                @endif
                Sí
              </label>
            </div>
            <div class="row">
              <label class="radio-inline">
                @if($user->unam == 1)
                <input id="unam_no" onclick="procedencia_carrera()" type="radio" name="unam" value=0 >
                @else
                <input id="unam_no" onclick="procedencia_carrera()" type="radio" name="unam" value=0 checked>
                @endif
                No
              </label>
          </div>
          </div>
      </div>
      <div style="display:initial;" id="facultad" class="form-group{{ $errors->has('facultad_id') ? ' has-error' : '' }}">
        <div class="col-md-4">
          {!!Form::label("facultad", "Facultad:", ["id" =>"facultad_n"])!!}
          <select id="facultad_option" onchange="changeFunc();" name="facultad_id" class="form-control">
            @foreach($facultades as $fac)
              
                <option  value="{{ $fac->id }} "> {{ $fac->nombre }} </option>
              
            @endforeach
          </select>
          @if ($errors->has('facultad_id'))
            <span class="help-block">
              <strong>{{ $errors->first('facultad_id') }}</strong>
            </span>
          @endif
        </div>
      </div>
      <div id="carreras" style="display:none;" >
          <div class="col-md-12">
            <label for="name" class="col-md-4 control-label">Carrera(s):</label>
            <div class="col-md-12">
              @for($i = 0; $i<sizeof($carreras); $i++)
                <div class="form-check col-md-12">
                  <label style="font-weight: normal" class="form-check-label col-md-6"> {{ $carreras[$i]->nombre }} </label>
                  <input class="form-check-input col-md-4" type="checkbox" name="carrera_option{{$i}}" id="carrera_option{{$i}}" value="{{$carreras[$i]->id }}">
                </div>
              @endfor
            </div>
              @if ($errors->has('carrera_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('carrera_id') }}</strong>
                </span>
              @endif
          </div>
      </div>
      <div id="divisiones" style="display:none;" >
          <div class="col-md-12">
            <label for="name" class="col-md-4 control-label">Division(es):</label>
            <div class="col-md-12">
              @for($i = 0; $i<sizeof($divisiones); $i++)
                <div class="form-check col-md-12">
                  <label style="font-weight: normal" class="form-check-label col-md-6"> {{ $divisiones[$i]->nombre }} </label>
                  <input class="form-check-input col-md-4" type="checkbox" name="division_option{{$i}}" id="division_option{{$i}}" value="{{$divisiones[$i]->id }}">
                </div>
              @endfor
            </div>
              @if ($errors->has('division_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('division_id') }}</strong>
                </span>
              @endif
          </div>
      </div>
        <div class="form-group col-md-8 ">
            {!!Form::label("procedencia", "Procedencia:", ["id" =>"procedencia_n"])!!}
            {!!Form::text("procedencia", $user->procedencia, [ "id" => "procedencia", "class" => "form-control", "placeholder" => "Procedencia"])!!}
        </div>
      <div class="col-md-6">
        <a href="{{ URL::to('profesor', $user->id) }}" class="btn btn-info btn-block">Cancelar</a>
      </div>
      <div class="col-md-6">
        <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
      </div>

        {!! Form::close() !!}
    </div>


      </div>

     </section>

@endsection
