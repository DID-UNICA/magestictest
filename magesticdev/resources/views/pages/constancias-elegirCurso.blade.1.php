<!-- Guardado en resources/views/pages/admin.blade.php -->

@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<style>
    nav.navbar{
        background-color: #FAF8F8;
    }
</style>

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
      <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Bienvenido @usuario</h3>
                    <h4>Coordinación de Gestión y Vinculación</h4>
                </div>
                <div class="panel-body">

                <div class="logos col-md-12 col-center">
                	<img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                	Manejo y Gestión de información del centro de docencia.</h3>
                
                </div>
                <hr>
                <h2>Constancias <span class="fa fa-file-pdf-o"</span></h2>

                <table class="col-md-12">
                    <tr>
                        <th>Semestre</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha Final</th>
                        <th> </th>

                    </tr>
                    @foreach($cursos as $curso)
                        <tr>
                            <td>{{ $curso->semestre_imparticion }} </td>
                            <td>{{ $curso->fecha_inicio}}</td>
                            <td>{{ $curso->fecha_fin}}</td>
                            <td><a href="{{ URL::to('constancias/generar', $curso->id) }}" class="btn btn-info">Generar</a>
                        </tr>
                    @endforeach
                </table>
      </div>

     </section>
	 
@endsection