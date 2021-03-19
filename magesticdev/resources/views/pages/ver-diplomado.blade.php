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
                      <h1>Diplomado: {{ $diplomado->nombre_diplomado}} </h1>

                  </div>
                </div>
      </div>
      <div class="panel-body">

<div class="row">
  <div class="row col-md-12 ">
    <div class="form-group col-md-4">
      {!!Form::label("nombre", "Nombre:")!!}
      {!!Form::text("nombre", $diplomado->nombre_diplomado, [ "class" => "form-control", "placeholder" => "Nombre", "required","disabled"])!!}
    </div>
    <div class="form-group col-md-4">
      {!!Form::label("cupo_maximo", "Cupo Máximo:")!!}
      {!!Form::number("cupo_maximo", $diplomado->cupo_maximo, [ "class" => "form-control", "placeholder" => "Cupo Máximo", "required","disabled",'min'=>"0" ])!!}
    </div>
    <a href="{{ URL::to('diplomado/actualizar', $diplomado->id) }}" class="btn btn-success">Actualizar información</a>
    <a href="{{ URL::to('diplomado/baja', $diplomado->id) }}" class="btn btn-danger">Dar de baja</a></td>
    <a href="{{ route('diplomado.consulta') }}" class="btn btn-info">Regresar</a>


</div>

                
      

      </div>
      <script type="text/javascript">
        
      </script>

     </section>
     
@endsection
  

  
