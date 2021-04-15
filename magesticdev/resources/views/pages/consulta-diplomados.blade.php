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
                  <h1>Diplomados programados</h1>
                  </div>
                </div>
      </div>
      <div class="panel-body tablaFija">
      @if( count($diplomados)==0 )
              <p>Aún no hay diplomados<p>
      @else

      <table class="col-md-12">
       <tr>
      <th>Nombre</th>

      <th></th>
     </tr></th>

      @foreach($diplomados as $diplomado)
              <tr>
              <td>{{ $diplomado->nombre_diplomado }} </td>

              <td>
                  <a href="{{ URL::to('diplomado/ver-diplomado',$diplomado->id) }}" style="margin-bottom: 15px;" class="btn btn-primary">Ver Módulos</a>
                  <a href="{{ URL::to('diplomado/ver-participantes',$diplomado->id) }}" style="margin-bottom: 15px;" class="btn btn-info">Ver Participantes</a>
                  <a href=" {{ URL::to('diplomado/inscribirAlumnos',$diplomado->id) }}" style="margin-bottom: 15px;" class="btn btn-success">Inscribir Participantes</a>
                  <a href="{{ URL::to('diplomado', $diplomado->id) }}" style="margin-bottom: 15px;" class="btn btn-warning">Detalles</a>
                  <a href=" {{ URL::to('diplomas', $diplomado->id)}}" style="margin-bottom: 15px;" class="btn btn-info">Diplomas</a>
                  <button type="button" class="btn btn-danger" data-toggle="modal" style="margin-bottom: 15px;" data-target="#myModal">Dar de baja</button>
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
                            <a href="{{ URL::to('diplomado/baja',$diplomado->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>
    @endforeach

</table>
@endif
<a class= "btn btn-primary" href="{{ route('diplomado.nuevo') }}">Alta de diplomado</a>
                
      

      </div>
      <script type="text/javascript">
        
      </script>

     </section>
     
@endsection
  

  
