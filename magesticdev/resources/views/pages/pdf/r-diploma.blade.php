
<!DOCTYPE html>
<head>
    <title>Coordinacion General</title>
</head>
<style>
html{
	    width:100%;
      height: 100%;
      margin: 0px;
    }
body {
  font-family:Arial, Helvetica, Sans-serif,cursive;
}
#fondo{
  background: url("/img/BGDiplomas.jpg");
  background-repeat: no-repeat;
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
    padding-top: 15%;
}
.nombre_diplomado{
    font-family:'Campan', serif;
    font-style:italic;
    color: #003796;
    font-size: 33px;
    line-height: 100%
}
.centro {
    line-height: 20%;
    text-align: center;
}
.por{
  font-size: 19px;
  line-height: 30%;
  font-style: normal;
}
.datos_diplomado{
  font-size: 14px;
  padding-bottom: 2px;
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
  padding-bottom: 1%;
}
.firma3{
  text-align:center;
  vertical-align:top;
  align:center;
}
.firma1{
  text-align:center;
  vertical-align:top;
  align:center;
  padding-bottom: 1%;
  line-height: 300%;
}
.tabla-centro{
  width: 80%;
  
  margin-left: 10%;
  padding-bottom: 5%;
}

.firmas{
  width: 100%;
  margin-left: 0%;
  
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
  text-align: left;
  padding-left: 5%;
}
.califi{
  text-align: center;
  padding-left: 1%;
  padding-right: 1%;
}
.prom{
  text-align: right;
  font-weight: bold;
  padding-right: 3%;
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
  text-align: center;
}
.modulo{
  font-weight: bold;
}
</style>
  <body>
  <div id=fondo>
    <div class=encabezado id=encabezado_1>Universidad Nacional Autónoma de México</div>
    <div class=encabezado id=encabezado_2>Facultad de Ingeniería</div>
    <div class=encabezado id=encabezado_3>Secretaría de Apoyo a la Docencia</div>
    <div class=encabezado id=encabezado_4>Centro de Docencia "Ing. Gilberto Borja Navarrete" </div>
    <br>
    <div class="centro">
      <br>
        <p class='nombre_profesor'>{{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</p>
      <p class='por'>por haber concluido satisfactoriamente los estudios del:</p>
      <p class='nombre_diplomado'>Diplomado "{{$diplomado->nombre_diplomado}}"</p>
    </div>
    <div>
      <p class="datos_diplomado">{{$fechaimp}}</h5>
      <p class="datos_diplomado">Duración: {{$duracion}} h</h5>
      <p class="datos_diplomado">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
      <p class="datos_diplomado">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
    </div>
    <div class = "tabla-centro">
    <table class = "firmas" >
      <tr>
        <td  class="firma1">___________________</td>
        <td  class="firma1">___________________</td>
        <td  class="firma1">___________________</td>
      </tr>
      <tr>
        <td  class="firma2" style="font-size: 15px;">{{$coordinadorGeneral->grado}} {{ $coordinadorGeneral->coordinador }}</td>
        <td  class="firma2" style="font-size: 15px;">{{$secretarioApoyo->grado}} {{$secretarioApoyo->secretario}}</td>
        <td  class="firma2" style="font-size: 15px;">{{$direccion->grado}} {{$direccion->director }}</td>
      </tr>
      <tr>
        <td class="firma3" style="font-size: 15px;">Coordinadora del Centro de Docencia</td>
        <td class="firma3" style="font-size: 15px;">Secretaría de Apoyo a la Docencia</td>
        <td class="firma3" style="font-size: 15px;">Director de la Facultad de Ingeniería</td>
      </tr>
    </table>
    </div>
  </div>
  <div width = 100%>
  <table class = "calificaciones">
    <tr>
      <th>Módulo</th>
      <th>Calificación</th>
    </tr>
    @foreach($cursos as $curso)
    <tr>
      <td class = "izq">
        <span class ="modulo">Módulo {{$curso->getNumModulo($diplomado->id)}}.</span>
        <span>{{$curso->getNombreCursoSinClave()}}</span>
      </td>
      <td class = "califi">
        <span class = "calif">{{$calificaciones[$loop->index]}}</span>
      </td>
    </tr>
    @endforeach
    <tr>
      <td class = "prom"><b>PROMEDIO</b></td>
      <td class = "califi">{{$promedio}}</td>
    </tr>
  </table>
  <table class="folios">
    <tr>
      <td>Duración: {{$duracion}}</td>
    </tr>
    <tr>
      <td>Asistentes: {{$asistentes}}</td>
    </tr>
    <tr>
      <td>Libro: {{$libro}}</td>
    </tr>
    <tr>
      <td>Foja: {{$foja}}</td>
    </tr>
    <tr>
      <td><td>
    </tr>
    <tr>
      <td>Folio: {{$folio_der}}<br>{{$folio}}</td>
    </tr>
  </table>
  </div>
  </body>
</html>