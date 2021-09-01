@extends('layouts.principal')

@section('contenido')

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
        <h2>{{ $curso->getNombreCurso()}}</h2>
        <h3>Escoger tema del seminario</h3>              
      </div>
      <div class="panel-body">
        <table class="col-md-12">
          <tr>
            <th>Nombre del tema</th>
            <th>Instructor</th>
            <th></th>
          </tr>

          @foreach($temas as $tema)
          <tr>
            <td>{{ $tema['nombre'] }}</td>
            <td>{{ $tema['instructor'] }}</td>
            <td><a style="margin-bottom: 15px;" href="{{ URL::to('curso/modificar-instructor-tema',[$curso->id, $tema['id']]) }}" class="btn btn-success">Modificar</a></td>
          </tr>
          @endforeach
        </table>
      </form>
</div>
@endsection