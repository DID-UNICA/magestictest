<!-- Guardado en resources/views/pages/admin.blade.php -->

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
          <h3>Coordinación de Gestión y Vinculación</h3>
        </div>
        <div class="panel-body">
          @include('flash::message')
          <div class="logos col-md-12 col-center">
            <h3>
              <img class="img-escudo" src="{{ asset('img/cdd.png') }}">
              Manejo y Gestión de Información del Centro de Docencia.
            </h3>
          </div>
          <hr>
          <h2>Generación de Diplomas <span class="fa fa-file-pdf-o"></span></h2>
          <h3>{{ $diplomado->nombre_diplomado }}</h3>
          <div class="collapse navbar-collapse" id="menuCurso">
            <form class="form-horizontal" method="GET" action="{{ route('diplomas.generar', $diplomado->id) }}">
            {{ csrf_field() }}
              <div class="col-6">
                <div class="form-row">
                  <div class="form-group col-md-6" style="margin-right: 5px;">
                    {!! Form::label('folio_inst', 'Folio institucional:');!!}
                    {!! Form::text('folio_inst', null, ["class"=>"form-control", "placeholder"=>"Caracteres hasta antes del número de lista"]);!!}
                  </div>
                  <div class="form-group col-md-6" style="margin-right: 5px;">
                    {!! Form::label('folio_peq', 'Folio pequeño:');!!}
                    {!! Form::text('folio_peq', null, ["class"=>"form-control", "placeholder"=>"Número inicial"]);!!}
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6" style="margin-right: 5px;">
                    {!!Form::label("num_foja", "Número Foja:");!!}
                    {!!Form::number("num_foja", null, ["class" => "form-control",  "placeholder" => "Ingrese el número"]);!!}</td>
                  </div>
                  <div class="form-group col-md-6" style="margin-right: 5px;">
                    {!! Form::label('num_libro', 'Número de Libro:');!!}
                    {!! Form::number('num_libro', null, ["class"=>"form-control", "placeholder"=>"Ingrese el número"]);!!}
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-1" >
                    <button type="submit" class="btn btn-info" name="id" value="{{$diplomado->id}}">Generar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
    </section>
@endsection