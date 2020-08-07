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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Alta Categoria y Nivel</h3>
                
            </div>
            <div class="panel-body">



                <form id="catalogoform" class="form-horizontal" method="POST" action="{{ route('division.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('categoria') ? ' has-error' : '' }}">
                        <label for="categoria" class="col-md-4 control-label">Categoria:</label>
                        <div class="col-md-6">
                            <input id="categoria" type="text" class="form-control" name="categoria" value="{{ old('categoria') }}"  required>

                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('abreviatura') ? ' has-error' : '' }}">
                        <label for="abreviatura" class="col-md-4 control-label">Abreviatura</label>

                        <div class="col-md-6">
                            <input id="abreviatura" type="text" class="form-control" name="abreviatura" value="{{ old('abreviatura') }}"  required>

                            @if ($errors->has('abreviatura'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('abreviatura') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Crear categoria
                            </button>
                        </div>
                    </div>
                </form>
            </div>

    </section>

@endsection