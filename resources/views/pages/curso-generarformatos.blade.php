 
@extends('layouts.principal')

@section('contenido')
<style>
.boton{
    padding-top: 10px;
}
</style>
        <!--Body content-->
<div class="content">
    <div class="top-bar">
        <a href="#menu" class="side-menu-link burger">
            <span class='burger_inside' id='bgrOne'></span>
            <span class='burger_inside' id='bgrTwo'></span>
            <span class='burger_inside' id='bgrThree'></span>
        </a>
    </div>
    <section class="content-inner">
        <br>
        @include ('partials.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Generar formatos {{$curso->getNombreCurso()}}</h3>
            </div>
            <div class="panel-body">

                <table class="col-md-6">
                    <tr>
                        <th>Formatos</th>
                    </tr>
                    <tr>
                        <td class=boton><a href="{{ route('formatos.generar',[$curso->id,'B1']) }}" class="btn btn-success">Verificación Datos con Lista Espera</a></td>
                        <td class=boton><a href="{{ route('formatos.generar',[$curso->id,'B']) }}" class="btn btn-success">Verificación Datos</a></td>
                        <td class=boton><a href="{{ route('curso.Wsearch',[$curso->id]) }}" class="btn btn-success">Correos personalizados</a></td>
                    </tr>    
                    <tr>
                        <td class=boton><a href="{{ route('formatos.generar',[$curso->id,'C']) }}" class="btn btn-success">Identificadores: Grandes</a></td>
                        <td class=boton><a href="{{ route('formatos.generar',[$curso->id,'C1']) }}" class="btn btn-success">Identificadores: Pequeños</a></td>
                    </tr>
                    <tr>
                        <td class=boton><a href="{{ route('formatos.generar',[$curso->id,'D']) }}" class="btn btn-success">Publicidad</a></td>
                        <td class=boton><a href="{{ route('constancias.elegirTipoConstancia', [$curso->id]) }}" class="btn btn-success">Constancias</a></td>
                    </tr>
                    <tr>
                        <td class=boton><a href="{{ route('formatos.generar',[$curso->id,'A']) }}" class="btn btn-success">Hoja de Asistencia</a></td>
                        <td class=boton><a href="{{ route('reco.elegir',[$curso->id]) }}" class="btn btn-success">Reconocimientos</a></td>
                    </tr>
                </table>
            </div>
    </section>
@endsection
