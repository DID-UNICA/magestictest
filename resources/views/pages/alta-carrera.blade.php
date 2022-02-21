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
            @include ('partials.messages')
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Alta Carrera</h3>
                    
                </div>
                <div class="panel-body">
                    <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('carrera.store') }}">
                        {{ csrf_field() }}



                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre de la carrera</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}"  required>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('clave') ? ' has-error' : '' }}">
                            <label for="clave" class="col-md-4 control-label">Clave</label>

                            <div class="col-md-6">
                                <input id="clave" type="number" class="form-control" name="clave" value="{{ old('clave') }}"  required>

                                @if ($errors->has('clave'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('clave') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Carrera
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

        </section>

@endsection