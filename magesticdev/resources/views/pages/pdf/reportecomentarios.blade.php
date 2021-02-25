<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte Comentarios</title>
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
.content-encabezado{
    padding-left:10%;
    padding-right:10%;
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
  font-size: 18px;
  text-align: center;
  font-weight: bold;
  padding-bottom: 2%;
}
#encabezado_7{
  font-size: 17px;
  font-weight: bold;
  font-style: italic;
  padding-bottom: 6px;
}
.img{
  padding-top: 3%;
}
.table-titulos{
  width: 100%;
}
.table-titulos .col-th {
    font-weight:bold;
    text-align:left;
    vertical-align:bottom;
    font-size: 14px;
}
.coordinacion{

}
.coordinacion-nombre{
    font-style: italic;
    font-size: 18px;
    text-align: left;
    font-weight:bold;
}
.curso-nombre{
    font-size: 16px;
    text-align: left;
    font-weight:bold;
    line-height: 13px;
    padding-left: 3%;
}
.table-sugerencia{
    width: 100%;
}
.col-td-instructor{
  text-align: left;
  font-size:15px;
}
.col-td-sugerencia{
  text-align: left;
  font-size:15px;
}
.col-td-proceso{
  text-align: left;
  font-size:15px;
}
</style>

<body>
<div class="content">
	<div class="content-encabezado" height="10%">
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
        <div id=encabezado_6>Sugerencias o comentarios</div>
		<div class=encabezado id=encabezado_7>{{$periodo}}</div>
	</div>
    <div>
        <table class="table-titulos" width=100%>
            <thead>
                <tr>
                    <th width=40% class="col-th"></th>
                    <th width=40% class="col-th">Sugerencia o recomendación</th>
                    <th width=20% class="col-th">Proceso/Acuerdo o acción</th>
                </tr>
            </thead>
        </table>
        <hr>
        @foreach($coordinaciones as $coordinacion)
        <div class=coordinacion>
            <p class="coordinacion-nombre">{{$coordinacion->nombre_coordinacion}}</p>
            @foreach($cursos as $curso)
            @if($curso->getCoordinacionId() == $coordinacion->id)
            <p class="curso-nombre">{{$curso->getNombreCurso()}}</p>
            @php
                $participantes = $curso->getParticipantes();
            @endphp
            @foreach($participantes as $participante)
            @if ($curso->getTipo() == 'S' and $participante->getSugerenciaFinalSeminario($curso->id) != 'NULL')
            <table class="table-sugerencia">
                <tbody>
                    <tr>
                        <td width=40% class="col-td-instructor">{{$participante->getNombresMayus()}}</td>
                          <td width=40% class="col-td-sugerencia">{{$participante->getSugerenciaFinalSeminario($curso->id)}}</td>
                        <td width=20% class="col-td-proceso"></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            @elseif ($curso->getTipo() != 'S' and $participante->getSugerenciaFinalCurso($curso->id) != 'NULL')
            <table class="table-sugerencia">
                <tbody>
                    <tr>
                        <td width=40% class="col-td-instructor">{{$participante->getNombresMayus()}}</td>
                        <td width=40% class="col-td-sugerencia">{{$participante->getSugerenciaFinalCurso($curso->id)}}</td>
                        <td width=20% class="col-td-proceso"></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            @endif
            @endforeach
            @endif
            @endforeach
        </div>
        @endforeach
    </div>
</div>