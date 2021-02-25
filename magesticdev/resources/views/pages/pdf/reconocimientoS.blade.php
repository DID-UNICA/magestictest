<!DOCTYPE html>
<head>
    <title>Coordinacion General</title>
</head>
<style>
html{
	    width:100%;
      height: 100%
    }
body {
  font-family:Arial, Helvetica, Sans-serif,cursive;
}
#fondo{
  background-image: url("../public/img/ri_1.png");
  background-size: auto;
  background-repeat: no-repeat;
  background-position: 4cm 1.9cm;

}
#numero_inferior{
  text-align: right;
  bottom: 3px;
  right: 19px;
  color: #8D8D8D;
}
#folio{
  text-align: left;
  bottom: 3px;
  left: 19px;
  color: #8D8D8D;
}
.encabezado{
  line-height:170%;
  text-align: center;
}
#encabezado_1{
  font-size: 29px;
  font-weight: bold;
}
#encabezado_2{
  font-size: 25px;
  font-weight: bold;
}
#encabezado_3{
  font-size: 23px;
  font-weight: bold;
  line-height: 230%;
  text-align: center;
}
#img2{
 position: absolute;
 margin-top: 1%;

}
#img1{
 position: absolute;
 margin-top: 0.5cm;
 margin-right: 2%;
 margin-left: 82%;
}
#encabezado_4{
  font-size: 23px;
  font-weight: bold;
  line-height: 230%;
  text-align: center;
}
#encabezado_5{
  font-size: 24px;
  font-style: italic;
  font-family:'Tangerine', serif;
  line-height: 230%;
  text-align: center;
  font-weight: bold;
}
.nombre_profesor{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 35px;
    line-height: 100%
}
.nombre_tema{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 33px;
    line-height: 100%
}
.nombre_curso{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 29px;
    
}
.centro {
    line-height: 20%;
    text-align: center;
}


#coordinador{
  font-weight: bold;
}

.firma{
  text-align:center;
  vertical-align:top;
  align:center;
  line-height: 80%;
}
.firma1{
  text-align:center;
  vertical-align:top;
  align:center;
  padding-bottom: 1.5%;
  line-height: 100%;
}
.tabla-centro{
  width: 65%;
  margin-left: 16%;
}

</style>
  <body>
  <div id=fondo>
    <div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
    <img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="186" height="218">
    <img id= img2 src='img/escudounam-color.png' width="194" height="241">
    <div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
    <div id=encabezado_3>SECRETARÍA DE APOYO A LA DOCENCIA</div>
    <div id=encabezado_4>CENTRO DE DOCENCIA</div>
    <div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
    <br>
    <div class="centro">
    @if($profesor->genero=="masculino")
      <h3 style="text-align: center;font-size: 24px;font-style: normal;">Otorgan el presente reconocimiento al:</h2>
    @elseif($profesor->genero=="femenino")
    <h3 style="text-align: center;font-size: 24px;font-style: normal;">Otorgan el presente reconocimiento a la:</h2>
    @endif
      <br>
      <h2 class='nombre_profesor'>{{$profesor->abreviatura_grado}} {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
      <h3 style="font-size: 17px;line-height: 30%;">por impartir el tema</h3>
      <h2 class='nombre_tema'>{{$tema}}</h2>
      <h3 style="font-size: 17px;line-height: 30%;">del seminario</h3>
      <h2 class='nombre_curso'>{{$cursoCatalogo->nombre_curso}}</h2>
      <p style="padding-top: 1.1cm; font-size:105%;">{{$fechaimp}}</h5>
      <p style="padding-bottom: 0.4cm; font-size:105%">Duración: {{$duracion}} h</h5>
      <p style="line-height: 20%; font-size: 17px; font-weight: bold;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
      <p style="font-size: 11px; padding-bottom: 0.8cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
    </div>
    <div class = "tabla-centro">
    <table>
      <tr>
        <td width=260 class="firma1">___________________</td>
        <td width=260 class="firma1">___________________</td>
      </tr>
      <tr>
        <td width=260 class="firma" style="font-weight: bold;">{{$coordinacion->grado}} {{$coordinacion->coordinador}}</td>
        <td width=260 class="firma" style="font-weight: bold;">{{$coordinadorGeneral->grado}} {{ $coordinadorGeneral->coordinador }}</td>
      </tr>
      <tr>
        <td class="firma" style="font-size: 10px;">Coordinador de {{$coordinacion->nombre_coordinacion}}</td>
        <td class="firma" style="font-size: 10px;">Coordinador General del Centro de Docencia</td>
      </tr>
    </table>
    </div>
  </div>
  <table width=100% style="padding-bottom: 0.1cm">
    <tr width=100% >
@if($folio_der > 0)
<td id="numero_inferior">{{ $folio_der }}</td>
@endif
      <td style='text-align:right' id="folio">{{ $folio }}</td>
    </tr>
  </table>
  </body>
</html>

