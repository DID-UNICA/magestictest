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
                <h3>Alta Catálogo de Módulos</h3>
                <h4>Coordinación de Gestión y Vinculación</h4>
            </div>
            <div class="panel-body">

                <form id="catalogocursoform" class="form-horizontal" method="POST" action="{{ route('catalogo.modulo.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('clave_curso') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Clave:</label>

                        <div class="col-md-6 col-sm-3">
                            <input id="clave_curso" type="text" class="form-control" name="clave_curso" value="{{ old('clave_curso') }}" maxlength="25" required oninvalid="this.setCustomValidity('Ingrese la clave por favor')" oninput="this.setCustomValidity('')">

                            @if ($errors->has('clave_curso'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('clave_curso') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('nombre_curso') ? ' has-error' : '' }}">
                        <label for="nombre_curso" class="col-md-4 control-label">Nombre del curso:</label>

                        <div class="col-md-6">
                            <input id="nombre_curso" type="text" class="form-control" name="nombre_curso" value="{{ old('nombre_curso') }}" required oninvalid="this.setCustomValidity('Ingrese el nombre por favor')"
    oninput="this.setCustomValidity('')">

                            @if ($errors->has('nombre_curso'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre_curso') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('duracion_curso') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Duración:</label>

                        <div class="col-md-3 col-sm-3">
                            <input id="duracion_curso" type="number" min="0" class="form-control" name="duracion_curso" value="{{ old('duracion_curso') }}" required oninvalid="this.setCustomValidity('Ingrese la duración con un valor mayor a 0 por favor')" oninput="this.setCustomValidity('')">

                            @if ($errors->has('duracion_curso'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('duracion_curso') }}</strong>
                                    </span>
                            @endif
                        </div> Hrs.
                    </div>

                    <div class="form-group{{ $errors->has('coordinacion_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Coordinación:</label>
                        <div class="col-md-6">
                            <select name="coordinacion_id" form="catalogocursoform" class="form-control" required>
                                @foreach($coordinaciones as $coordinacion)
                                    <option value="{{ $coordinacion->id }} ">{{ $coordinacion->nombre_coordinacion }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('coordinacion_id'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('coordinacion_id') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Tipo:</label>

                        <div class="col-md-6">
                                <select id="tipo" class="form-control" name="tipo" value="{{ old('tipo')}}">
                                    <option selected value="D">Módulo de diplomado</option>
                                </select>
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('institucion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Institución:</label>

                        <div class="col-md-6">
                                <select id="institucion" class="form-control" name="institucion" value="{{ old('institucion')}}">
                                    <option value="DGAPA">DGAPA</option>
                                    <option value="CDD">Centro de Docencia</option>
                                </select>
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>

                    <div class="form-group{{ $errors->has('dirigido') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Dirigido:</label>

                        <div class="col-md-5">
                            <textarea cols="90" wrap="hard" id="dirigido" type="text" class="form-control" name="dirigido" value="{{ old('dirigido') }}">@if ($errors->has('dirigido'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dirigido') }}</strong>
                                    </span>
                            @endif</textarea>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('objetivo') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Objetivo:</label>
                        <div class="col-md-5">
                            <textarea cols="90" wrap="hard" id="objetivo" type="text" class="form-control" name="objetivo" value="{{ old('objetivo') }}">@if ($errors->has('objetivo'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('objetivo') }}</strong>
                                </span>
                            @endif</textarea>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('contenido') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Contenidos:</label>
                        <div class="col-md-5">
                                <textarea cols="90" wrap="hard" id="contenido" type="text" class="form-control" name="contenido" value="{{ old('contenido') }}">@if ($errors->has('contenido'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('contenido') }}</strong>
                                </span>
                            @endif</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('fecha_disenio') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Fecha de diseño:</label>

                        <div class="col-md-2">
                            <input id="fecha_disenio" type="date"  class="form-control" name="fecha_disenio" value="{{ old('fecha_disenio') }}" required oninvalid="this.setCustomValidity('Ingrese una fecha de diseño por favor entre 01/01/2010 y 30/12/2030')" oninput="this.setCustomValidity('')" min="2010-01-01" max="2030-12-30">

                            @if ($errors->has('fecha_disenio'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('fecha_disenio') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div id="antecedentes" class="form-group{{ $errors->has('antesc') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Antecedentes:</label>
                        <div class="col-md-5">
                            <textarea cols="90" wrap="hard" type="text" class="form-control" name="antesc"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Crear
                            </button>
                        </div>

                    </div>
                </form>
            </div>
    </section>

@endsection

