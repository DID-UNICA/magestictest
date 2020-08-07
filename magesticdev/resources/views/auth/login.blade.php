<!doctype html>
<html class="no-js" lang="">
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/favicon.ico') }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Magesti - CD </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}"/>
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}"/>
       

    </head>
    <body>

<div class="jumbotron">
  <div class="container">
    <img class="cdd" src="./img/cdd.png" alt="">
    
    
    <h1>Magesti</h1>
    <h3>Manejo y Gestión de Información del Centro de Docencia</h3>
   
    <div class="box">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('usuario') ? ' has-error' : '' }}">
                            <label for="usuario" class="col-md-4 control-label">Usuario</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="usuario" value="{{ old('usuario') }}" required autofocus>

                                @if ($errors->has('usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Ingresar
                                </button>

                            </div>
                        </div>
                    </form>
    </div>


    <p class="text-justify"><h4> Hecho en México, Universidad Nacional Autónoma de México, Facultad de Ingeniería, Unidad de Servicios de Cómputo Académico, Departamento de Investigación y Desarrollo. 
Todos los derechos reservados 2017. </h4></p>
  </div>
</div>
    </div> <!-- /container -->        
    <script src="{{ asset ('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('/js/main.js') }}"></script>

        
    </body>
</html>
