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
    @if(sizeof($modulos)==0)
      <div class="alert alert-warning" role='alert'>No hay resultados</div>
    @endif
    <section class="content-inner">
      <br>
      @include ('partials.messages')
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Catálogo de Módulos</h3>
          {!! Form::open(["route" => "catalogo.modulo.search", "method" => "POST"]) !!}
          <div class="row">
            <div class="col-sm-6">
              {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Curso",'style'=>'margin: 5px;'])!!}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
            {!! Form::select('type', array(
              'nombre' => 'Por nombre',
              'clave' => 'Por clave',
              'coordinacion' => 'Por coordinación',),
              null,['class' => 'form-control btn dropdown-toggle pull-left', 'style'=>'margin: 5px;'] ) !!}
            </div>
            <div class="col-sm-2">
              <button class="btn btn-info " style='margin: 5px;' type="submit">Buscar</button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      

        <div class="panel-body tablaFija">
          <table class="col-md-12">
            <tr>
              <th>Clave</th>
              <th>Nombre del curso</th>
              <th>Coordinación</th>
            </tr>
            @foreach($modulos as $modulo )
              <tr>
                  <td>{{$modulo->clave_curso}}</td>
                  <td>{{$modulo->nombre_curso}}</td>
                  <td>{{$modulo->getCoordinacion()}}</td>
                  <td>
                      <a href="{{ route('modulo.nuevo', $modulo->id) }}" style="margin: 10px;" class="btn btn-success">Dar de alta</a>
                      <a href="{{ route('catalogo.modulo.ver', $modulo->id) }}" style="margin: 10px;" class="btn btn-info">Detalles</a>
                      <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$modulo->clave_curso}}">Dar de baja</button>
                  </td>
              </tr>
              <!-- Modal -->
              <div class="modal fade" id="myModal{{$modulo->clave_curso}}" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Eliminar Curso</h4>
                    </div>
                    <div class="modal-body">
                      <p>¿Está seguro de eliminar el curso {{$modulo->nombre_curso}}, con clave: {{$modulo->clave_curso}}?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                      <a href="{{ route('catalogo.modulo.delete', $modulo->id) }}" class="btn btn-danger">Dar de baja</a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </table>
        </div>
      </div>
    </section>
@endsection

