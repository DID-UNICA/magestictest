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
          <div class="container" style="margin:3px;">
            <h1>Consulta de Diplomados</h1>
            {!! Form::open(["route" => ["diplomado.search"], "method" => "POST"]) !!}
            {{ csrf_field() }}

              <div class="row">
                <div class="form-group col-sm-6">
                  {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Diplomado", "id"=>"entrada"])!!}
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                    <button class="btn btn-info" type="submit">Buscar</button>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="panel-body tablaFija">
      @if( count($diplomados)==0 )
        <p>Aún no hay diplomados, primero debe crear alguno<p>
      @else
        <table class="col-md-12">
          <tr>
            <th>Nombre</th>
            <th></th>
          </tr>
          @foreach($diplomados as $diplomado)
            <tr>
              <td>{{ $diplomado->nombre_diplomado }} </td>
              <td>
                  <a href="{{ route('modulo.consulta.diplomado', $diplomado->id) }}" style="margin-bottom: 15px; margin-left: 10px;" class="btn btn-info">Ver Módulos</a>
                  <a href="{{ route('diplomado.modulo.asignar', $diplomado->id) }}" style="margin-bottom: 15px; margin-left: 10px;" class="btn btn-primary">Asignar Módulos</a>
                  <a href="{{ route('diplomas.elegirTipoDiploma', $diplomado->id) }}" style="margin-bottom: 15px; margin-left: 10px;" class="btn btn-success">Diplomas</a>
                  <a href="{{ route('diplomado.edit', $diplomado->id) }}" style="margin-bottom: 15px; margin-left: 10px;" class="btn btn-warning">Editar</a>
                  <button type="button" class="btn btn-danger" data-toggle="modal" style="margin-bottom: 15px; margin-left: 10px;" data-target="#myModal">Eliminar</button>
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Eliminar Diplomado</h4>
                  </div>
                  <div class="modal-body">
                    <p>¿Está seguro de eliminar el diplomado?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                    <a href="{{ route('diplomado.delete',$diplomado->id) }}" class="btn btn-danger">Eliminar</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </table>
      @endif
      <a class= "btn btn-primary" href="{{ route('diplomado.nuevo') }}">Alta de diplomado</a>
    </div>
  </section>   
@endsection
  

  
