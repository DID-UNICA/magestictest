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
		<hr/ >
		<hr>
		<div align="center" class="encabezado">
			UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO
		</div>
		
		<table style="width: 100%" align="center" id="encabezado" height="5%">
			<tr id="normal">
				<td  width="10%" id="normal">
				<img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="160" height="184" align=right>
				</td>
				<td  align="center" class="encabezado">
					
			        FACULTAD DE INGENIERÍA<br/>
			        Secretaría de Apoyo a la Docencia<br/>
			        CENTRO DE DOCENCIA <br/>
			        <i>"Ing. Gilberto Borja Navarrete"</i><br/>
				</td>
				<td align="center" width="15%" id="normal">
				<img id= img2 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudos/escudounam_color.jpg" width="170" height="190" align=left>
				</td> 
			</tr>
		</table>
		<hr>
		<p align="center"><b>Encuestas del curso</b></p>
		<p align="center"><b>Excel avanzado para docentes</b>
		</p>
		<p class="small" align="center">Semestre</p>
		<hr/ >
	</div>
	<div id="cuerpo">
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
				
			</tr>
			
			
		</table>


		

		<table id="contenido">
			<tr>
				<td>Objetivo:</td>
				<td>Que los asistentes utilicen las herramientas avanzadas del Excel para un mejor aprovechamiento de sus labores acad'emicas.</td>
			</tr>
			<tr>
				<td>Contenido:</td>
			 	<td>-Bases de datos(filtros, filtros avanzados, ordenamisntos, subtotales)<br>
					-Tablas dinámicas<br>
					-Funciones y Fórmulas avanzadas (Sí, busca rv, funciones lógicas, matriciales)<br>
					-Consolidar<br>
					-Escenarios<br>
					-Introducción a Macros<br>
				</td>
			</tr>
			<tr>
				<td>Antecedentes:</td>
				<td>Conocimientos de Excel básico</td>
			</tr>
			<tr>
				<td>Duración</td>
				<td>20 h</td>
			</tr>
		</table>
	</div>
<a href="{{ url('/publicidad/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>