<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte para instructores</title>
</head>
<style>
    div.container {
        text-align:center;
    }
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
#mayusculas{
	text-transform: uppercase;
}
#contenido{
    padding:15px 60px 15px;
 
   
}
#renglonDoble, #mayusculas{
	 border: 1px solid white;
}
#normal{
	
   border-spacing: 0;
}
.encabezado{
	font-size: 25px;
}
.small{
	font-size: 12px;
}
.tabla{
	font-size: 12px;
	text-align: center;
	padding: 0px 2px;
	color: #3C3ABD;
	height: 100px;
}
</style>
<body>
<div style="height: 90%">
	<div height="10%">
		<div align="center" class="encabezado">
			UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO
		</div>
		
		<table style="width: 100%" align="center" id="encabezado" height="5%">
			<tr id="normal">
				<td  width="10%" id="normal">
					<img src="img/escudo_fi_color.png" alt="" align="right" height="120">
				</td>
				<td  align="center" class="encabezado">
					
			        FACULTAD DE INGENIERÍA<br/>
			        Secretaría de Apoyo a la Docencia<br/>
			        CENTRO DE DOCENCIA <br/>
			        <i>"Ing. Gilberto Borja Navarrete"</i><br/>
				</td>
				<td align="center" width="15%" id="normal">
					<img src="img/magestic.jpg" alt="" align="right" height="120">
				</td> 
			</tr>
		</table>
		<p align="center"><b>MARTINEZ ALAVEZ JACQUELYN</b>
		</p>

	</div>
	<div id="cuerpo">
		<!--
		<table align="right" width="100%">
			<tr>
				<td class="tabla" width="60%"></td>
				<td class="tabla" width="5%">Experiencia</td>
				<td class="tabla" width="5%">Planeación <br>y Organización</td>
				<td class="tabla" width="5%">Puntualidad</td>
				<td class="tabla" width="5%">Materiales de<br> apoyo</td>
				<td class="tabla" width="5%">Resolución de<br> dudas</td>
				<td class="tabla" width="5%">Control de grupo</td>
				<td class="tabla" width="5%">Interés que despertó</td>
				<td class="tabla" width="5%">Actitud del instructor</td>
			</tr>
			<tr>
				<?php
					
				?>
			</tr>
			
			
		</table>
	-->


		

		<table id="contenido">
			<tr>
				<td width="50%"><B><center>Cursos Acreditados</center></B></td>
				<td width="50%"><B><center>Duración</center></B></td>
			</tr>
			<tr>
				<td width="50%"><center>Formación en la práctica docente<br>19 al 23 de junio de 2006</center></td>
			 	<td width="50%"><center>Año XXXX-año XXXX</center><br>
				</td>
			</tr>
			<tr>
				<td width="50%"><center>Evaluación del aprendizaje escolar<br>25 al 29 de enero de 2010</center></td>
			 	<td width="50%"><br>
			 		<center>Año XXXX-año XXXX XX</center>
			 		Introducir al participante en el conocimiento del proceso de la evaluación del aprendizaje escolar e instrumentar una estrategia de evaluación para la primera unidad del programa de la asignatura
			 	<br>
				</td>
			</tr>
			<tr>
				<td width="50%"><center>Asertividad en el aula<br>28 al 2 de julio de 2010</center></td>
			 	<td width="50%"><br>
			 		<center>Año XXXX-año XXXX       XX</center>
			 		El docente identificará y analizará los conceptos básicos de la asertividad y la comunicación para mejorar las condiciones socio-afectivas en el aula.
			 	<br>
				</td>
			</tr>
		</table>
	</div>
<a href="{{ url('/publicidad/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>