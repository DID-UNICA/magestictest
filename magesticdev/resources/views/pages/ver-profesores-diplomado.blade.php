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
    @foreach ($bajas as $baja)
    <div class="alert alert-danger" role=alert>
        <strong>El profesor {{$baja['nombres']}} fue dado de baja del módulo {{$baja['modulo']}}, debe considerarse descartarlo del diplomado</strong>
    </div>
    @endforeach
      <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="container">
                  <h1>Diplomado</h1>
                  <h2>{{ $diplomado->nombre_diplomado }}</h2>

                  </div>
                </div>
      </div>
      <div class="panel-body  tablaFija">
      @if( count($profesores) == 0)
        <p>Aún no hay profesores inscritos en este diplomado</p>
      @else
          <table class="col-md-12">
         <tr>
            <th>Nombre</th>
            <th></th>
         </tr>
        @foreach($profesores as $profesor)
            <tr>
            <td>{{ $profesor->getNombres() }} </td>

            <td>
              <button type="button" style="margin-bottom: 15px;" class="btn btn-warning" data-toggle="modal" data-target="#myModalDesc{{$profesor->id}}">Descartar de Diplomado</button>
            </td>
          </tr>
                      <!-- Modal Descartar diplomado-->
                        <div class="modal fade" id="myModalDesc{{$profesor->id}}" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Descartar Profesor del Diplomado</h4>
                              </div>
                              <div class="modal-body">
                                <p><b>¿Está seguro de descartar al profesor?</b></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                <a href="{{ URL::to('diplomado/descartarParticipante/'.$diplomado->id, $profesor->id) }}" class="btn btn-warning">Descartar</a>
                              </div>
                            </div>
                          </div>
                        </div>           
              @endforeach
          </table>
    @endif
      <a href="{{ route('diplomado.consulta') }}" class="btn btn-info">Regresar</a>
      </div>
      <script type="text/javascript"></script>
     </section>

@endsection


