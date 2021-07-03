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
            <img class="img-escudo" src="{{ asset('img/cdd.png') }}">
            <h3>Manejo y Gestión de Información del Centro de Docencia.</h3>
          </div>
          <h2>Diplomas <span class="fa fa-file-pdf-o"></span></h2>
          <table class="table table-hover">
            <div class="collapse navbar-collapse" id="menuCurso">
              <form class="form-horizontal" method="GET" action="{{ route('diplomas.generar', $diplomado->id) }}">
                {{ csrf_field() }} 
                <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                  <table class="col-md-12">
                    <tr>
                     <th>Nombre:</th>
                      <th>
                      Folio pequeño:
                      </th>
                    </tr>
                    <tr>
                      <td>{{ $diplomado->nombre_diplomado }} </td>
                      <td>
                        <div class="form-group{{ $errors->has('folder') ? ' has-error' : '' }}">
                          <div class="col-md-6">
                            <input id="folder" type="number" placeholder="Número" class="form-control" name="folder" value="{{ old('folder') }}" >
                            @if ($errors->has('folder'))
                              <span class="help-block">
                                <strong>{{ $errors->first('folder') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </td>
                      <td class= "col-md-2">
                        <button type="submit" class="btn btn-info form-control" name="id" value="{{$diplomado->id}}">Crear</button>
                      </td>
                    </tr>
                    <tr>
                      <td> {!!Form::label("typeId_label", "Folio institucional (Número consecutivo):")!!}</td>
                    </tr>
                    <tr>
                      <td> {!!Form::text("typeid", null, [ "class" => "form-control", "placeholder" => "Dígitos nueve, diez y once del folio"])!!}</td>
                    </tr>
                    <tr>
                      <td> {!!Form::label("numfoja", "Número Foja:")!!}</td>
                    </tr>
                    <tr>
                      <td> {!!Form::number("foja", null, [ "class" => "col-md-6 form-control", "placeholder" => "Número, en blanco no aparecerá en el diploma", ""])!!}</td>
                    </tr>
                    <tr>
                      <td> {!!Form::label("numlibro", "Número Libro:")!!}</td>
                    </tr>
                    <tr>
                      <td> {!!Form::number("libro", null, [ "class" =>"col-md-6 form-control", "placeholder" => "Número, en blanco no aparecerá en el diploma", ""])!!}</td>
                    </tr>
                  </table>
                </div>
              </form>                                    
            </div>
          </table>
    </section>
@endsection
  

  
