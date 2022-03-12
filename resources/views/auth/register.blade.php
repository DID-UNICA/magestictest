@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
  @include('partials.messages')
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Registrar</div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{ route('usuario.create') }}">
            {{ csrf_field() }}
            
            <div class="form-group{{ $errors->has('usuario') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Usuario *</label>
              <div class="col-md-6">
                <input id="usuario" type="text" class="form-control" name="usuario" value="{{ old('usuario') }}" required autofocus>
                @if ($errors->has('usuario'))
                  <span class="help-block">
                    <strong>{{ $errors->first('usuario') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
              <label for="nombre" class="col-md-4 control-label">Nombre</label>
              <div class="col-md-6">
                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                @if ($errors->has('nombre'))
                  <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                  </span>
                @endif
              </div>
            </div>
     
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('es_admin') ? ' has-error' : '' }}">
              <label for="es_admin" class="col-md-4 control-label">¿Es administrador? *</label>
              <div class="col-md-2">
                <input id="es_admin" type="checkbox" name="es_admin">
                @if ($errors->has('es_admin'))
                  <span class="help-block">
                      <strong>{{ $errors->first('es_admin') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Contraseña</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>
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
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-10 control-label">* Campo obligatorio</label>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Registro
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
