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
    @if(session()->has('msj'))
            <div class="alert alert-danger" role='alert'>{{session('msj')}}</div>
        @endif
    <br>
      <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Coordinación de Gestión y Vinculación</h3>
                </div>
                <div class="panel-body">
                @include('flash::message')
                <div class="logos col-md-12 col-center">
                	<img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                	Manejo y Gestión de información del centro de docencia.</h3>
                </div>

                <hr>
                <h2>Reconocimientos <span class="fa fa-file-pdf-o"</span></h2>


                    <table class="table table-hover">
                       <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                            <div class="collapse navbar-collapse" id="menuCurso">
            @if(isset($diplomado))    
              <form class="form-horizontal" method="GET" action="{{ route('reconocimientos.generard',[$diplomado->id, $curso->id])}}">
            @else
              <form class="form-horizontal" method="GET" action="{{ route('reconocimientos.generar',[$curso->id])}}">
            @endif
          <table class="col-md-12">
                <tr>
                    <th>Nombre</th>
                    <th>Instructor</th>
                    <th>Semestre</th>
                    <th>Tipo Detectado</th>
                    <th>
                    @if ($curso->getTipoCadenaUpper()=='Evento')
                      {!!Form::label("personalizado", "Texto personalizado (Largo):")!!}
                    @endif
                    </th>
                </tr>
                  <tr>
                      <td>{{ $curso->getNombreCurso() }} </td>
                      <td>{{ $curso->getProfesores() }}</td>
                      <td>{{ $curso->getSemestre() }}</td>
                      <td>{{ $curso->getTipoCadenaUpper() }}</td>
                      <td>
                      @if ($curso->getTipoCadenaUpper()=='Evento')
                        {!!Form::text("texto_personalizado", null, [ "class" => "form-control", "placeholder" => "Texto", "required",""])!!}
                      @endif
                      </td>
                      <td>
                        <button style="margin: 10px;" type="submit" class="btn btn-primary form-control" name="id" value="{{ $curso->id }}">
                            Crear
                        </button>
                      </td>
                </tr>
                <tr>
                <td> {!!Form::label("numeroinicial", "Número Inicial:")!!}</td>
                <td> {!!Form::number("folio_der", null, [ "class" => "form-control", "placeholder" => "Número", "required",""])!!}</td>
                </tr>
                

            </table>

          </form>

                
                                                        
      </div>

     </section>
	 
@endsection
  

  
