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
                @include ('partials.messages')
                    <h3>Alta Coordinación</h3>
                    
                </div>
                <div class="panel-body">



                    <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('coordinacion.store') }}">
                        {{ csrf_field() }}



                        <div class="form-group{{ $errors->has('nombre_coordinacion') ? ' has-error' : '' }}">
                            <label for="nombre_coordinacion" class="col-md-4 control-label">Nombre de la coordinación: </label>

                            <div class="col-md-6">
                                <input id="nombre_coordinacion" type="text" class="form-control" name="nombre_coordinacion" value="{{ old('nombre_coordinacion') }}"  required oninvalid="this.setCustomValidity('Ingrese una clave por favor')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('nombre_coordinacion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre_coordinacion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('abreviatura') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Abreviatura</label>

                            <div class="col-md-6">
                                <input id="abreviatura" type="text" class="form-control" name="abreviatura" value="{{ old('abreviatura') }}" required oninvalid="this.setCustomValidity('Ingrese una abreviatura por favor')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('abreviatura'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('abreviatura') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('coordinador') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Coordinador</label>

                            <div class="col-md-6">
                                <input id="coordinador" type="text" class="form-control" name="coordinador" value="{{ old('coordinador') }}" required oninvalid="this.setCustomValidity('Ingrese un coordinador por favor')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('coordinador'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('coordinador') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('usuario') ? ' has-error' : '' }}">
                            <label for="usuario" class="col-md-4 control-label">Nombre de Usuario</label>

                            <div class="col-md-6">
                                <input id="usuario" type="text" class="form-control" name="usuario" value="{{ old('usuario') }}" required oninvalid="this.setCustomValidity('Ingrese un nombre de usuario')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required oninvalid="this.setCustomValidity('Ingrese una contraseña')" oninput="this.setCustomValidity('')">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('comentarios') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Comentario</label>

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
                            <label for="grado" class="col-md-4 control-label">Abreviatura del grado del Coordinador:</label>

                            <div class="col-md-3">
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
                                    Crear Coordinación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

        </section>

@endsection