<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Reporte Comentarios</title>
  <link rel="stylesheet" href="css/font-calibri.css">
</head>
<style>

html{
	width:100%;
}
body {
  font-family:"Calibri, sans-serif";
  margin: 0 !important;
}
.encabezado{
  text-align: center;
  font-family: Helvetica, sans-serif;
}
.content-encabezado{
    padding-left:8%;
    padding-right:8%;
}
#encabezado_1{
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 0.5%;
  border-top: solid 3px black;
  padding-top: 3px;
  margin-top: 1.5%;
}
#encabezado_2{
  font-size: 21px;
  font-weight: bold;
  margin-bottom: 0.5%;
}
#encabezado_3{
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 0.5%;
}
#encabezado_4{
  font-size: 18px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 0.5%;
}
#encabezado_5{
  font-size: 19px;
  font-style: italic;
  font-family: serif, 'Tangerine';
  text-align: center;
  font-weight: bold;
  margin-bottom: 0.5%;
}
#encabezado_6{
  font-size: 18px;
  text-align: center;
  font-weight: bold;
}
#encabezado_7{
  font-size: 17px;
  font-weight: bold;
  text-align: center;
}
#encabezado_8{
  font-size: 15px;
  font-weight: bold;
}
.img{
  padding-top: 1%;
}

#img1{
  float: left;
}

#img2{
  float: right;
}

.table-titulos{
  width: 100%;
  border-bottom: 0.2px solid black;
}
.table-titulos .col-th {
    font-weight:bold;
    text-align:left;
    vertical-align:middle;
    font-size: 16px;
}
.coordinacion-nombre{
    font-style: italic;
    font-size: 18px;
    text-align: left;
    font-weight:bold;
}
.curso-nombre{
    font-size: 16px;
    text-align: left;
    font-weight:bold;
    padding-left: 3%;
}
.table-sugerencia{
  width: 100%;
  border-bottom: 0.2px solid black;
  padding-left: 4%;

}
.table-final{
  width: 100%;
  page-break-inside:avoid;
}
.col-td-instructor{
  text-align: left;
  font-size:15px;
}
.col-td-sugerencia{
  text-align: left;
  font-size:15px;
}
.col-td-proceso{
  text-align: left;
  font-size:15px;
}
@page :first{
	margin-top:8px;
}

@page {
	margin-top:120px;
	content:element(header);
}

#header{
	z-index:-1;
	position: fixed;
	margin-top: -84px;
	font-size: 12pt;
  font-weight: bold;
  font-family:'Calibri';
}

</style>

<body>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Calibri", "normal");
            $pdf->text(489, 750, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
</script>
<div id="header">
<div class=encabezado id=encabezado_8>{{$periodo}}</div>
  <table class="table-titulos" width=100%>
    <thead>
      <tr>
        <th width=40% class="col-th"></th>
        <th width=40% class="col-th">
        Sugerencia o recomendación</th>
        <th width=20% class="col-th">Proceso<br/>
        /Acuerdo o acción</th>
      </tr>
    </thead>
  </table>
</div>

<div>
	<div class="content-encabezado">
		<div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
    <div class=encabezado id=encabezado_2>
        <img class='img' id='img1' src="{{ public_path('img/escudo_fi_color.png') }}" width="75" height="85" >
        FACULTAD DE INGENIERÍA
        <img class='img' id='img2' src="{{ public_path('img/CentroDocencia.png') }}" width="95" height="85" >
    </div>
		<div class=encabezado id=encabezado_3>Secretaría de Apoyo a la Docencia</div>
		<div class=encabezado id=encabezado_4>CENTRO DE DOCENCIA</div>
		<div class=encabezado id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
    <div class=encabezado id=encabezado_6>Sugerencias o comentarios</div>
		<div id=encabezado_7>{{$periodo}}</div>
	</div> 
  <!--end content encabezado-->
  <div>
    <table class="table-titulos" width=100%>
        <thead>
            <tr>
                <th width=40% class="col-th"></th>
                <th width=40% class="col-th">Sugerencia o recomendación</th>
                <th width=20% class="col-th">Proceso<br/>
                /Acuerdo o acción</th>
            </tr>
        </thead>
    </table>
    @foreach($coordinaciones as $coordinacion)
      <div class=coordinacion>
        @if($coordinacion->cursos->isNotEmpty())
          <div class="coordinacion-nombre">{{$coordinacion->nombre_coordinacion}}</div>
          @foreach($coordinacion->cursos as $curso)
            @if($curso->sugerencias->isNotEmpty())
              <div class="curso-nombre">{{$curso->nombre_curso}}</div>
              @foreach($curso->sugerencias as $sugerencia)
                <table class="table-sugerencia">
                  <tbody>
                    <tr>
                      <td width=40% class="col-td-instructor">{{strtoupper($sugerencia->apellido_paterno.' '.$sugerencia->apellido_materno.' '.$sugerencia->nombres)}}</td>
                      <td width=40% class="col-td-sugerencia">{{$sugerencia->sug}}</td>
                      <td width=20% class="col-td-proceso"></td>
                    </tr>
                  </tbody>
                </table>
              @endforeach
            @endif
          @endforeach
        @endif
      </div>
    @endforeach
      <table class="table-final">
        <tbody>
          <tr>
            <td width=50%>P Procede</td>
            <td width=50%>C Comentar con los involucrados</td>
          </tr>
          <tr>
            <td width=50%>A Analizar</td>
            <td width=50%>NP No procede </td>
          </tr>
        </tbody>
      </table>
  </div>
</div>

