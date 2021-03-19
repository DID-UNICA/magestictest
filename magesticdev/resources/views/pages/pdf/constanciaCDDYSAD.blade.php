<!DOCTYPE html>
<head>
    <title>Coordinacion General</title>
</head>
<style>
html{
      width: auto;
      height: auto;
    }

@page{ margin-bottom: 0px; }

body {
  font-family:Arial, Helvetica, Sans-serif,cursive;
  margin-bottom: 0px;

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
  color: #8D8D8D;
}
#folio{
  font-size: 10pt;
  text-align: right;
  color: #8D8D8D;
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
  width: 65%;
  margin-left: 16%;
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
      <h3 style="text-align: center;font-size: 18pt;font-style: normal; margin-top: 1.5cm;">Otorgan la presente constancia a:</h2>
      <br>
        <h2 class='nombre_profesor'>{{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
      <h3 style="font-size: 14pt;line-height: 30%;">por acreditar el {{$curso->getTipoCadena()}}</h3>
      <div class='nombre_curso'>{{$cursoCatalogo->nombre_curso}}</div>
      <p style="padding-top: 0.3cm; font-size: 12pt;">{{$fechaimp}}</h5>
      <p style="padding-top: 0.4cm; padding-bottom: 0.4cm; font-size: 12pt">Duración: {{$cursoCatalogo->duracion_curso }} h</h5>
      <p style="line-height: 20%; font-size: 12pt; font-weight: bold;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
      <p style="font-size: 8pt; padding-bottom: 1.5cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
    </div>



    <!--<div class = "tabla-centro" style="padding-bottom: 0.2cm;">




    </div> -->


    <table width=auto style="padding-left: 2.5cm;">
      <tr width=auto>
        <td width=260 class="firma1" style="padding-top: 1cm;">_____________________</td>
        <td width=260 class="firma1" style="padding-top: 1cm; padding-left: 1.2cm;">_____________________</td>
      </tr>
    </table>

    <table width=auto style=" padding-left: 4cm;">
      <tr width=auto>
        <td class="firma" style="font-weight: bold; font-size: 11pt; padding-top: 0.2cm;"> M.E.M Margarita Ramírez Galindo</td> <!-- originalmente basado en la ConstanciaSADYDirector-->
        <td width=260 class="firma" style="font-weight: bold; font-size: 11pt; padding-top: 0.2cm; padding-left: 2.7cm;">Mtra. Claudia Loreto Miranda </td>
        <!-- originalmente  basado en la ConstanciaSADYDirector-->
      </tr>


      <tr>
        <td class="firma" style="font-size: 8pt;">Coordinadora del Centro de Docencia</td>
        <td class="firma" style="font-size: 8pt; padding-left: 2.5cm;">Secretaria de Apoyo a la Docencia</td>
      </tr>
    </table>



<!--Version con tabla separada -->



<!---->
  </div>
      <table width=auto style="vertical-align: top; padding-top: 1.5cm;">
      <tr width=auto>
        <td id="numero_inferior" style="left: 1.2cm;"> {{ $folio_der }}</td>
        <td id="folio" style=" padding-left: 21.3cm; right:1.2cm;"> {{ $folio }}</td>
      </tr>
    </table>




  </body>





</html>