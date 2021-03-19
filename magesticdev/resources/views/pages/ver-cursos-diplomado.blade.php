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
      <div class="panel panel-default">
      @include ('partials.messages')
                <div class="panel-heading">
                    <div class="container">
                  <h3>Diplomado: {{ $diplomado->nombre_diplomado }}</h3>

                  </div>
                </div>
      </div>
      <div class="panel-body">
@if(count($cursos) != 0)        
      <table>
      <tr>
        <th  style="text-align:center;">Módulo</th>
        <th  style="text-align:center;">Nombre</th>
        <th>Profesores</th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Fin</th>
        <th></th>
     </tr>
    @foreach($cursos as $curso)
        <tr>
        <td>{{ $curso->getNumModulo($diplomado->id)}}</td>
        <td>{{ $curso->getNombreCurso() }} </td>
        <td>{{ $curso->getProfesores() }}</td>
        <td>{{ $curso->fecha_inicio }}</td>
        <td>{{ $curso->fecha_fin }}</td>
        <td>
            <a href="{{ URL::to('curso/ver-profesores',$curso->id) }}" class="btn btn-primary">Ver Curso</a>
            <a href="{{ URL::to('curso', $curso->id) }}" class="btn btn-info">Detalles</a>
            <a href="{{ URL::to('reconocimientosDiploma', array($diplomado->id,$curso->id)) }}" class="btn btn-success">Reconocimientos</a>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModalDesc{{$curso->id}}">Descartar de Diplomado</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$curso->id}}">Dar de baja</button>
        </td>
      </tr>

                  <!-- Modal Descartar diplomado-->
                        <div class="modal fade" id="myModalDesc{{$curso->id}}" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Descartar Curso del Diplomado</h4>
                              </div>
                              <div class="modal-body">
                                <p><b>¿Está seguro de descartar el curso?</b></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                <a href="{{ URL::to('diplomado/descartarCurso/'.$diplomado->id, $curso->id) }}" class="btn btn-warning">Descartar</a>
                              </div>
                            </div>
                          </div>
                        </div>
                  <!-- Modal -->
                    <div class="modal fade" id="myModal{{$curso->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Curso</h4>
                          </div>
                          <div class="modal-body">
                            <p><b>¿Está seguro de eliminar el curso?</b></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('curso/bajad', $curso->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>      
    @endforeach
</table>
@endif
  <a href="{{ URL::to('diplomado/añadir-cursos',$diplomado->id) }}" class="btn btn-primary">Añadir Cursos a Diplomado</a>
  <a href="{{ route('diplomado.consulta') }}" class="btn btn-info">Regresar</a>
</div>
<script type="text/javascript">     
</script>
</section>
@endsection


