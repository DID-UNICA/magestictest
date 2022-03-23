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
	margin-top: 0.1cm;
}
.nombre-pequenio{
	font-size: 79px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
}

.nombre-mediano{
	font-size: 64px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 0.4cm;
}
.nombre-mediano-2{
	font-size: 60px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 0.6cm;
	word-wrap:break-word;
}
.nombre-mediano-3{
	font-size: 57px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 0.6cm;
	word-wrap:break-word;
}

.nombre-largo{
	font-size: 32px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 1cm;
	word-wrap:break-word;
}
.nombre-largo-2{
	font-size: 46px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 1cm;
	word-wrap:break-word;
}
.nombre-largo-3{
	font-size: 46px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 1cm;
	word-wrap:break-word;
}
.nombre-largo-4{
	font-size: 45px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 1cm;
	word-wrap:break-word;
}
.nombre-largo-5{
	font-size: 40px;
	font-family:'Tangerine', serif;
	font-weight: bold;
	text-align: center;
	padding-top: 1cm;
	word-wrap:break-word;
}
.curso{
	font-size: 11px;
	text-align: center;
	font-family: 'Arial', 'Helvetica', sans-serif;
	font-weight: bold;
	vertical-align: top;
	padding-top: 0.2cm;
	width: 60%;
	margin-left: auto;
  margin-right: auto;

}

.fecha{
	width: 30%;
	padding-left:62%;
	text-align: right;
	font-size: 11px;
	font-family: 'Arial', 'Helvetica', sans-serif;
	font-style: italic;
	font-weight: bold;
}

.identi{
	border-top: 1px solid black;
	border-left: 1px solid black;
	border-right: 1px solid black;
	border-bottom: 0.5px solid black;
	width: 15.6cm;
	height: 4.9cm;
}
</style>
<body>
<div>
		@php
			$iter = 1;
		@endphp
		<table>
	  @foreach($participantes as $alumno)
				@if($iter === 5)
					</table>
					<div style='page-break-after: always;'></div>
					<table>
					@php
						$iter = 1;
					@endphp
				@endif
				@php
					$iter++;
				@endphp
				<table width=100% class=identi>
					<tr width=100%>
						<td width=100%>
							<div>
								<img class=logo src='img/cdd.png'>
							</div>
							<div class=curso>
								{{ $cursoCatalogo->nombre_curso }}
							</div>
						</td>
					</tr>
					<tr>
						<td>
						@if(strlen($alumno->nombres) <= 8)
							<div class=nombre-pequenio> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) <= 16)
							<div class=nombre-mediano> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) > 16 and strlen($alumno->nombres)<= 18)
							<div class=nombre-mediano-2> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) > 18 and strlen($alumno->nombres)<= 20)
							<div class=nombre-mediano-3> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) > 20 and strlen($alumno->nombres)<= 22)
							<div class=nombre-largo-2> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) > 22 and strlen($alumno->nombres)<= 24)
							<div class=nombre-largo-3> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) > 24 and strlen($alumno->nombres)<= 26)
							<div class=nombre-largo-4> {{ $alumno->nombres }} </div>
						@elseif(strlen($alumno->nombres) > 26 and strlen($alumno->nombres)<= 28)
							<div class=nombre-largo-5> {{ $alumno->nombres }} </div>
						@else
							<div class=nombre-largo> {{ $alumno->nombres }} </div>
						@endif
						</td>
					</tr>
					<tr>
						<td>
							<br>
						 <div class=fecha>{{ $fechaimp }}</div> 
						</td>
					</tr>
					</table>
			@endforeach
	</div>
</body>
</html>
