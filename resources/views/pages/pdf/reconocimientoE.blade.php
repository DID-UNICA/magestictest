<!DOCTYPE html>
<head>
    <title>Coordinacion General</title>
</head>
<style>
html{
  width:100%;
  height:100%;
}
@page{
  margin-bottom: 0px;
}
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
}
.texto{
    font-size: 20px; 
    text-align: center; 
    margin-left: 26%;
    margin-right: 26%;
    line-height: 0.5cm;
    margin-bottom: 0.1cm;
}

</style>
  <body id=fondo>
    <div>
      <div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
      <img id=img1 src="img/escudo_fi_color.png" width="166" height="198">
      <img id= img2 src='img/escudounam-color.png' width="174" height="221">
      <div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
      <div id=encabezado_3 style="padding-top: 0.1cm;">SECRETARÍA DE APOYO A LA DOCENCIA</div>
      <div id=encabezado_4>CENTRO DE DOCENCIA</div>
      <div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
      <br>
      <div class="centro">
        <h3 style="text-align: center;font-size: 18pt;font-style: normal; margin-top: 0.4cm;">Otorgan el presente</h3>
        <h3 style="text-align: center;font-size: 18pt;font-style: normal; margin-top: 0.9cm;">A G R A D E C I M I E N T O</h3>
        @if($profesor->genero=="masculino")
          <h3 style="text-align: center;font-size: 16pt;font-style:normal; margin-top: 0.8cm;">al: </h2>
        @elseif($profesor->genero=="femenino")
          <h3 style="text-align: center;font-size: 16pt;font-style: normal; margin-top: 0.8cm;"> a la: </h2>
        @else
          <h3 style="text-align: center;font-size: 16pt;font-style: normal; margin-top: 0.8cm;"> a: </h2>
         @endif
        <br>
        <h1 class='nombre_profesor' style="margin-top: 0.2cm; margin-bottom: -0.5cm;">{{$profesor->abreviatura_grado}} {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h1>

        <table width="15cm" align="center">
          <tr width="15cm">
          @if(strlen($cursoCatalogo->nombre_curso) < 110)
            <td height="0.5cm" align="center" vertical-align="top" style="font-size: 14pt; vertical-align: top; font-weight: bold; line-height: 100%;">{{$tema}}</td>
          </tr>
          <tr width="15cm">
            <td height="2cm" align="center" vertical-align="top" class='nombre_curso' style="vertical-align: top; font-weight: bold;">{{$cursoCatalogo->nombre_curso}}</td>
          @else
            <td height="0.5cm" align="center" vertical-align="top" style="font-size: 12pt; vertical-align: top; font-weight: bold; line-height: 100%;">{{$tema}}</td>
          </tr>
          <tr width="15cm">
            <td height="2cm" align="center" vertical-align="top" class='nombre_curso' style="vertical-align: top; font-weight: bold; font-size: 18pt;">{{$cursoCatalogo->nombre_curso}}</td>
          @endif
          </tr>
        </table>


        <p style=" font-size: 12pt;">{{$fechaimp}}</p>
        <p style="padding-top: 0.3cm; padding-bottom: 0.3cm; font-size: 12pt">Duración: {{$cursoCatalogo->duracion_curso }} h</p>
        <p style="line-height: 20%; font-size: 12pt; font-weight: bold; padding-bottom: 0.2cm;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</p>
        <p style="font-size: 8pt; padding-bottom: 0.8cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</p>
      </div>

      <div class = "tabla-centro" style="position: relative;">
        <table class = "tabla-centro">
          <tr>
            @if($numFirmantes == 1){
            <td width=260 class="firma1" style="padding-top: 1cm;">___________________</td>
            }@elseif($numFirmantes == 2){
            <td width=260 class="firma1" style="padding-top: 1cm; padding-left: 2.5cm;">___________________</td>
            <td width=260 class="firma1" style="padding-top: 1cm;
              padding-right: 2.5cm;">___________________</td>
            }@elseif($numFirmantes == 3){
            <td  class="firma1" style="padding-top: 1cm;">___________________</td>
            <td  class="firma1" style="padding-top: 1cm;">___________________</td>
            <td  class="firma1" style="padding-top: 1cm;">___________________</td>
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
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 2){
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm; padding-left: 2.5cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm; padding-right: 2.5cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 3){
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[2]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[0]}}</td>
            }@elseif($numFirmantes == 4){
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[3]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[2]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[1]}}</td>
            <td  class="firma" style="font-weight: bold; font-size: 9pt; padding-top: 0.2cm;">{{$firmantes[0]}}</td>
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
                  <td class='firma' style='font-size: 8pt; padding-left: 2.5cm;'>{{$descripciones[1]}}</td>
                  <td class='firma' style='font-size: 8pt; padding-right: 2.5cm;'>{{$descripciones[0]}}</td>
            }@elseif($numFirmantes == 3){
              <?php
                if($length2 >= 27 and $length1 < 27 and $length0 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt; padding-left: 3cm; padding-right: 3cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 3cm; padding-right: 3cm;'>{$descripciones[0]}</td>");
                }elseif($length1 >= 27 and $length0 < 27 and $length2 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt; padding-left: 5cm; padding-right: 5cm;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }elseif ($length0 >= 27 and $length1 < 27 and $length2 < 27) {
                  print("
                  <td class='firma' style='font-size: 8pt;padding-left: 3cm; padding-right: 3cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt; padding-left: 3cm; padding-right: 3cm;'>{$descripciones[0]}</td>");
                }
                elseif ($length2 >= 27 and $length1 >= 27 and $length0 >= 27) {
                  print("
                  <td class='firma' style='font-size: 8pt; padding-left: 2cm; padding-right: 2cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt; padding-left: 2cm; padding-right: 2cm;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt; padding-right: 2cm; padding-left: 2cm'>{$descripciones[0]}</td>");
                }
                else{
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }
              ?>


            }@elseif($numFirmantes == 4){

              <?php
                if($length3 >= 27 and $length1 < 27 and $length0 < 27 and $length2 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[0]}</td>");
                }elseif($length2 >= 27 and $length1 < 27 and $length0 < 27 and $length3 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }elseif($length1 >= 27 and $length0 < 27 and $length2 < 27 and $length3 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }elseif ($length0 >= 27 and $length1 < 27 and $length2 < 27 and $length3 < 27) {
                  print("
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[0]}</td>");
                }
                elseif ($length2 >= 27 and $length1 >= 27 and $length0 >= 27 and $length3 >= 27) {
                  print("
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 1cm; padding-right: 1cm;'>{$descripciones[0]}</td>");
                }
                else{
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }
              ?>

            }@elseif($numFirmantes == 5){
              <?php
              if($length4 >= 27 and $length1 < 27 and $length0 < 27 and $length2 < 27 and $length3 < 2){
                print("
                <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[4]}</td>
                <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[0]}</td>");
              }elseif($length3 >= 27 and $length1 < 27 and $length0 < 27 and $length2 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[4]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }elseif($length2 >= 27 and $length1 < 27 and $length0 < 27 and $length3 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[4]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }elseif($length1 >= 27 and $length0 < 27 and $length2 < 27 and $length3 < 27){
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[4]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }elseif ($length0 >= 27 and $length1 < 27 and $length2 < 27 and $length3 < 27) {
                  print("
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[4]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[0]}</td>");
                }
                elseif ($length2 >= 27 and $length1 >= 27 and $length0 >= 27 and $length3 >= 27 and $length4 >= 27) {
                  print("
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[4]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;padding-left: 0.3cm; padding-right: 0.3cm;'>{$descripciones[0]}</td>");
                }
                else{
                  print("
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[4]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[3]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[2]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[1]}</td>
                  <td class='firma' style='font-size: 8pt;'>{$descripciones[0]}</td>");
                }
              ?>
            }
            @endif
          </tr>
        </table>
      </div>
    </div>
    <table width=auto style="vertical-align: top; padding-top: 1cm; margin: 0px; position: absolute;">
      <tr width=auto>
        <td id="numero_inferior" style="left: 1.2cm;">{{ $folio_der }}</td>
        <td id="folio" style=" padding-left: 21.3cm; right:1.2cm;">{{ $folio }}</td>
      </tr>
    </table>
  </body>
</html>

