<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hoja de Asistencia</title>
</head>
<style>
    html{
	    width:100%;
    }
    .margen{
        border: 1px solid #ddd;
    }
    .margen2{
        border: 1px solid black;
    }
    #tabla_encabezado{
        border-collapse: collapse;
        border: 1px solid #ddd;
        height: 50px;
        width:100%;
    }
    #tabla_encabezado_debajo{
        border-collapse: collapse;
        border: 1px solid #ddd;
        height: 5%;
        width:100%;
        text-align:center;
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        font-size: 9px;
    }
    #tabla_lista{
        border-collapse: collapse;
        
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        font-size: 11px;
        page-break-inside:auto;
    }
    #encabezado{
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        text-align: center;
        font-size: 12px;
        line-height:130%;
    }
    #imagen_izquierda{
        margin-left: 15%;
    }
    #imagen_derecha{
        margin-left: 14%;
    }
    .titulos{
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        font-size: 11px;
        font-weight: bold;
    }
    .valores{
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        font-size: 11px;
    }
    .tipo{
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        font-size: 14px;
        font-weight: bold;
    }

    .tipo2{
        font-family:Arial, Helvetica, Sans-serif,cursive; 
        font-size: 14px;
        font-weight: bold;
        padding-left: 3.5cm;
    }

   .mayus{
        text-transform: uppercase;
    }


#header{
	z-index:-1;
    margin-top: -310px;
	position: fixed;
}


@page {
	margin-top:340px;
    margin-bottom:80px;

}

</style>
<body>

	<div id="header">
		<table  id="tabla_encabezado">
				<td width= 9% class="margen">
                    <img id="imagen_izquierda"  src="img/asistencia2.png">
				</td>
				<td width= 70% id="encabezado" class="margen">
			        FACULTAD DE INGENIERÍA, UNAM<br/>
			        Secretaría de Apoyo a la Docencia<br>
			        Centro de Docencia "Ing. Gilberto Borja Navarrete"<br/>
			        Sistema de Gestión de la Calidad<br/>
			        Norma ISO 9001-2015<br/>
			        Formato
				</td>
				<td width= 9% class="margen">
          <img id="imagen_derecha" src="img/asistencia1.png">
				</td>
		</table>
        <table id="tabla_encabezado_debajo">
				<td width="20%" class="margen">
					2730-SGC-IC-FO-03
				</td>
				<td  class="margen">
					Fecha de emisión
				</td>
				<td class="margen">
                    2017-03-30
				</td>
				<td class="margen">
					Versión
				</td>
				<td class="margen">
					1
				</td>
				<td width="20%" class="margen">
					
				</td>
		</table>
        <table style="width: 100%"> <!--width = 85% originalmente-->
            <tr>
                <td class="titulos">Coordinación</td>
                <td class="valores">{{$coordinacion->nombre_coordinacion}}</td>
            </td>
			<tr >
				<td class="titulos" width="10%" style="vertical-align: top;">Instructor</td>
				<td class="valores mayus" width="30%" height=55px style="vertical-align: top;">{{ $curso->getProfesores() }}</td>
				@if ($tipo == 'Módulo Diplomado')
        <td width=10% class="tipo mayus"></td> <!-- class="tipo mayus" width al 12% originalmente-->
        @else
        <td width=10% class="tipo mayus" style="vertical-align: top;">{{ $tipo }}</td> <!-- class="tipo mayus" width al 12% originalmente-->
        @endif
                <td width=28% class="tipo" style="vertical-align: top;">{{ $cursoCatalogo->nombre_curso}}</td> <!-- Corregir el Espacio ;width al 36% originalmente -->
			</tr>
		</table> 
		
        <table>
        <tr>
            <td class="titulos">Fechas</td>
            <td class="valores">{{$fechaimp}}</td>
        </tr>
		<tr>
		    <td class="titulos">Sede</td>
		    <td class="valores">{{$salon->sede}} - {{$salon->ubicacion}}</td>
		</tr>
        <tr>
            <td class="titulos" width="40%">Horario</td>
            <td class="valores">De {{$curso->hora_inicio}} a {{$curso->hora_fin}} h</td>
        </tr>
        </table>
		<table style="width: 85%">
			<tr >
                <td class="titulos" width=13%> Número total de horas que abarca el curso</td>
                <td class="valores" width=20%>{{ $curso->numero_sesiones }}</td>
				<td class="titulos" width=17%>Fechas de impartición</td>
			</tr>
		</table>
        
<table id="tabla_lista" align="center" style="width: 100%">
	<tr align="center" class="margen">
		<th class="margen2" width="25%"><b>Nombre del participante</b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
		<td class="margen2" width="5%"><b></b></td>
        <td class="margen2" width="5%"><b></b></td>
		<th class="margen2" width="10%"><b>Calificacion</b></td>
	</tr>
    </table>
    </div> <!--Cierra div del header-->	

    <table id="tabla_lista" align="center" style="width: 100%">
    <?php 
    $num_lista = 0;
        foreach($participantes as $alumno){  
            if($alumno->cancelación == FALSE and $alumno->espera == 0){
            $num_lista += 1;
	        print("
	        	<tr >
		        	<td class='margen2' style='font-size: 11px;'width=25%>{$num_lista}.     {$alumno->apellido_paterno} {$alumno->apellido_materno} {$alumno->nombres}</td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='5%'><b></b></td>
                    <td class='margen2' width='5%'><b></b></td>
                    <td class='margen2' width='5%'><b></b></td>
					<td class='margen2' width='10%'><b></b></td>

	    		</tr>
	        ");	//Corregido el font-size de 13 px a 11px
			}}
		
    ?>
    </table>  
    


<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial", "normal");
            $pdf->text(709, 100, "Página $PAGE_NUM de $PAGE_COUNT", $font, 8);
            $pdf->text(720, 550, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
</script>
