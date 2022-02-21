<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Verficacion</title>
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
  font-size: 23px;
}

.line-header{
	border: 1.4px solid #000;
}
.line-renglon{
	border: 0.01px solid #000;
}
#mayusculas{
	text-transform: uppercase;
}
.datosTabla{
	margin: 30px 10px 10px; 
 
}
.encabezado_1{
	font-size: 25px;
    font-weight: bold;
    text-align: center;
}
#encabezado_2{
	font-size: 22px;
    font-weight: bold;
    text-align: center;
}
#encabezado_3{
	font-size: 21px;
    font-style: italic;
    font-family:'Tangerine', serif;
    font-weight: bold;
    text-align: center;
}

#encabezado_4{
	font-size: 18px;
    font-weight: bold;
    text-align: center;
}
#logo{
    float: left;
}
.small{
	font-size: 10px;
}
.datos{
	font-size: 15px;
}

.seccion{
	font-size: 11px;
	font-weight: bold;
}

.cuadrado{
	width: 2%; 
    height: 25px; 
    border: 3px solid #555;
}
</style>
<body>
<div style="height: 90%">
	<div height="10%">
		<img id="logo" src="http://www.centrodedocencia.unam.mx/images/logos/logo_cdd_2.png"  height="55">
					<div style="line-height: 150%;">
                    <div class="encabezado_1">UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
			        <div class="encabezado_1">FACULTAD DE INGENIERÍA</div>
			        <div id="encabezado_2">CENTRO DE DOCENCIA</div>
			        <div id="encabezado_3">"Ing. Gilberto Borja Navarrete"</div>
                    <div id="encabezado_4"><br>{{ $cursoCatalogo->nombre_curso }}</div>
                    </div>
			<table class="datosTabla" width="100%">
			<tr>
				<td class="small" width="75%"> Nombre del participante
				</td>
				<td class="small" width="15%"> {{ $fechaimp}} </td>
			</tr>
		</table>
	</div>
		<hr class=line-header>
	    <div class=seccion>Inscritos</div>
		<?php 
        foreach($participantes as $alumno){  
			if($alumno->cancelacion == FALSE and $alumno->espera == 0){
	        print("
	        <table width=100%>
	        	<tr>
	        	<td class=datos width=45%>{$alumno->nombres} {$alumno->apellido_paterno} {$alumno->apellido_materno}</td>
	        	<td class=datos width=30%>{$alumno->email}</td>
	        	<td class=datos width=20%>{$alumno->telefono}</td>
	    		</tr>
			</table>
			<hr class=line-renglon>
	        ");	
			}}
		?>
		<div class=seccion>Lista de Espera</div>
		<?php 
        foreach($participantes as $alumno){  
			if($alumno->cancelacion == FALSE and $alumno->espera >= 1){
	        print("
	        <table width=100%>
	        	<tr>
	        	<td class=datos width=45%>{$alumno->nombres} {$alumno->apellido_paterno} {$alumno->apellido_materno}</td>
	        	<td class=datos width=30%>{$alumno->email}</td>
	        	<td class=datos width=20%>{$alumno->telefono}</td>
	    		</tr>
			</table>
			<hr class=line-renglon>
	        ");	
			}}
		?>	
</div>
</body>
</html>