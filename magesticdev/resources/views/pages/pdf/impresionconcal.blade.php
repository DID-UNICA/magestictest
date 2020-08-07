<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>P04</title>
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
				<td width="50%" ><B><br><br>Cursos Acreditados</B></td>
				<td colspan="2"><B><br><br>Duración</B></td>
				<td colspan="2"><B><br><br>Calificación/Causa</B></td>
				
			</tr>
			<br>
			<tr>
				<td ><br>Formación en la práctica docente</td>
				<td >2006-2009</B></td>
				<td ><B>20</B></td>
				<td colspan="2"><B>9</B></td>
			</tr>
			<tr>
				<td><br>Cursos Acreditados: 7</td>
				<td>Total de horas</td>
				<td>115</td>
				<!--<td colspan="2"><B></B></td>-->
				
			</tr>
		</table>
		<table id="contenido" width="100%">
			<tr>
				<td width="50%" ><B><br><br>Cursos NO Acreditados</B></td>
				<td colspan="2"><B><br><br>Duración</B></td>
				<td colspan="2"><B><br><br>Calificación/Causa</B></td>
				
			</tr>
			<br>
			<tr>
				<td><br>Formación en la práctica docente</td>
				<td>2006-2009</B></td>
				<td colspan="2"><B>20</B></td>
				<td><B><center>Canceló</B></td>
			</tr>
			<tr>
				<td><center><br>Cursos NO Acreditados: 3</center></td>
				<td>Total de horas</td>
				<td>58</td>
				
			</tr>
		</table>
		<br>
		<p align="center">Se extiende la presente relación de cursos a petición de la interesada y para los fines que a ella convengan</p>
	</div>
<a href="{{ url('/publicidad/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>