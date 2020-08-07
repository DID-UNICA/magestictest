<!DOCTYPE html>
<head>
    <title>Coordinacion General</title>
</head>
<style>
body {
  font-family:Arial, Helvetica, Sans-serif,cursive;
}
#fondo{
  background-image: url("/img/BGDiplomas.jpg");
  background-repeat: no-repeat;
  background-position: center;
  

}
#numero_inferior{
  position: absolute;
  bottom: 3px;
  right: 19px;
  color: #8D8D8D;
}
#folio{
  position: absolute;
  bottom: 3px;
  left: 19px;
  color: #8D8D8D;
}
.encabezado{
  line-height:160%;
  text-align: center;
}
#encabezado_1{
  font-size: 30px;
  font-weight: bold;
}
#encabezado_2{
  font-size: 27px;
  font-weight: bold;
}
#encabezado_3{
  font-size: 25px;
  font-weight: bold;
  line-height: 230%;
  text-align: center;
}
#encabezado_4{
  font-size: 25px;
  font-weight: bold;
  line-height: 230%;
  text-align: center;
}
#encabezado_5{
  font-size: 23px;
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
    line-height: 20%
    text-align: center;
}
.page-break {
    page-break-after: always;
}

#coordinador{
  font-weight: bold;
}
</style>
  <body>
  <div id=fondo>
  <div align=center;>
    <div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
      <img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="160" height="184" align=right>
      <img id= img2 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudos/escudounam_color.jpg" width="170" height="190" align=left>

        <div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
        <div id=encabezado_3>SECRETARÍA DE APOYO A LA DOCENCIA</div>
        <div id=encabezado_4>CENTRO DE DOCENCIA</div>
        <div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
        <br>
        <div class="centro">
          <h3 style="text-align: center;font-size: 22px;font-style: normal; line-height: 20%;">Otorgan el presente diploma a</h2>
          <br>
          <br>
          @if ($profesor->grado == "Bachillerato")
            <h2 class='nombre_profesor'>Br. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
          @elseif ($profesor->grado == "Carrera Tecnica")
            <h2 class='nombre_profesor'>Téc. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
          @elseif ($profesor->grado == "Licenciatura")
            <h2 class='nombre_profesor'>Lic. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
          @elseif ($profesor->grado == "Ingeniería")
            <h2 class='nombre_profesor'>Ing. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
          @elseif ($profesor->grado == "Maestría")
           @if($profesor->genero == "masculino")
            <h2 class='nombre_profesor'>Mtro. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
           @elseif($profesor->genero == "femenino")
            <h2 class='nombre_profesor'>Mtra. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
           @endif
          @elseif ($profesor->grado == "Especialidad")
            <h2 class='nombre_profesor'>Esp. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
          @elseif ($profesor->grado == "Doctorado")
           @if($profesor->genero == "masculino")
            <h2 class='nombre_profesor'>Dr. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
           @elseif($profesor->genero == "femenino")
            <h2 class='nombre_profesor'>Dra. {{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
           @endif
          @else
           <h2 class='nombre_profesor'>{{$profesor->nombres}} {{$profesor->apellido_paterno}} {{$profesor->apellido_materno}}</h2>
          @endif
          <h3 style="font-size: 17px;line-height: 20%;">por haber acreditado el {{$diplomado->nombre_diplomado }}</h3>
          <h6 style="line-height: 20%;">"POR MI RAZA HABLARÁ EL ESPÍRITU"</h6>
          <h6 style="font-size: 15px;">Ciudad Universitaria, Cd. Mx., {{$fecha}}</h6>
        </div>
    </div>
    <table>
    <tr>

<td width=765 align=center>___________________________</td>

</tr>
<br>
<tr style="line-height: 100%">

<td width=400 align=center> {{ $director->director }}</td>

</tr>
<tr style="line-height: 100%">

<td align=center style="font-size: 10px;line-height: 20%;">Director de la Facultad de Ingeniería</td>

</tr>

    </table>
  <div id=folio>
   folio
  </div>
  <div class="page-break"></div>
  </div>

  <table>
    <tr>
        <th>Curso</th>
        <th>Calificaciones</th>
    </tr>
    @for ($i = 0; $i < sizeof($cursos); $i++)
        <tr>
            <td>{{ $cursos[$i]->getNombreCurso() }}</td>
            <td>{{ $calificaciones[$i] }}</td>
        </tr>
    @endfor

  </table>

  <div id="numero_inferior">9074</div>
  </body>
</html>
