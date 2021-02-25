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
  text-align: left;
  bottom: 2px;
  left: 19px;
  color: #8D8D8D;
}
#folio{
  font-size: 12px;
  text-align: right;
  bottom: 1cm;
  right: 2px;
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
  line-height: 100%;
}
#encabezado_3{
  font-size: 23px;
  font-weight: bold;
  line-height: 100%;
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
  line-height: 150%;
  text-align: center;
}
#encabezado_5{
  font-size: 24px;
  font-style: italic;
  font-family:'Tangerine', serif;
  line-height: 120%;
  text-align: center;
  font-weight: bold;
}
.nombre_profesor{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 35px;
    line-height: 100%
}
.nombre_curso{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 33px;
    line-height: 100%
}
.centro {
    line-height: 20%;
    text-align: center;
}
.page-break {
    page-break-after: always;
}

#coordinador{
  font-weight: bold;
}

.firma{
  text-align:center;
  vertical-align:top;
  align:center;
  line-height: 85%;
}
.firma1{
  text-align:center;
  vertical-align:top;
  align:center;
  padding-bottom: 1.5%;
  line-height: 10%;
}
.tabla-centro{
  width: 65%;
  margin-left: 16%;
}

</style>
  <body>
  <div id=fondo>
    <div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
    <img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="166" height="198">
    <img id= img2 src='img/escudounam-color.png' width="174" height="221">
    <div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
    <div id=encabezado_3>SECRETARÍA DE APOYO A LA DOCENCIA</div>
    <div id=encabezado_4>CENTRO DE DOCENCIA</div>
    <div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
    <br>
    <div class="centro">
      <h3 style="text-align: center;font-size: 22px;font-style: normal; margin-top: 1.5cm;">Otorgan la presente constancia a:</h2>
      <br>
      <h2 class='nombre_profesor'>{{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
      <h3 style="font-size: 15px;line-height: 30%;">por haber acreditado el {{$curso->getTipoCadena()}}</h3>
      <div class='nombre_curso'>{{$cursoCatalogo->nombre_curso}}</div>
      <p style="padding-top: 0.3cm; font-size:105%;">{{$fechaimp}}</h5>
      <p style="padding-bottom: 0.4cm; font-size:105%">Duración: {{$cursoCatalogo->duracion_curso }} h</h5>
      <p style="line-height: 20%; font-size: 15px; font-weight: bold;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
      <p style="font-size: 11px; padding-bottom: 2.35cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
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
  <table width=100% style="padding-top: 0.2cm; bottom: 1cm;">
    <tr width=100% >
@if($folio_der >= 0)
<td id="numero_inferior">{{ $folio_der }}</td>
@endif
      <td id="folio">{{ $folio }}</td>
    </tr>
  </table>
  </body>
</html>

