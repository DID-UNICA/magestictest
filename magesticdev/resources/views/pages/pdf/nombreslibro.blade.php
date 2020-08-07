<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nombres Libro</title>
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
	border: 1.5px solid #000;
}
#mayusculas{
	text-transform: uppercase;
}
#h4 {
    margin:15px 60px 15px;
}

#renglonDoble, #mayusculas{
	 
}
.normal{
	border: 1px solid #000;
 
}
#encabezado{
	/*padding: 10px;*/
	font-size: 30px;
}
.small{
	font-size: 12px;
}
.espera{
	border-left:hidden;
	padding: 5px;
}
</style>
<body>
<div style="height: 90%">
	<div height="10%">
		<table style="width: 100%" align="top" id="encabezado" height="5%">
			<tr>
				<td  width="10%" >
					<img src="img/m.png"  align="center" height="100">
					
				</td>
				<td align="center">
					<b>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</b><br/>
			        <b>FACULTAD DE INGENIERÍA</b><br/>
			        CENTRO DE DOCENCIA<br>
			        <i>"Ing. Gilberto Borja Navarrete"</i><br/>
			        <br/>
			     </td> 
			    </tr>
		</table>   
			        
			 	<p align="center">Excel avanzado para docentes</p>
		<p class="small" align="right">Fecha </p>  
		<table>
			<tr>
				<td class="small" width="500">Nombre del participante para el libro
				</td>
				<td class="small">Horario del curso</td>
			</tr>
		</table>
	</div>
	<hr height>
	
		<?php 
        foreach($profesores as $profesor){  
	        print("
	        <table>
	        	<tr >
	        	<td>{$profesor->Nombre}</td>
	        	<td></td>
	    		</tr>
	        </table>
	        <hr>
	        ");	
			}
		
    ?>
		

</div>
<a href="{{ url('/nombres/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>