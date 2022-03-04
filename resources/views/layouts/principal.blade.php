<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/favicon.ico') }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>MagestiCD </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/jquery.fancybox.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin.css') }}"/>

</head>
<body>
<div class="wrap">
    <nav class="nav-bar navbar-inverse" role="navigation">
        <div id ="top-menu" class="container-fluid active">
            <a class="navbar-brand" href="{{ URL::to('admin/') }}">MagestiCD</a>
            <ul class="nav navbar-nav">

                <li class="dropdown movable">
                    
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
                        <?php
                        try{
                         echo auth()->user()->usuario; 
                        }catch(\ErrorException  $e){
                            return view('welcome');                        
                        }

                         ?>           


                        <span class="fa fa-2x fa-user-circle"></span></a>
                    <ul class="dropdown-menu" role="menu">


                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                            <form id="ajustes-form" action="{{ route('usuario.editar') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input name="id" value="{{ auth()->user()->id }}">
                            </form>

                            <form id="register-form" action="{{ route('registrar') }}" method="GET" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        <li>
                            <a href="{{ route('usuario.editar') }}"
                               onclick="event.preventDefault();
                                document.getElementById('ajustes-form').submit();">
                                <div style="text-align: left;">
                                Cuenta 
                               
                                </div>
                            </a>

                            <a href="{{ route('register') }}"
                              onclick="event.preventDefault();
                              document.getElementById('register-form').submit();">
                              <div style="text-align: left;">
                              Registrar Usuario
                              </div>
                            </a>
                            
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <div style="text-align: left;">
                                Cerrar sesión
                               
                                </div>
                            </a>
                            
                            
                        </li>
                    </ul>

            </ul>
            </li>
            </ul>
        </div>
    </nav>

    <aside id="side-menu" class="aside" role="navigation">
        <ul class="nav nav-list accordion">
            <li class="nav-header">
                <div class="link"><i class="fa fa-lg fa-send"></i>Diplomados<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                  <li><a href="{{ route('diplomado.consulta') }}">Ver Diplomados</a></li>
                  <li><a href="{{ route('diplomado.nuevo') }}">Alta de diplomado</a></li>
                  <li><a href="{{ route('modulo.consulta') }}">Ver Módulos Programados</a></li>
                  <li><a href="{{ route('catalogo.modulo.consulta') }}">Ver Catálogo de Módulos</a></li>
                  <li><a href="{{ route('catalogo.modulo.nuevo') }}">Alta de módulo</a></li>

                </ul>
            </li>

            <li class="nav-header">
                <div class="link"><i class="fa fa-lg fa-book"></i>Cursos<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="{{ route('curso.consulta') }}">Cursos programados</a></li>
                    <li><a href="{{ route('catalogo-cursos.ver.todos') }}">Catálogo de cursos</a></li>
                    <li><a href="{{ route('catalogo-cursos.nuevo') }}">Alta Catálogo</a></li>
                </ul>
            </li>

            <li class="nav-header">
                <div class="link"><i class="fa fa-users"></i>Profesores<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="{{ route('profesor.nuevo') }}">Alta Profesor</a></li>
                    <li><a href="{{ route('profesor.consulta') }}">Consulta de profesores</a></li>
                    <li><a href="{{route('categoria.consulta')}}">Categoría y Nivel</a></li>
                </ul>
            </li>

            <li class="nav-header">
                <div class="link"><i class="fa fa-building"></i>Salones<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="{{ route('salon.consulta') }}">Consulta Salones</a></li>
                    <li><a href="{{ route('salon.nuevo') }}">Alta de Salón</a></li>
                </ul>
            </li>
            <li class="nav-header">
                <div class="link"><i class="fa fa-graduation-cap"></i>Carreras<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="{{ route('carrera.consulta') }}">Consulta Carreras</a></li>
                    <li><a href="{{ route('carrera.nuevo') }}">Alta de Carreras</a></li>
                    <!--<li><a href="#">Baja de Salon</a></li>-->
                </ul>
            </li>
            <li class="nav-header">
                <div class="link"><i class="fa fa-lg fa-map-marker"></i>Coordinaciones<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="{{route('coordinacion.nuevo')}}">Alta de Coordinación</a></li>
                    <li><a href="{{route('coordinacion.consulta')}}">Consulta de coordinaciones</a></li>
                    <li><a href="{{route('coordinador-general.consulta')}}">Coordinación del Centro de Docencia</a></li>
                    <li><a href="{{route('secretario-apoyo.consulta')}}">Secretaría de apoyo</a></li>
                    <li><a href="{{route('direccion.consulta')}}">Dirección</a></li>

                </ul>
            </li>

            <li class="nav-header">
                <div class="link"><i class="fa fa-lg fa-suitcase"></i>Divisiones<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="{{route('division.nuevo')}}">Alta de División</a></li>
                    <li><a href="{{route('division.consulta')}}">Consulta de Divisiones</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    @yield('contenido')

    <footer class="content-inner">
        <div class="panel panel-default">
            <div class="panel-heading">
                Hecho en México, Universidad Nacional Autónoma de México, Facultad de Ingeniería, Unidad de Servicios de Cómputo Académico, Departamento de Investigación y Desarrollo.
                Todos los derechos reservados 2017.
            </div>
        </div>
    </footer>
</div>
<script src="{{ asset ('/js/jquery.js') }}"></script>
<script src="{{ asset ('/js/admin.js') }}"></script>
<script src="{{ asset ('/dist/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>