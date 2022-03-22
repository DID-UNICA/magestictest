<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte Cursos</title>
</head>
<style>

html{
	width:100%;
}
body {
  font-family: Arial, Helvetica, Sans-serif;
}
.encabezado{
  text-align: center;
}
#encabezado_1{
  font-size: 20px;
  font-weight: bold;
}
#encabezado_2{
  font-size: 20px;
  font-weight: bold;
}
#encabezado_3{
  font-size: 20px;
  font-weight: bold;
  text-align: center;
}
#encabezado_4{
  font-size: 18px;
  font-weight: bold;
  text-align: center;
}
#encabezado_5{
  font-size: 18px;
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
  font-style: italic;
  padding-bottom: 8px;
}
.img{
  padding-top: 3%;
}
.table-cursos{
  width: 100%;
}
.table-cursos .col-th {
    font-weight:normal;
    text-align:center;
    vertical-align:bottom;
    font-size: 14px;
    font-family:'Tangerine', serif;
    
    
}

.col-td-cl{
  text-align: left;
  font-size:10px;
}

.col-td-nombre{
  text-align: left;
  font-size:13px;
}
.col-td-inst{
  text-align: left;
  font-size:12px;
}
.col-td-fif{
  text-align: left;
  font-size:12px;
}
.col-td-fechas{
  text-align: left;
  font-size:13px;
}
.col-td-horario{
  text-align: center;
  font-size:13px;
}
.col-td-duracion{
  text-align: center;
  font-size:13px;
}
.col-td-salon{
  text-align: left;
  font-size:13px;
}
.col-td-cupo{
  text-align: center;
  font-size:13px;
}
</style>

<body>
<div class="content">
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
		<div class=encabezado id=encabezado_6>{{$periodo}}</div>
	</div>
    <div>
    <table class="table-cursos" width=100%>
    <thead>
    <tr>
        <th width=5% class="col-th">Clave y leyenda de constancia</th>
        <th width=20% class="col-th">Nombre del curso</th>
        <th width=20% class="col-th">Instructor(es)</th>
        <th width=25% class="col-th" colspan="2">Fechas</th>
        <th width=5% class="col-th">Horario</th>
        <th width=5% class="col-th">Horas</th>
        <th width=10% class="col-th">Sede</th>
        <th width=10% class="col-th">Cupo máximo y mínimo</th>
    </tr>
    </thead>
    </table>
    <hr>
    <table class="table-cursos" width=100%>
    <tbody>
        @foreach($cursos as $curso)
        <tr>
            <td width=5% class="col-td-cl">{{$curso->getClave()}}</td>
            <td width=20% class="col-td-nombre" rowspan=2>{{$curso->getNombreCursoSinClave()}}</td>
            <td width=20% class="col-td-inst" rowspan=2>{{$curso->getProfesores()}}</td>
            <td width=10% class="col-td-fif">{{$curso->getFechaInicio()}}</td>
            <td width=15% class="col-td-fechas"rowspan=2>{{$curso->getFecha()}}</td>
            <td width=5% class="col-td-horario">{{$curso->getHoraInicio()}}</td>
            <td width=5% class="col-td-duracion" rowspan=2>{{$curso->getDuracion()}}</td>
            <td width=10% class="col-td-salon" rowspan=2>{{$curso->getSalon()}}</td>
            <td width=10% class="col-td-cupo"> {{$curso->getCupoMax()}}</td>
        </tr>
        <tr>
            <td width=5% class="col-td-cl">{{$curso->leyenda}}</td>
            <td width=10% class="col-td-fif">{{$curso->getFechaFin()}}</td>
            <td width=5% class="col-td-horario">{{$curso->getHoraFin()}}</td>
            <td width=10% class="col-td-cupo">{{$curso->getCupoMin()}}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
    </div>