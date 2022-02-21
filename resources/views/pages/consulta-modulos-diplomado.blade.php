<!-- Guardado en resources/views/pages/admin.blade.php -->

@extends('layouts.principal')

@section('contenido')

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
          <div class="container">
            <h3>Módulos del diplomado</h3>
            <h4>{{$diplomado->nombre_diplomado}}</h4>
          </div>
        </div>
      </div>
      <div class="panel-body tablaFija">
      <table class="col-md-12" style="width:100%">
        <tr>
            <th style="width:30%">Nombre</th>
            <th style="width:30%"># de Módulo</th>
            <th style="width:30%">Instructor</th>
            <th style="width:15%">Periodo</th>
            <th style="width:25%"></th>
        </tr>
      @foreach($cursos as $curso)
        <tr>
          <td>{{ $curso->getNombreCurso() }}</td>
          <td>{{ $curso->num_modulo }} </td>
          <td>{{ $curso->getProfesores() }}</td>
          <td>{{ $curso->getSemestre() }}</td>
          <td class="boton">
              <a href="{{ URL::to('curso/generar-formatos',$curso->id) }}" class="btn btn-primary" style="margin-bottom: 15px;">Generar formatos</a>
              <a href="{{ URL::to('curso/ver-profesores',$curso->id) }}" class="btn btn-warning" style="margin-bottom: 15px;">Ver Módulo</a>
              <a href="{{ URL::to('curso/inscripcion',$curso->id)}}" class="btn btn-success" style="margin-bottom: 15px;">Inscribir</a>
              <a href="{{ URL::to('curso/instructores', $curso->id) }}" class="btn btn-primary" style="margin-bottom: 15px;">Instructores</a>
              <a href="{{ route('modulo.ver', $curso->id) }}" class="btn btn-info" style="margin-bottom: 15px;">Detalles</a>
          </td>
        </tr>
      @endforeach

    </table>
  </div>
</section>
@endsection
  

  
