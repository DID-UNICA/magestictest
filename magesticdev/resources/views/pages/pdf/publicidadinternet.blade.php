<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Publicidad</title>
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
table{
	table-layout: auto;
  width: 100%;
}
hr{
  border: 1px solid #000;
  border-spacing: 0;
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
  line-height:160%;
  text-align: center;
}
#encabezado_1{
  font-size: 25px;
  font-weight: bold;
}
#encabezado_2{
  font-size: 22px;
  font-weight: bold;
}
#encabezado_3{
  font-size: 20px;
  font-weight: bold;
  text-align: center;
}
#encabezado_4{
  font-size: 20px;
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
}
#encabezado_6{
  font-size: 20px;
  font-weight: bold;
}

.rubros{
	vertical-align: top;
	padding-bottom: 8px;
  font-size: 17px;
  font-weight: bold;
	font-style: italic;
  text-align: left;
}
#rubro-temario{
	vertical-align: top;
  font-size: 17px;
  font-weight: bold;
	font-style: italic;
  text-align: left;
}
#rubro-Ant{
	vertical-align: top;
  font-size: 17px;
  font-weight: bold;
	font-style: italic;
  text-align: left;
	padding-bottom: 8px;
	padding-top: 8px;
}
.contenidos{
	vertical-align: top;
	padding-bottom: 8px;
  font-size: 17px;
  font-style: italic;
	text-align: left;
}
#contenidos-Ant{
	vertical-align: top;
	padding-bottom: 8px;
	padding-top: 8px;
  font-size: 17px;
  font-style: italic;
	text-align: left;
}
.temario{
	vertical-align: top;
  font-size: 17px;
  font-style: italic;
	text-align: left;
}
.profesores{
  font-family:'Tangerine', serif;
	font-size: 17px;
  font-weight: bold;
	font-style: italic;
  text-align: left;
	
}
.comentarios{
	font-family:'Tangerine', serif;
  font-size: 20px;
  font-style: italic;
  text-align: center;
}
</style>

<body>
<div style="height: 90%">
	<div height="10%">
	<hr>
		<div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
		<img id= img2 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudos/escudounam_color.jpg" width="100" height="110" align=left>
    <img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="100" height="114" align=right>
		<div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
		<div id=encabezado_3>SECRETARÍA DE APOYO A LA DOCENCIA</div>
		<div id=encabezado_4>CENTRO DE DOCENCIA</div>
		<div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
		<div class=encabezado id=encabezado_6>{{$curso->getTipoCadenaUpper()}}: {{$cursoCatalogo->nombre_curso}}</div>
		<hr>
	</div>
	<div id="cuerpo">
		<table>
			<tr>
				<td class=rubros>Modalidad:</td>
				<td class=contenidos>{{ $curso->getTipoCadena() }}</td>
			</tr>
			<tr>
				<td class=rubros>Dirigido a:</td>
				<td class=contenidos>{{$cursoCatalogo->dirigido}}</td>
			</tr>
			<tr>
				<td class=rubros>Instructor(es):</td>
				<td></td>
			</tr>
		</table>
		
		@foreach ($curso->getInstanciaProfesores() as $profesor)
    	<p class=profesores>{{ $profesor->nombres }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</p>
		<p class=comentarios>{{ $profesor->semblanza_corta }}</p>
		@endforeach
		
		<table>
			<tr>
				<td class=rubros>Objetivo:</td>
				<td class=contenidos>{{$cursoCatalogo->objetivo}}</td>
			</tr>
			<?php
				$contenidos=$curso->getContenido();
				$aux=0;
				print("
				<tr>
					<td id=rubro-temario>Contenido:</td>
					 <td class=temario>{$contenidos[0]}</td>
				</tr>");
				foreach($contenidos as $contenido){
					if ($aux == 0){
						$aux=1;
						continue;
					}
					print("
				<tr>
					<td></td>
					 <td class=temario>{$contenido}</td>
				</tr>");
				}
			?>
			<tr>
				<td id=rubro-Ant>Antecedentes:</td>
				<td id=contenidos-Ant>{{$cursoCatalogo->previo}}</td>
			</tr>
			<tr>
				<td class=rubros>Duración: </td>
				<td class=contenidos>{{$cursoCatalogo->duracion_curso}} h</td>
			</tr>
		</table>
	</div>
</body>
</html>