<!DOCTYPE html>
<head>
    <title>Coordinación General</title>
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
  line-height: 100%
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
  line-height: 50%;
}
.firma1{
  text-align:center;
  vertical-align:top;
  align:center;
  padding-bottom: 1.5%;
  line-height: 10%;
}
.tabla-centro{
  position: relative;
  margin-left: 0px;
  align:left;
  position:left;
}
</style>
<body>
  <div id= fondo> <!-- originalmente "id=fondo"-->
    <div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
      <img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="166" height="198">
      <img id= img2 src='img/escudounam-color.png' width="174" height="221">
      <!-- Reducidas en 20 puntos los escudos de UNAM y FI -->
      <!-- Todos los textos de clase "centro" en formato px reducidos en 2 puntos-->
      <!-- Sección donde va el nombre del curso  sustituída de h2 a div -->
      <!--Sección donde va fecha de impartición, el padding-top reducido en 7cm-->
      <!-- Encabezados 2 y 3 con line-height al 100%; encabezado4 al 150%; encabezado5 al 170%-->
      <!-- Folio y numero inferior intercambiados de derecha a izquierda e izquierda a derecha respectivamente-->
      <!--Folio y numero_inferior reducido el atributo "bottom" en 1-->
      <!--Clase .nombre_profersor reducido el atributo "line_height en 100%"-->
      <!--Clase .encabezado5 reducido el atributo "line height" en 50%-->
      <!--Sección "Otorgan la presente constancia" añadido un margin-top de 1.5cm-->
       <!--Sección "fechaimp" aumentado el padding-top en 1cm-->
        <!--Sección "Ciudad Universitaria, Cd. Mx.,..." añadido un padding-bottom de 2cm-->
         <!--Clase .folio añadido el font-size 12px; modificdo el bottom a 1cm-->
         <!--Clase .firma reducido el line-height de 80% a 50%-->
          <!--Clase .firma1 reducido el line-height de 100% a 10%-->
          <!--Clase .fondo añadido en url: ("../public/img/ri_1.png") para hacer funcionar background-->


      

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
          <div class='nombre_curso'>{{$cursoCatalogo->nombre_curso}}</div> <!--Originalmente h2-->
          <p style="padding-top: 0.3cm; font-size:105%;">{{$fechaimp}}</h5> 
          <p style="padding-bottom: 0.4cm; font-size:105%">Duración: {{$cursoCatalogo->duracion_curso }} h</h5>
          <p style="line-height: 20%; font-size: 15px; font-weight: bold;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
          <p style="font-size: 11px; padding-bottom: 2.35cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
        </div>
  <table class="tabla-centro">
    <tr>
      <td width=230 class="firma1">___________________</td>
      <td width=230 class="firma1">___________________</td>
      <td width=230 class="firma1">___________________</td>
    </tr>
    <tr>
      <td width=230 class="firma" style="font-weight: bold;">{{$instructor1->abreviatura_grado}} {{$instructor1->nombres}} {{$instructor1->apellido_paterno}} {{ $instructor1->apellido_materno }}</td>
      <td width=230 class="firma" style="font-weight: bold;">{{$instructor2->abreviatura_grado}} {{$instructor2->nombres}} {{$instructor2->apellido_paterno}} {{ $instructor2->apellido_materno }}</td>
      <td width=230 class="firma" style="font-weight: bold;">{{$coordinacion->grado}} {{$coordinacion->coordinador}}</td>
    </tr>
    <tr>
      <td class="firma" style="font-size: 10px;">Instructor</td>
      <td class="firma" style="font-size: 10px;">Instructor</td>
      <td class="firma" style="font-size: 10px;">Coordinador de {{$coordinacion->nombre_coordinacion}}</td>

    </tr>
  </table>

  <table width=100% style="padding-top: 0.2cm; bottom: 1cm;"> <!-- Reducido el padding-top de 90% a 0.2cm; añadido un bottom de 1cm--> 
  <tr width=100% >
@if($folio_der >= 0)
<td id="numero_inferior">{{ $folio_der }}</td>
@endif
    <td id="folio">{{ $folio }}</td>
  </tr>
</table>





</div>
<!--<table width=100% style="padding-top: 1%;"> --><!-- Reducido el padding-top de 90% a 1%--> 
  <!--<tr width=100% >
    <td id="folio">{{ $folio }}</td>-->
    <!-- <td id="numero_inferior">{{ $folio_der }}</td> --> <!--Linea comentada para que no aparezca elnumero inferior-->
  <!--</tr>
</table>-->
</body>
</html>
