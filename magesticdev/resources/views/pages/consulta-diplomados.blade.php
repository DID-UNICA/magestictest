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
    @if(session()->has('msj'))
      <div class="alert alert-danger" role='alert'>{{session('msj')}}</div>
    @endif
    <br>
      <div class="panel panel-default">
      @include ('partials.messages')
                <div class="panel-heading">
                    <div class="container">
                  <h3>Diplomados programados</h3>

                  </div>
                </div>
      </div>
      <div class="panel-body">
      @if( count($diplomados)==0 )
              Aún no hay diplomados
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
                  <a href="{{ URL::to('diplomado/ver-diplomado',$diplomado->id) }}" class="btn btn-primary">Ver Diplomado</a>
                  <a href="{{ URL::to('diplomado/ver-participantes',$diplomado->id) }}" class="btn btn-info">Ver Participantes</a>
                  <a href=" {{ URL::to('diplomado/inscribirAlumnos',$diplomado->id) }}" class="btn btn-success">Inscribir</a>
                  <a href="{{ URL::to('diplomado', $diplomado->id) }}" class="btn btn-warning">Detalles</a>
                  <a href=" {{ URL::to('diplomas', $diplomado->id)}}" class="btn btn-info">Diplomas</a>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Dar de baja</button>
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

                
      

      </div>
      <script type="text/javascript">
        
      </script>

     </section>
     
@endsection
  

  
