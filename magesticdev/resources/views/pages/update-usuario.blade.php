@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('usuario.update') }}">
                        
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('usuario') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Usuario *</label>

                            <div class="col-md-6">
                                <input id="usuario" type="text" class="form-control" name="usuario" value="{{ $user->usuario }}"  autofocus disabled>
                                <input type="hidden" name="user1" value="{{ $user->usuario }}">

                                @if ($errors->has('usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>    

                        <div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
                            <label for="nombres" class="col-md-4 control-label">Nombre *</label>

                            <div class="col-md-6">
                                <input id="nombres" type="text" class="form-control" name="nombres" value="{{ $user->nombres }}"  autofocus>

                                @if ($errors->has('nombres'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombres') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('apellido_paterno') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Apellido Paterno *</label>

                            <div class="col-md-6">
                                <input id="apellido_paterno" type="text" class="form-control" name="apellido_paterno" value="{{ $user->apellido_paterno }}" autofocus>

                                @if ($errors->has('apellido_paterno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('apellido_materno') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Apellido Materno</label>

                            <div class="col-md-6">
                                <input id="apellido_materno" type="text" class="form-control" name="apellido_materno" value="{{ $user->apellido_materno }}" autofocus>

                                @if ($errors->has('apellido_materno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellido_materno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>     

                        <div class="form-group{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Fecha de nacimiento</label>

                            <div class="col-md-6">
                                <input id="fecha_nacimiento" type="date" class="form-control" name="fecha_nacimiento" value="{{ $user->fecha_nacimiento }}" autofocus>

                                @if ($errors->has('fecha_nacimiento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>      

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail *</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Contraseña actual *</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control" name="current_password" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-10 control-label">* Campo obligatorio</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
