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
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Instructor</th>
              <th scope="col">Fecha de exposición</th>
              <th scope="col">Nombre del tema</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($instructores as $instructor)
            <form method="POST" action="{{ route('profesorts.update', $instructor->id) }}">
            {{ csrf_field() }}
              <tr>
                <td scope="row">{{ $instructor->getProfesor()->getNombres() }}</td>
                <td scope="row">
                  <input id="fecha" type="date" class="form-control" name="fecha" value={{$instructor->fecha_exposicion}}>
                </td>
                <td>
                  <select name="tema_seminario" class='form-control' required>
                    <option value="0">Sin tema.</option>
                    @foreach($temas as $tema)
                      @if($tema->id == $instructor->tema_seminario_id)
                        <option value="{{ $tema->id }}" selected> {{ $tema->nombre }}</option>
                      @else
                        <option value="{{ $tema->id }}"> {{ $tema->nombre }}</option>
                      @endif
                    @endforeach
                  </select>
                </td>
                <td>
                  <button type="submit" style="margin-bottom: 15px;" class="btn btn-info">Guardar</button>
                </td>
              </tr>
            </form>
            @endforeach
          </tbody>
        </table>
        </form>
      </div>
      @endsection
