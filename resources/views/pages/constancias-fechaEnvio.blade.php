@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<style>
    nav.navbar{
        background-color: #FAF8F8;
    }
</style>

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
                    <h3>Generación de Formatos</h3>
                </div>
                <div class="panel-body">
                @include('flash::message')
                  <div class="logos col-md-12 col-center">
                    <h3>
                      <img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                      Manejo y Gestión de información del Centro de Docencia.
                    </h3>
                  </div>
                  <hr>
                  <h2>Constancias <span class="fa fa-file-pdf-o"</span></h2>
                      <div class="collapse navbar-collapse" id="menuCurso">
                        <form id="form" class="form-horizontal" method="POST" action="{{ route('constancias.actualizarFecha', $curso->id)}}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                          <div class="col-md-4">
                              {!!Form::label("envio", "Fecha de envío:")!!}
                          </div>
                          <div class="col-md-6">
                              {!!Form::date("envio", $curso->fecha_envio_constancia, [ "class" => "form-control"])!!}
                          </div>
                          <div class="col-md-2">
                              <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                          </div>
                          <div class="col-md-2">
                            <a href="{{ route('constancias.elegirTipoConstancia',[$curso->id]) }}" class="btn btn-danger">Cancelar</a></td>
                          </div>
                        </div>
                        </form>
                      </div>
</div>
</section>
@endsection