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

              <h3>Lista de Usuarios

              <a href="{{ URL::to('usuario/crear') }}" style="margin: 10px;" class="btn btn-success">Nuevo Usuario</a>

              </h3>
              <div class="input-group">
              {{ csrf_field() }}
              <table class="col-md-12" style='margin: 1%'>
                  <tr>
                      <th>Nombre</th>
                      <th>Usuario</th>
                      <th></th>
                      <th></th>
                  </tr>
                  @foreach($users as $user)
                    {!! Form::open(["route" => ["usuario.editar",$user->id], "method" => "GET"]) !!}
                      <tr style='margin: 1%'>
                          <td style='padding: 2%'>{{ $user->nombre }}</td>
                          <td style='padding: 2%'>{{ $user->usuario}}</td>
                          <td style='padding: 2%'>
                            <button type="submit" class="btn btn-info" style="margin: 10px;">Actualizar</button>
                          </td>
                          <td style='padding: 2%'>
                              <a href="{{ URL::to('usuario/eliminar', $user->id) }}" style="margin: 10px;" class="btn btn-danger">Eliminar</a>
                          </td>
                      </tr>
                    {!! Form::close() !!}
                  @endforeach
              </table>
          </div>
     </section>
     
@endsection
  
