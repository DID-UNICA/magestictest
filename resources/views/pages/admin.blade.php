<!-- Guardado en resources/views/pages/admin.blade.php -->

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
    @include('partials.messages')

      <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Bienvenid@ {{ auth()->user()->nombres }}</h3>
                </div>
                <div class="panel-body">

                <div class="logos col-md-12 col-center">
                    <img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                    Manejo y Gestión de información del Centro de Docencia.</h3>
                
                </div>

                <hr>
                <h2>Cumpleaños <span class="fa fa-birthday-cake""></span></h2>
                <table class="table table-hover">

                <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha de nacimiento</th>
                </tr>
                @if( empty($profesors))
                        @foreach($profesors as $profesor)
                            <tr>
                                <td>{{ $profesor->nombres }} {{ $profesor->apellido_paterno }} {{ $profesor->apellido_materno }}</td>
                                <td>{{ $profesor->email}}</td>
                                <td>{{ $profesor->fechaFormato()}}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                <table class="table table-hover">
                            <tr>
                                <td>No hay cumpleaños por el momento</td>
                            </tr>
                    </table>
                @endif
                </div>

     </section>
     
@endsection