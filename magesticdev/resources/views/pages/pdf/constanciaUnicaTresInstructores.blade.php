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
  background-image: url("/img/ri_1.png");
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
  width: 100%;
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
      <h3 style="text-align: center;font-size: 24px;font-style: normal;">Otorgan la presente constancia a:</h2>
      <br>
        <h2 class='nombre_profesor'>{{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
      <h3 style="font-size: 17px;line-height: 30%;">por haber acreditado el {{$curso->getTipoCadena()}}</h3>
      <h2 class='nombre_curso'>{{$cursoCatalogo->nombre_curso}}</h2>
      <h3 style="font-size: 14px;">Dentro del plan de becarios de UNICA, generación {{$generacion}}°</h3>
      <p style="padding-top: 0.9cm; font-size:105%;">{{$fechaimp}}</h5>
      <p style="padding-bottom: 0.4cm; font-size:105%">Duración: {{$cursoCatalogo->duracion_curso }} h</h5>
      <p style="line-height: 20%; font-size: 17px; font-weight: bold;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
      <p style="font-size: 11px; padding-bottom: 2cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
    </div>
    <div class = "tabla-centro">
    <table class="tabla-centro">
      <tr>
        <td class="firma1">___________________</td>
        <td class="firma1">___________________</td>
        <td class="firma1">___________________</td>
        <td class="firma1">___________________</td>
      </tr>
      <tr>
        <td  class="firma" style="font-weight: bold;">{{$instructor1->getGrado()}} {{$instructor1->nombres}} {{$instructor1->apellido_paterno}} {{ $instructor1->apellido_materno }}</td>
        <td  class="firma" style="font-weight: bold;">{{$instructor2->getGrado()}} {{$instructor2->nombres}} {{$instructor2->apellido_paterno}} {{ $instructor2->apellido_materno }}</td>
        <td  class="firma" style="font-weight: bold;">{{$instructor3->getGrado()}} {{$instructor3->nombres}} {{$instructor3->apellido_paterno}} {{ $instructor3->apellido_materno }}</td>
        <td  class="firma" style="font-weight: bold;">{{$coordinadorGeneral->grado}} {{$coordinadorGeneral->coordinador}}</td>
      </tr>
      <tr>
        <td class="firma" style="font-size: 10px;">Instructor</td>
        <td class="firma" style="font-size: 10px;">Instructor</td>
        <td class="firma" style="font-size: 10px;">Instructor</td>
        <td class="firma" style="font-size: 10px;">Coordinador General del Centro de Docencia</td>
      </tr>
    </table>
    </div>
  </div>
  <table width=100% style="padding-top: 93%;">
    <tr width=100% >
      <td id="folio">{{ $folio }}</td>
      <td id="numero_inferior">{{ $folio_der }}</td>
    </tr>
  </table>
  </body>
</html>