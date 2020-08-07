<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pagos</title>
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
	margin: 2px;
}
.separado{
	margin-top: 4px;
	margin-left:25px; 
	margin-right:25px; 
	border: 1.2px solid #000;
}

#espacio{
	margin-left:25px; 
	margin-right:25px;
}
#mayusculas{
	text-transform: uppercase;
}
#h4 {
    margin:15px 60px 15px;
}

.normal{
	font-size: 12px;
	font-weight: lighter;

}
#encabezado{
	/*padding: 10px;*/
	font-size: 30px;
}
.small{
	font-size: 14px;
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
    	<hr >
    	<hr >
    	</div>
		<p align="left"><i><b>Semestre</i></p>
		<p class="small" align="left"><b>Coordinación<b/></p>
		<hr class="separado">
		<hr class="separado">  
		<table width="100%" style="margin-left: 27px" >
			<tr>
				<td class="small" width="25%">Participante</td>
				<td class="small" width="40%">Nombre del Curso</td>
				<td class="small" width="15%">Fecha</td>
				<td class="small" width="10%">Duración</td>
				<td class="small" width="10%">Monto</td>
			</tr>
		</table>
		<hr class="separado">
		<hr class="separado">
		<div style="height: 70px"></div>
		<hr id="espacio">
		<table width="100%" style="margin-left: 27px">
			<tr>
				<td class="normal" width="70%">Total de la Coordinación (0 pagos)</td>
				<td class="normal" width="15%"><b>Suma</b></td>
				<td class="normal" width="15%">$0.00</td>
			</tr>
		</table>
		<div style="height: 15px"></div>
		<table width="100%" style="margin-left: 5px">
			<tr>
				<td class="normal" width="73%">Total del Semestre (0 pagos)</td>
				<td class="normal" width="15%"><b>Suma</b></td>
				<td class="normal" width="15%">$0.00</td>
			</tr>
		</table>
		<div style="height: 30px"></div>
		<table width="100%">
			<tr>
				<td class="normal" width="79%" align="right"><b>Suma total</b></td>
				<td class="normal" width="25%" align="center" style="padding-left: 30px"><b>$0.00</b></td>
			</tr>
		</table>
</div>
</body>
</html>