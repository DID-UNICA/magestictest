<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Correos Personalizados</title>
</head>
<style>

html{
	width:100%;
}
body {
  font-family: Arial, Helvetica, Sans-serif;
}
.line{
    border: 1px solid black;
}
.encabezado{
  text-align: center;
}
.content{
    padding-left:5%;
    padding-right:5%;
}
#encabezado_1{
  font-size: 20px;
  font-weight: bold;
}
#encabezado_2{
  font-size: 20px;
  font-weight: bold;
}
#encabezado_3{
  font-size: 20px;
  font-weight: bold;
  text-align: center;
}
#encabezado_4{
  font-size: 18px;
  font-weight: bold;
  text-align: center;
}
#encabezado_5{
  font-size: 18px;
  font-style: italic;
  font-family:'Tangerine', serif;
  text-align: center;
  font-weight: bold;
}
#encabezado_6{
  font-size: 18px;
  text-align: center;
  font-weight: bold;
  padding-bottom: 1%;
}
#encabezado_7{
  font-size: 14px;
  font-weight: bold;
  font-style: italic;
  padding-bottom: 6px;
  text-align: center;
}
.img{
  padding-top: 3%;
}
.table-titulos{
  width: 100%;
}
#title-part{
  font-size: 14px;
  font-weight: bold;
  font-family:'Tangerine', serif;
}
.table-titulos .col-th{
  font-size: 12px;
  font-weight: normal;
  font-family:'Tangerine', serif;
  text-align: center;
}
.message{
  font-size: 12px;
  font-weight: normal;
  font-family:'Tangerine', serif;
  padding-left: 5%;
  padding-right: 5%;
}
.message-content{
    text-align: left;
}
.message-references{
    text-align: center;
}
</style>

<body>
<div class="content">
	<div class="content-encabezado" height="10%">
	    <hr class="line">
		<div class=encabezado id=encabezado_1>UNIVERSIDAD NACIONAL AUTÓNOMA DE MÉXICO</div>
		<div class=encabezado id=encabezado_2>
            <img class="img" id= img2 src="{{ public_path('img/escudo_fi_color.png') }}" width="75" height="85" align=left>
            <img class="img" id=img1 src="{{ public_path('img/CentroDocencia.png') }}" width="95" height="85" align=right>
            FACULTAD DE INGENIERÍA
        </div>
		<div id=encabezado_3>Secretaría de Apoyo a la Docencia</div>
		<div id=encabezado_4>CENTRO DE DOCENCIA</div>
		<div id=encabezado_5>"Ing. Gilberto Borja Navarrete"</div>
        <div id=encabezado_6>Reporte de Cursos solicitados</div>
		<div id=encabezado_7>{{$curso->getNombreCursoSinClave()}}</div>
        <hr class="line">
        <div id=title-part>Participante</div>
        <hr class="line">
	</div>
    @foreach($interesados as $interesado)
        @php
            $profesor = $interesado->getProfesor();
            $cursoMatch = $interesado->getCurso();
            $catalogoMatch = $interesado->getCatalogoCurso();
        @endphp
    <div>
        <table class="table-titulos" width=100%>
            <thead>
                <tr>
                    <th width=40% class="col-th">{{$profesor->getNombresMayus()}}</th>
                    <th width=40% class="col-th">{{$profesor->email}}</th>
                    <th width=20% class="col-th">{{$profesor->telefono}}</th>
                </tr>
            </thead>
        </table>
        <div class="message">
            <p class="message-content">Estimado profesor {{$profesor->getNombreSinApellidos()}}, hemos detectado que en el semestre {{$cursoMatch->getSemestre()}} ud. tomó el curso</p>
            <p class="message-references">{{$catalogoMatch->nombre_curso}}</p>
            <p class="message-content">en el cual solicitó la impartición de {{$curso->getNombreCursoSinClave()}}, y nos complace informarle que en este periodo el CDD ha abierto un curso que responde a esa temática.</p>
            <p class="message-content">Esperando que el curso que hemos desarrollado sea de su interés, nos despedimos de Ud. enviándole un cordial saludo.</p>
        </div>
        <hr class="line">
    </div>
    @endforeach
</div>