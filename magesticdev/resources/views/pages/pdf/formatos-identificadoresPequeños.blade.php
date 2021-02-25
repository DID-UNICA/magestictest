<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Identificadores</title>
</head>
<style>
html{
	width:100%;
	height: 100%;
}
.logo{
    width: 50px;
	position: absolute;
	margin-left: 2%;
}
.nombre{
	font-size: 30px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
}
.curso{
	font-size: 13px;
	text-align: center;
	font-family: 'Arial', 'Helvetica', sans-serif;
	font-weight: bold;
	vertical-align: top;
	margin-top: 2%;
}

.fecha{
	text-align: right;
	font-size: 12px;
	font-family: 'Arial', 'Helvetica', sans-serif;
	font-style: italic;
	font-weight: bold;
	margin-right: 15%;
	padding-bottom: 0.5cm;
}
td{
	height: 1cm;
}
.margenes{
	border-bottom: 1px solid black;
}
table{
	border-top: 1px solid black;
	border-left: 1px solid black;
	border-right: 1px solid black;
	width: 15cm;
}
</style>


<body>
	<div>
	<table class=margenes>
		<?php
			$iter = 1; 
	        foreach($participantes as $alumno){
				if($iter == 6){
					print("</table>");
					echo "<div style='page-break-after: always;'></div>";
					print("<table>");
					$iter = 1;
				}
					print("
					<tr width=100%>
					<td width=100%>
						<div>
							<img class=logo src='img/cdd.png'>
						</div>
						<div class=curso>
							{$cursoCatalogo->nombre_curso}
						</div>
						</td></tr>
						<tr><td>
						<div class=nombre>{$alumno->nombres}</div></td></tr>
						<tr><td class=margenes>
							<br>
						 <div class=fecha>{$fechaimp}</div> 
					</td></tr>
				");
	        	$iter++;
	    		}       	
			?>
			</table>
	</div>
</table>    
</body>
</html>
	        }
			?>
		</table>
	</div>
</table>    
</body>
</html>
