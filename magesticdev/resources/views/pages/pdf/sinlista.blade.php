<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sin Lista de espera</title>
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
  font-size: 15px;
}
#mayusculas{
	text-transform: uppercase;
}
#h4 {
    margin:15px 60px 15px;
 
   
}
#renglonDoble, #mayusculas{
	 border: 1px solid white;
}
#normal, td,#encabezado{
	
  border: 1px solid #000;
  border-spacing: 0;
}
#encabezado{
	/*padding: 10px;*/
}
.small{
	width: 20%;
}
</style>
<body>
<div style="height: 90%">
	<div height="10%">
		<table style="width: 100%" align="center" id="encabezado" height="5%">
			<tr id="normal">
				<td rowspan="2" width="10%" id="normal">
					<img src="img/m.png" alt="" align="right" height="100">
				</td>
				<td rowspan="2" align="center" id="normal">
			        FACULTAD DE INGENIERÍA<br/>
			        CENTRO DE DOCENCIA 
			        "Ing. Gilberto Borja Navarrete"<br/>
			        HOJA DE INSCRIPCIÓN A CURSOS<br/>
			        Código: 2730-CDD-IC.Fo-06
				</td>
				<td align="center" width="15%" id="normal">Ver: 6.0</td> 
			</tr>
			<tr id="normal">
				<td align="center" width="15%" id="normal">Emision de formato<br/>
					21/2/2018
				</td>
			</tr>
		</table>
	</div>
	
<div width="80%" id="h4">
	
	Coordinación &nbsp;&nbsp;&nbsp;&nbsp; 
	<u>Bases de datos</u><br/>
	<table id="renglonDoble" style="width: 85%">
		<tr >
			<td id="renglonDoble" width="10%">Instructor</td>
			<td id="mayusculas" width="30%">bases de datos</td>
			<td id="renglonDoble">CURSO&nbsp;&nbsp;&nbsp;&nbsp; <u>Bases de datos</u></td>
		</tr>
	</table> 
	<!--bases de datos-->
	<br>
	Fechas 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u>Bases de datos</u><br>
	Sede&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
	<u>Bases de datos</u>
	<br>
	<table id="renglonDoble" style="width: 85%">
		<tr >
			<td id="renglonDoble" width="40%">Horario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u>Bases de datos</u></td>
			<td id="renglonDoble">Fechas de impartición</td>
		</tr>
	</table>
	
	Número total de horas que abarca el curso<br>
	
</div>
<table align="center" style="width: 100%" id="normal">
	<tr align="center" id="normal">
		<td id="normal" width="25%"><b>Nombre del participante</b></td>
		<?php
		for ($i = 1; $i <= 10; $i++) {
    	print("
			<td ></td>
		");
		}
	?>
		<td></td>
		<td>Calificación</td>
	</tr>
	<?php 
        $i=0;
        foreach($alumnos as $alumno){
	        $i=$i+1;  
	        print("<tr>
	        <td>{$alumno->id}.  {$alumno->Nombre}</td>
	        ");
	        for ($i = 1; $i <= 10; $i++) {
		    	print("
					<td ></td>
				");
			}
			print("<td width=20%></td>
		<td width=20%>Calificación</td></tr>");
        }    
    ?>
	
</table>
</div>
<a href="{{ url('/sinlista/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>