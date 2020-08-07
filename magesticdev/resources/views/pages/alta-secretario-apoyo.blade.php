
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
            <div class="panel-heading">
                <h3>Alta Secretario de Apoyo</h3>
                
            </div>
            <div class="panel-body">
                <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('secretario-apoyo.store') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group{{ $errors->has('secretario') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Secretario:</label>

                        <div class="col-md-6">
                            <input id="coordinador" type="text" class="form-control" name="secretario" value="{{ old('secretario') }}" >

                            @if ($errors->has('secretario'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('secretario') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('comentarios') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Comentarios:</label>
                    <div class="col-md-6">
                            <input id="comentarios" type="text" class="form-control" name="comentarios" value="{{ old('comentarios') }}" >

                            @if ($errors->has('comentarios'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('comentarios') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('grado') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Abreviatura del grado:</label>
                    <div class="col-md-6">
                            <input id="grado" type="text" class="form-control" name="grado" value="{{ old('grado') }}" >

                            @if ($errors->has('grado'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('grado') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Crear Secretario
                            </button>
                        </div>
                    </div>
                </form>
            </div>

    </section>

@endsection