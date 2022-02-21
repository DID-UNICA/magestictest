<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Historial</title>
</head>
<style>

html{
	width:100%;
}
body {
  font-family: Arial, Helvetica, Sans-serif;
  align-items: center;
  font-size: 18px;
}

hr{
  border: 1px solid #000;
  border-spacing: 0;
}
.content{
  margin-left: 4%;
  margin-right: 7%;
}
#mayusculas{
	text-transform: uppercase;
}
#renglonDoble, #mayusculas{
	border: 1px solid white;
}
#normal{
  border-spacing: 0;
}
.encabezado{
  text-align: center;
}
#encabezado_1{
  font-size: 22px;
  font-weight: bold;
}
#encabezado_2{
  font-size: 22px;
  font-weight: bold;
  padding-bottom: 1%;
}
#encabezado_3{
  font-size: 22px;
  font-weight: bold;
  text-align: center;
}
#encabezado_4{
  font-size: 20px;
  font-weight: bold;
  text-align: center;
}
#encabezado_5{
  font-size: 20px;
  font-style: italic;
  font-family:'Tangerine', serif;
  text-align: center;
	line-height: 230%;
  font-weight: bold;
  padding-bottom: 2%;
}
#encabezado_6{
  font-size: 17px;
  font-weight: bold;
  padding-bottom: 2%;
}
.img{
  padding-top: 3%;
}
.table-cursos{
    width: 80%;
}
.table-cursos .col-th-cursos{
    font-weight:bold;
    text-align:left;
    vertical-align:top;
    font-size: 15px;
    padding-bottom: 2%;
}
.table-cursos .col-th{
    font-weight: normal;
    text-align:center;
    vertical-align:top;
    font-size: 14px;
}
.table-resultados{
   padding-top: 3%;
    width: 75%;
    margin-left: 10%;
}
.col-resultados{
   font-size: 13px;
}
th{
    text-align: left;
}
.renglon-curso-nombre{
    padding-left: 2%;
    font-size:13px;
    padding-bottom: 2%;
}
.renglon-curso-duracion{
    padding-left: 2%;
    font-size:13px;
    text-align: center;
    padding-bottom: 2%;
}
.renglon-curso-periodo{
    font-size:13px;
    text-align: center;
    padding-bottom: 2%;
}
</style>

<body>
<div class="content" style="height: 90%">
	<div height="10%">
	<hr>
		<div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
		<div class=encabezado id=encabezado_2>
    <img class="img" id= img2 src="{{ public_path('img/escudo_fi_color.png') }}" width="75" height="85" align=left>
    <img class="img" id=img1 src="{{ public_path('img/CentroDocencia.png') }}" width="95" height="85" align=right>
      FACULTAD DE INGENIERÍA
    </div>
		<div id=encabezado_3>Secretaría de Apoyo a la Docencia</div>
		<div id=encabezado_4>CENTRO DE DOCENCIA</div>
		<div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
		<div class=encabezado id=encabezado_6>{{$profesor->getNombresMayus()}}</div>
	</div>
    <div>
    <table class="table-cursos">
    <colgroup>
      <col width="80%">
      <col width="14%">
      <col width="6%">
    </colgroup>
    <thead>
    <tr>
        <th width="80%" class="col-th-cursos">Cursos Acreditados</th>
        <th width="14%" class="col-th">Periodo</th>
        <th width="6%" class="col-th">Duración(h)</th>
    </tr>
    </thead>
    <tbody>
        @php
            $totalhoras = 0;
        @endphp
        @foreach($cursos as $curso)
            <tr style='padding-top: 10px;'>
                <td width="80%" class="renglon-curso-nombre">{{$curso->getNombreCursoSinClave()}}</td>
                <td width="14%" class="renglon-curso-periodo">{{$curso->getSemestre()}}</td>
                <td width="6%" class="renglon-curso-duracion">{{$curso->getDuracion()}}</td>
            </tr>
        @php
            $totalhoras = $totalhoras + intval($curso->getDuracion());
        @endphp
        @endforeach
    </tbody>
    <table>
    </div>
    <div>
    <table class="table-resultados">
        <tr>
            <td class="col-resultados">Cursos Acreditados:    <b>{{count($cursos)}}</b></td>
            <td class="col-resultados">Total de horas:    <b>{{$totalhoras}} h</b></td>
        </tr>    
    </table>
    </div>