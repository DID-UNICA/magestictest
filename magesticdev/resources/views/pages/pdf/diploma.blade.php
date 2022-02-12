<!DOCTYPE html>
<head>
    <title>Diploma</title>
</head>
<style>
html{
	    width:100%;
      height: 100%;
      margin: 0px;
    }

@page{
  margin-bottom: 0px;
}
body {
  font-family:Arial, Helvetica, Sans-serif,cursive;
}
#fondo{
  background: url("../public/img/BGDiplomas.jpg");
  background-size: 100%;
  background-repeat: no-repeat;
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
  
  margin-left: 82%;
}
.encabezado{
  font-size: 16px;
  line-height:150%;
  text-align: center;
}

#encabezado_1{
  padding-top: 6%;
}
.nombre_profesor{
    font-family:'Tangerine', serif;
    font-style:italic;
    font-size: 43px;
    line-height: 100%;
    padding-top: 12%;
}
.nombre_diplomado{
    font-family:'Campan', serif;
    font-style:italic;
    color: #003796;
    font-size: 33px;
    text-align: center;
    
}
.centro {
    text-align: center;
}
.por{
  font-size: 19px;
  line-height: 30%;
  font-style: normal;
}
.datos_diplomado{
  font-size: 14px;

  text-align: center;
}
.page-break {
  page-break-after: always;
}
#coordinador{
  font-weight: bold;
}
.firma2{
  text-align:center;
  vertical-align:top;
  align:center;
  margin-bottom: 0cm;
  font-weight: bold;
}
.firma3{
  text-align:center;
  vertical-align:top;
  align:center;
  margin-bottom: 0cm;
}
.firma1{
  text-align:center;
  vertical-align:top;
  align:center;
  margin-bottom: 0cm;
}

.tabla-centro{
  width: 80%;
  margin-left: 10%;
}
.firmas{
  width: 100%;
  margin-left: 0%;
  margin-bottom: 0cm;
}

.calificaciones {
  border:solid;
  margin:auto;
  border-collapse: collapse;
  padding-top: 8%;
}
.calificaciones td,th{
  border:solid;
  padding-bottom: 3%;
  padding-left: 3%;
  padding-right: 3%;
}
.izq{
  width: 75%;
  text-align: left;
  padding-left: 5%;
  font-size: 13px;
}
.califi{
  font-size: 13px;
  text-align: center;
  padding-left: 1%;
  padding-right: 1%;
}
.prom{
  text-align: right;
  font-weight: bold;
  padding-left: 15%;
}
.calificaciones th{
  text-align: center;
  font-weight: bold;
  padding-left: 5%;
  padding-right: 5%;
}
.folios{  
  border:solid;
  margin: auto;
  margin-top: 10%;
}
.folios td{
  text-align: center;
  font-style: bold;
  font-size: 13px;
  padding-left: 15%;
  padding-right: 15%;
  padding-top: 1%;
  font-weight: bold;
}
.calif{
  padding-top:5%;
  text-align: center;
}
.modulo{
  font-weight: bold;
}
</style>
  <body id=fondo>
  <div>
    <div class=encabezado id=encabezado_1>Universidad Nacional Autónoma de México</div>
    <div class=encabezado id=encabezado_2>Facultad de Ingeniería</div>
    <div class=encabezado id=encabezado_3>Secretaría de Apoyo a la Docencia</div>
    <div class=encabezado id=encabezado_4>Centro de Docencia "Ing. Gilberto Borja Navarrete" </div>
    <br>
    <div class="centro">
      <p class='nombre_profesor'>{{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</p>
      <p class='por' style="padding-top: 3.8cm;">por haber concluido satisfactoriamente los estudios del:</p>
      <table width="15cm" align="center" style="margin-top: -0.2cm; margin-bottom: -0.4cm;">
        <tr width="15cm">
          @if(strlen($diplomado->nombre_diplomado) < 70)
            <td class='nombre_diplomado' height="2cm" style="vertical-align: super;">"{{$diplomado->nombre_diplomado}}"</td>
          @elseif(strlen($diplomado->nombre_diplomado) < 100)
            <td class='nombre_diplomado' height="2cm" style="vertical-align: super; font-size: 18pt;">"{{$diplomado->nombre_diplomado}}"</td>
          @elseif(strlen($diplomado->nombre_diplomado) < 180)
            <td class='nombre_diplomado' height="2cm" style="vertical-align: super; font-size: 16pt;">"{{$diplomado->nombre_diplomado}}"</td>
          @else
            <td class='nombre_diplomado' height="2cm" style="vertical-align: super; font-size: 14pt;">"{{$diplomado->nombre_diplomado}}"</td>
          @endif
        </tr>
      </table>
    </div>
    <div>
      <p class="datos_diplomado" style="margin-bottom: 0cm; padding-top: 0.2cm;">Del {{$fechaimp}} </h5>
      <p class="datos_diplomado" style="margin-bottom: 0cm;">Duración: {{$duracion}} h</h5>
      <p class="datos_diplomado" style="margin-bottom: 0cm; font-weight: bold;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
      <p class="datos_diplomado" style="margin-bottom: 0cm;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
    </div>
    <div class = "tabla-centro" style="padding-top: 1.6cm;">
    
    <table class = "firmas" >
      <tr>
        <td  class="firma1">______________________</td>
        <td  class="firma1">______________________</td>
        <td  class="firma1">______________________</td>
      </tr>
      <tr>
        <td  class="firma2" style="font-size: 15px;">{{ $coordinadorGeneral->getNombreFirma() }}</td>
        <td  class="firma2" style="font-size: 15px;">{{ $secretarioApoyo->getNombreFirma() }}</td>
        <td  class="firma2" style="font-size: 15px;">{{ $direccion->getNombreFirma() }}</td>
      </tr>
      <tr>
        <td class="firma3" style="font-size: 8pt;">{{$coordinadorGeneral->getDescripcion()}}</td>
        <td class="firma3" style="font-size: 8pt;">{{$secretarioApoyo->getDescripcion()}}</td>
        <td class="firma3" style="font-size: 8pt;">{{$direccion->getDescripcion()}}</td>
      </tr>
    </table>
    </div>
  </div>

    <table width=auto style="vertical-align: top; padding-top: 1cm; margin: 0px;">
    @if($folio != '')
      <tr width=auto>
        <td id="folio" style=" padding-left: 22.5cm; right:1.2cm;"> {{ $folio }}</td>
      </tr>
    @endif
    </table>

</body>

<body style="background-color: white;">
  <div width = 100%>
  <br>
  <br>
  <table class = "calificaciones" width="58%" >
    <tr>
      <th width=80% style="padding-right:33%;">Módulos</th>
      <th widht=20% style="padding-right:10%; text-align: center;">Calificación</th>
    </tr>
    @foreach($cursos as $curso)
    <tr>
      <td width=80% class = "izq">
       {{$curso->getNombreCursoSinClave()}}
      </td>
      <td width=20% class = "califi">
        {{$calificaciones[$loop->index]}}
      </td>
    </tr>
    @endforeach
    <tr>
      <td width=80% class = "prom" style="text-align:right">PROMEDIO</td>
      <td width=20% class = "califi">{{$promedio}}</td>
    </tr>
  </table>
  <table class="folios"  width="20%" style="text-align:left;">
    <tr>
      <td>Duración: {{$duracion}}h</td>
    </tr>
    <tr>
      <td>Asistentes: {{$asistentes}}</td>
    </tr>
    @if($libro != '')
      <tr>
        <td>Libro: {{$libro}}</td>
      </tr>
    @endif
    @if($foja!='')
      <tr>
        <td>Foja: {{$foja}}</td>
      </tr>
    @endif
    <tr>
      <td><td>
    </tr>
    @if(intval($folio_der)>0)
      <tr>
        <td>Folio: {{$folio_der}}</td>
      </tr>
    @endif
    @if($folio != '')
      <tr>
        <td>{{$folio}}</td>
      </tr>
    @endif
  </table>
  </div>
  </body>
</html>