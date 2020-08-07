<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>P02</title>
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
    /*padding:15px 60px 15px;*/
 
   
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
#datosInformacion td{
	padding-right: 50px;
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
	<div>
		<table id="contenido" width="100%">
			<tr>
				<td width="50%" ><B><center><br><br>Cursos Acreditados</center></B></td>
				<td width="25%"><B><center><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></B></td>
				<td width="25%"><B><center><br><br>Duración</center></B></td>
				
			</tr>
			<br>
			<tr>
				<td width="50%" ><center><br>Formación en la práctica docente</center></td>
				<td width="25%"><center>2006-2009</center></B></td>
				<td width="25%"><B><center>20</center></B></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>Evaluación del aprendizaje escolar</center></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>Asertividad en el aula</center></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center>El algebra lineal en las ecuaciones diferenciales</center></B></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>El carácter lúdico en la enseñanza de las matemáticas</center></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>Acceso básico</center></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>Acceso básico</center></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>Introducción a los Sistemas de Gestión de Caidad</center></td>
				<td width="25%"><center>2006-2009</center></td>
				<td width="25%"><center>20</center></td>
				
			</tr>
			<tr>
				<td width="50%" ><center><br>Cursos Acreditados: 7</center></td>
				<td width="25%"><center>Total de horas</center></td>
				<td width="25%"><center>115</center></td>
				
			</tr>
		</table>
		<br>
		<p align="center">Se extiende la presente relación de cursos a petición de la interesada y para los fines que a ella convengan</p>
	</div>
<a href="{{ url('/publicidad/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>