<!DOCTYPE html>
<head>
    <title>Coordinación General</title>
</head>
<style>

html{
  width:100%;
  height:100%
}
@page{ margin-bottom: 0px; }

body {
  font-family:Arial, Helvetica, Sans-serif,cursive;
}
#fondo{
  background-image: url("../public/img/ri_1.png");
  background-size: auto;
  background-repeat: no-repeat;
  background-position: 4cm 1.9cm;
  bottom: 0.75cm;
  right: 1.2cm;
}
#numero_inferior{
  text-align: left;
  bottom: 2px;
  left: 19px;
  color: black;
}
#folio{
  font-size: 10pt;
  text-align: right;
  color: black;
  margin-right: 2%;
  margin-left: 82%;
}
.encabezado{
  line-height:170%;
  text-align: center;
}
#encabezado_1{
  font-size: 22pt;
  font-weight: bold;
}
#encabezado_2{
  font-size: 22pt;
  font-weight: bold;
  line-height: 100%;
}
#encabezado_3{
  font-size: 18pt;
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
  font-size: 18pt;
  font-weight: bold;
  line-height: 150%;
  text-align: center;
}
#encabezado_5{
  font-size: 18pt;
  font-style: italic;
  font-family:'Tangerine', serif;
  line-height: 120%;
  text-align: center;
  font-weight: bold;
}
.nombre_profesor{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 24pt;
    line-height: 100%
}
.nombre_curso{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 22pt;
    line-height: 100%;
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
  line-height: 85%;
}
.firma1{
  text-align:center;
  vertical-align:top;
  align:center;
  padding-top: 0.5cm;
  line-height: 10%;
}
.tabla-centro{
  width: 100%;
  align-content: center;
  align-items: center;
}

</style>
  <body id=fondo>
    <div>
      <div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
      <img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="166" height="198">
      <img id= img2 src='img/escudounam-color.png' width="174" height="221">
      <div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
      <div id=encabezado_3>SECRETARÍA DE APOYO A LA DOCENCIA</div>
      <div id=encabezado_4>CENTRO DE DOCENCIA</div>
      <div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
      <br>
      <div class="centro">
      @if($profesor->genero=="masculino")
        <h3 style="text-align: center;font-size: 18pt;font-style: normal; margin-top: 1cm;">Otorgan el presente reconocimiento al:</h2>
      @elseif($profesor->genero=="femenino")
      <h3 style="text-align: center;font-size: 18pt;font-style: normal; margin-top: 1cm;">Otorgan el presente reconocimiento a la:</h2>
      @else
      <h3 style="text-align: center;font-size: 18pt;font-style: normal; margin-top: 1cm;">Otorgan el presente reconocimiento a:</h2>
      @endif
        <br>
        <h2 class='nombre_profesor'>{{$profesor->abreviatura_grado}} {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>

        <table width="15cm" align="center">
          <tr width="15cm">
          <td height="0.5cm" align="center" style="font-size: 14pt; vertical-align: top; font-weight: bold;">{{$texto}}</td>
          </tr>
          <tr width="15cm">
            <td height="2cm" align="center" vertical-align="top" class='nombre_curso' style="vertical-align: top; font-weight: bold;">{{$cursoCatalogo->nombre_curso}}</td>
          </tr>
        </table>


      <!-- <h3 style="font-size: 14pt;padding-top: 0.5cm;">por impartir el {{$curso->getTipoCadena()}}</h3>
        <h2 class='nombre_curso' style="padding-top: 0.2cm;">{{$cursoCatalogo->nombre_curso}}</h2> -->


        <p style="font-size:12pt;">{{$fechaimp}}</h5>
        <p style="padding-bottom: 0.3cm; padding-top: 0.3cm; font-size:12pt">Duración: {{$cursoCatalogo->duracion_curso }} h</h5>
        <p style="line-height: 20%; font-size: 12pt; font-weight: bold; padding-bottom: 0.2cm;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
        <p style="font-size: 8pt; padding-bottom: 1cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
      </div>

      <div class="tabla-centro" style="position: relative;">
        <table class="tabla-centro">
          <tr>
            @if($numFirmantes == 1){
            <td width=260 class="firma1" style="padding-top: 1cm;">___________________</td>

            }@elseif($numFirmantes == 2){
            <td width=260 class="firma1" style="padding-top: 1cm; padding-left: 2.5cm;">___________________</td>
            <td width=260 class="firma1" style="padding-top: 1cm; padding-right: 2.5cm;">___________________</td>

            }@elseif($numFirmantes == 3){
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            }@elseif($numFirmantes == 4){
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            }@elseif($numFirmantes == 5){
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            <td class="firma1" style="padding-top: 1cm;">___________________</td>
            }
            @endif
          </tr>
          <tr>
            @if($numFirmantes == 1){
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 2){
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm; padding-left: 2.5cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm; padding-right: 2.5cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 3){
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[2]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 4){
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[3]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[2]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 10pt; padding-top: 0.3cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 5){
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[4]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[3]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[2]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[0]}}</td>
            }
            @endif
          </tr>
          <tr>
            @if($numFirmantes == 1){
            <td class="firma" style="font-size: 8pt;">{{$descripciones[0]}}</td>
            }@elseif($numFirmantes == 2){
              <table width="4.2cm" style="position: absolute; top: 1.8cm; left: 5.5cm;">
                <tr>
                  <td width="2cm" height="0.25cm" class="firma" style="font-size: 8pt;">          {{$descripciones[1]}}</td>
                </tr>
              </table>
              <table width="4.2cm" style="position: absolute; top: 1.8cm; right:5.5cm;">
                <tr>
                  <td width="2cm" height="0.25cm" class="firma" style="font-size: 8pt;">          {{$descripciones[0]}}</td>
                </tr>
              </table>
            }@elseif($numFirmantes == 3){
            <td class="firma" style="font-size: 8pt;">{{$descripciones[2]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[1]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[0]}}</td>

            }@elseif($numFirmantes == 4){
            <td class="firma" style="font-size: 8pt;">{{$descripciones[3]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[2]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[1]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[0]}}</td>

            }@elseif($numFirmantes == 5){
            <td class="firma" style="font-size: 8pt;">{{$descripciones[4]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[3]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[2]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[1]}}</td>
            <td class="firma" style="font-size: 8pt;">{{$descripciones[0]}}</td>
            }
            @endif
          </tr>
        </table> 
      </div>
    </div>
    <table width=auto style="vertical-align: top; padding-top: 1cm; position: absolute;">
      <tr width=auto>
        <td id="numero_inferior" style="left: 1.2cm;"> {{ $folio_der }}</td>
        <td id="folio" style=" padding-left: 21.3cm; right:1.2cm;"> {{ $folio }}</td>
      </tr>
    </table>
  </body>
</html>