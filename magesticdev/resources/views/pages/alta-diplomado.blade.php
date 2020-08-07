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
        @if(session()->has('msj'))
            <div class="alert alert-success" role='alert'>{{session('msj')}}</div>
        @endif
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                @include ('partials.messages')
                    <h3>Alta Diplomados</h3>
                    
                </div>
                <div class="panel-body">
                    <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('diplomado.store') }}">
                        {{ csrf_field() }}



                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre del diplomado</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}"  required oninvalid="this.setCustomValidity('Ingrese un nombre por favor')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cupo_max') ? ' has-error' : '' }}">
                            <label for="cupo_max" class="col-md-4 control-label">Cupo Máximo: </label>

                            <div class="col-md-6">
                                <input id="cupo_max" min="0" type="number" class="form-control" name="cupo_max" value="{{ old('cupo_max') }}" required oninvalid="this.setCustomValidity('Ingrese un número por favor')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('cupo_max'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cupo_max') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Diplomado
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

        </section>

@endsection