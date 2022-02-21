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
		margin-left: 10%;
		width: 85px; 
		height: auto;
}
#imagen_derecha{
		margin-left: 5.5%;
		width: 88px; 
		height: auto;
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

.header{
  margin-top: 50px;
}

.header2{
  @if((ceil((strlen($tipo)+strlen($cursoCatalogo->nombre_curso)+2)/65))>($curso->getNumProfesoresInst()))
  margin-top: -{{220+((ceil((strlen($tipo)+strlen($cursoCatalogo->nombre_curso)+2)/65)>4)?(11*(ceil((strlen($tipo)+strlen($cursoCatalogo->nombre_curso)+2)/65)-4)):0)}}px;
  @else
  margin-top: -{{220+(($curso->getNumProfesoresInst()>4)?(11*($curso->getNumProfesoresInst()-4)):0)}}px;
  @endif
	position: fixed;
}
.margen3{
  border: 1px solid black;
}

@page {
@if((ceil((strlen($tipo)+strlen($cursoCatalogo->nombre_curso)+2)/65))>($curso->getNumProfesoresInst()))
margin-top: {{250+((ceil((strlen($tipo)+strlen($cursoCatalogo->nombre_curso)+2)/65)>4)?(11*(ceil((strlen($tipo)+strlen($cursoCatalogo->nombre_curso)+2)/65)-4)):0)}}px;
@else
margin-top: {{250+(($curso->getNumProfesoresInst()>4)?(11*($curso->getNumProfesoresInst()-4)):0)}}px;
@endif
margin-bottom: 75px;
}

@page :first{
margin-top: 35px;
}

body{
  margin: 0px;
  margin-top: -50px;
}
</style>
<body>
  <script type="text/php">
      if ( isset($pdf) ) {
          $pdf->page_script('
              $font = $fontMetrics->get_font("Arial", "normal");
              if ($PAGE_NUM == 1){
                  $pdf->text(709, 102, "Página $PAGE_NUM de $PAGE_COUNT", $font, 8);
                  $pdf->text(720, 550, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
              }else{
                  $pdf->text(720, 550, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
              }
          ');
      }
  </script>

  <script type="text/php">
    $pdf->page_script('
      if ($PAGE_NUM >= 2) {
        $pdf->add_object($GLOBALS["header2"],"add");
      }
    ');
  </script>
  <script type="text/php">
    $GLOBALS["header2"] = NULL;
  </script>
  <div class="header2">
    <script type="text/php">$GLOBALS["header2"] = $pdf->open_object();</script>
    <table style="width: 100%"> <!--width = 85% originalmente-->
      <tr>
        <td class="titulos">Coordinación</td>
        <td class="valores">{{$coordinacion->nombre_coordinacion}}</td>
      </tr>
      <tr>
        <td class="titulos" width="10%" style="vertical-align: top;">Instructor</td>
        <td class="valores mayus" width="30%" height=56px style="vertical-align: top;">{!! nl2br($curso->getProfesoresInst()) !!}</td>
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
        <td class="valores">{{$salon->sede}}</td>
      </tr>
        <tr>
          <td class="titulos" width="40%">Horario</td>
          <td class="valores">De {{$curso->hora_inicio}} a {{$curso->hora_fin}} h</td>
        </tr>
    </table>
    <table style="width: 100%">
      <tr >
        <td class="titulos" width=6%> Número total de horas que abarca el curso</td>
        <td class="valores" align='left' width=2%>{{ $cursoCatalogo->duracion_curso }}</td>
        <td class="titulos" align='left' width=17%>Fechas de impartición</td>
      </tr>
    </table>

    <table id="tabla_lista" align="center" style="width: 100%">
      <tr align="center" class="margen">
        <th class="margen3" width="30%"><b>Nombre del participante</b></th>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <th class="margen3" width="6%"><b>Calificación</b></th>
      </tr>
    </table>
    <script type="text/php">$pdf->close_object();</script>
  </div>

	<div class="header">
		<table  id="tabla_encabezado">
				<td width= 9% class="margen">
          <img id="imagen_izquierda"  src="img/asistencia.jpeg">
				</td>
				<td width= 70% id="encabezado" class="margen">
          FACULTAD DE INGENIERÍA, UNAM<br/>
          Secretaría de Apoyo a la Docencia<br>
          Centro de Docencia "Ing. Gilberto Borja Navarrete"<br/>
          Sistema de Gestión de la Calidad<br/>
          Norma ISO 9001:2015<br/>
          Formato
				</td>
				<td width= 9% class="margen">
          <img id="imagen_derecha" src="img/cdd.png">
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
                  30/03/2017
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
      </tr>
			<tr>
				<td class="titulos" width="10%" style="vertical-align: top;">Instructor</td>
				<td class="valores mayus" width="30%" height=56px style="vertical-align: top;">{!! nl2br($curso->getProfesoresInst()) !!}</td>
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
        <td class="valores">{{$salon->sede}}</td>
      </tr>
      <tr>
        <td class="titulos" width="40%">Horario</td>
        <td class="valores">De {{$curso->hora_inicio}} a {{$curso->hora_fin}} h</td>
      </tr>
    </table>
    <table style="width: 100%">
      <tr>
        <td class="titulos" width=6%> Número total de horas que abarca el curso</td>
        <td class="valores" align='left' width=2%>{{ $cursoCatalogo->duracion_curso }}</td>
        <td class="titulos" align='left' width=17%>Fechas de impartición</td>
      </tr>
		</table>

    <table id="tabla_lista" align="center" style="width: 100%">
      <tr align="center" class="margen">
        <th class="margen3" width="30%"><b>Nombre del participante</b></th>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <td class="margen3" width="5%"><b></b></td>
        <th class="margen3" width="6%"><b>Calificación</b></th>
      </tr>
    </table>
  </div> <!--Cierra div del header-->	    


  <table id="tabla_lista" align="center" style="width: 100%">
  <?php
  $num_lista = 0;
      foreach($participantes as $alumno){  
          if($alumno->cancelacion == FALSE and $alumno->espera == 0){
          $num_lista += 1;
        print("
          <tr >
        <td class='margen2' style='font-size: 11px;'width=30%>{$num_lista}.     {$alumno->apellido_paterno} {$alumno->apellido_materno} {$alumno->nombres}</td>
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
        <td class='margen2' width='6%'><b></b></td>

        </tr>
        ");	//Corregido el font-size de 13 px a 11px
    
      }
      if($total == 22){
        if($num_lista==22){
          print("<div page-break-inside:always;></div></body></html> ");
        }
      }
    }
  ?>
  </table>
