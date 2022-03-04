
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
                    <h3>Lista de salones</h3>
                      
 {!! Form::open(["action" => "SalonController@search", "method" => "POST"])!!}
 {{ csrf_field() }}
  <div class="input-group">
      {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Salon"])!!}
      {!! Form::select('type', array(
        'sede' => 'Por sede', 
        'capacidad' => 'Por capacidad', 
        'ubicacion' => 'Por ubicacion'),
        null,['class' => 'btn dropdown-toggle pull-left'] ) !!}
{!! Form::close() !!}
<span class="input-group-btn col-md-2">
        <button class="btn btn-search " type="submit">Buscar</button>
      </span>
</div>
                </div>
                <div class="panel-body tablaFija">

                    <table class="col-md-12">
                        <tr>
                            <th>Sede</th>
                            <th>Capacidad</th>
                            <th>Ubicación</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->sede }} </td>
                                <td>{{ $user->capacidad}}</td>
                                <td>{{ $user->ubicacion}}</td>
                                <td><a href="{{ URL::to('salon', $user->id) }}" style="margin: 10px;" class="btn btn-info">Detalles</a>
                                    <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$user->id}}">Dar de baja</button></td>
                            </tr>

                        <!-- Modal -->
                    <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Salón</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar el salón {{ $user->sede }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('salon/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>
                        @endforeach

                    </table>

                
      

      </div>

     </section>
     
@endsection