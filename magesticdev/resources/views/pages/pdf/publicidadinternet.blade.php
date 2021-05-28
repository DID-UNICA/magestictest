<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Publicidad</title>
</head>
<style>

html{
	width:100%;
}

body {
  font-family: Calibri, Helvetica, Arial, serif;
  align-items: center;
  font-size: 18pt;
}
.header{
	z-index:-1;
	position: fixed;
	margin-top: -60px;
	font-size: 12pt;
	text-align:center;
  	font-weight: bold;
  	font-family:Calibri, Helvetica, Arial, serif;
}

@page :first {
	margin-top:30px;
}

@page {
	margin-top:95px;
}

table{
	table-layout: auto;
  width: 100%;
}
hr{
  border: 1px solid #000;
  border-spacing: 0;
}
#fondo{
  background-image: url("../public/img/Logo_CDD.jpeg");
  background-size: 90%;
  background-repeat: no-repeat;
  background-position: 50% 80%;


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
  line-height:160%;
  text-align: center;
  font-family: Calibri, Helvetica, Arial, serif;

}
#encabezado_1{
  font-size: 16pt;
  font-weight: bold;
  font-family: Calibri, Helvetica, Arial, serif;
}
#encabezado_2{
  font-size: 16pt;
  font-weight: bold;
  font-family: Calibri, Helvetica, Arial, serif;
}
#encabezado_3{
  font-size: 16pt;
  font-weight: bold;
  text-align: center;
  font-family: Calibri, Helvetica, Arial, serif;
}
#encabezado_4{
  font-size: 14pt;
  font-weight: bold;
  text-align: center;
  font-family: Calibri, Helvetica, Arial, serif;
}
#encabezado_5{
  font-size: 14pt;
  font-style: italic;
  font-family:Tangerine;
  text-align: center;
	line-height: 220%;
  font-weight: bold;
}
#encabezado_6{
  font-size: 14pt;
  font-weight: bold;
  font-family:Calibri, Helvetica, Arial, serif;
}

.rubros{
	vertical-align: top;
	padding-bottom: 8px;
  	font-size: 11pt;
  	font-weight: bold;
	font-style: italic;
  	text-align: left;
	width:20%;
}
#rubro-temario{
	vertical-align: top;
  font-size: 11pt;
  font-weight: bold;
	font-style: italic;
  text-align: left;
}
#rubro-Ant{
	vertical-align: top;
  font-size: 11pt;
  font-weight: bold;
	font-style: italic;
  text-align: left;
	padding-bottom: 8px;
	padding-top: 8px;
}
.contenidos{
	vertical-align: top;
	padding-bottom: 8px;
  font-size: 11pt;
  font-family: Calibri, Helvetica, Arial, serif;
  text-align: left;
  font-style: italic;
  string-set: header;
}
#contenidos-Ant{
	vertical-align: top;
	padding-bottom: 8px;
	padding-top: 1px;
  font-size: 11pt;
  font-style: italic;
	text-align: left;
}
.temario{
	vertical-align: top;
  font-size: 11pt;
  font-style: italic;
	text-align: left;
}
.profesores{
  font-family: Calibri, Helvetica, Arial, serif;
	font-size: 11pt;
  font-weight: bold;
	font-style: italic;
  text-align: left;
	
}
.comentarios{
  font-family: Calibri, Helvetica, Arial, serif;
  font-size: 12pt;
  font-style: italic;
  text-align: justify;
}

#tipolower{
	text-transform: lowercase;
}

</style>

<body>
<script type="text/php">
$GLOBALS["header"] = NULL;
</script>


<div class="header">
<script type="text/php">$GLOBALS["header"] = $pdf->open_object();</script>
{{$tipo}}: {{$cursoCatalogo->nombre_curso}}
<br>
<hr>
<script type="text/php">$pdf->close_object();</script>
</div>

<div id="content">

	<div id= fondo style="height: 90%">
		<div height="10%" style="background-color:white">
		<hr>
			<div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
			<img id= img2 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudos/escudounam_color.jpg" width="100" height="110" align=left>
			<img id=img1 src="http://www.ingenieria.unam.mx/nuestra_facultad/images/institucionales/escudo_fi_color.png" width="100" height="114" align=right>
			<div class=encabezado id=encabezado_2>FACULTAD DE INGENIERÍA</div>
			<div id=encabezado_3>SECRETARÍA DE APOYO A LA DOCENCIA</div>
			<div id=encabezado_4>CENTRO DE DOCENCIA</div>
			<div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
			<div class=encabezado id=encabezado_6>{{$tipo}}: {{$cursoCatalogo->nombre_curso}}</div>
			<hr>
		</div>

		<!--Ffont family mayoría como"Calibri"-->
		<!--Añadido "font-family: Calibri, Helvetica, Arial, serif;" A todos los encabezados a excepción del 5" -->
		<!-- Clase contenidos originalmente tenía font-style: Italic;-->
		<!--Clase comentarios modificado el font-size de 20px a 16px-->
		<!--Clase contenidos modificado el font-size de 27px a 16px-->
		<div id="cuerpo">
			<table>
				<tr>
					<td class=rubros>Modalidad:</td>
					<td class=contenidos>{{$tipo}}</td> <!--Originalmente con "id=tipolower"-->
				</tr>
				<tr>
					<td class=rubros>Dirigido a:</td>
					<td class=contenidos>{{$cursoCatalogo->dirigido}}</td>
				</tr>
				<tr>
					<td class=rubros>Instructor(es):</td>
					<td></td>
				</tr>
			</table>
			
			@foreach ($curso->getInstanciaProfesores() as $profesor)
			<p class=profesores> {{ $profesor->abreviatura_grado }} {{ $profesor->nombres }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</p>
			<p class=comentarios>{!! nl2br(str_replace(' ', '&nbsp;', $profesor->semblanza_corta)) !!}</p>
			@endforeach
			
			<table style="margin-top:10px">
				<tr>
					<td class=rubros>Objetivo:</td>
					<td class=contenidos>{{$cursoCatalogo->objetivo}}</td>
				</tr>
				<tr>
					<td id=rubro-temario>Contenido:</td>
					<td class=temario>{!! nl2br(str_replace(' ', '&nbsp;', $cursoCatalogo->contenido)) !!}</td>
				</tr>
				<tr>
					<td id=rubro-Ant>Antecedentes:</td>
					<td id=contenidos-Ant>{!! nl2br(str_replace(' ', '&nbsp;', $cursoCatalogo->antecedentes)) !!}</td>
				</tr>
				<tr>
					<td class=rubros>Duración: </td>
					<td class=contenidos>{{$cursoCatalogo->duracion_curso}} h</td>
				</tr>
			</table>
		</div>
	</div>
	<!--Sustituidos todos los px por pt en textos-->
<!-- <script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Helvetica", "bold");
            if ($PAGE_NUM != 1){
                $pdf->text(130, 20, "{{$tipo}}: {{$cursoCatalogo->nombre_curso}}", $font, 12);
								$pdf->text(120, 30, "___________________________________________", $font, 12);
            }
        ');
    }
</script> -->

<script type="text/php">
  $pdf->page_script('
    if ($PAGE_NUM >= 2) {
      $pdf->add_object($GLOBALS["header"],"add");
    }
  ');
</script>
</body>

</html>

