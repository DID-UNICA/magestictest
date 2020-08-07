@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<style>
    nav.navbar{
        background-color: #FAF8F8;
    }
</style>


<style type="text/javascript">
    determinarFirmantes();
    determinarTexto();
</style>

  <div class="content">
    <div class="top-bar">
      <a href="#menu" class="side-menu-link burger">
        <span class='burger_inside' id='bgrOne'></span>
        <span class='burger_inside' id='bgrTwo'></span>
        <span class='burger_inside' id='bgrThree'></span>
      </a>
    </div>

     @if(session()->has('msj'))
        <div class="alert alert-danger" role='alert'>{{session('msj')}}</div>
      @endif

    <section class="content-inner">
    <br>
      <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Coordinación de Gestión y Vinculación</h3>
                </div>
                <div class="panel-body">
                @include('flash::message')
                <div class="logos col-md-12 col-center">
                	<img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                	Manejo y Gestión de información del centro de docencia.</h3>
                </div>

                <hr>
                <h2>Constancias <span class="fa fa-file-pdf-o"</span></h2>


                    <table class="table table-hover">
                       <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                            <div class="collapse navbar-collapse" id="menuCurso">
                
              <form id="form" class="form-horizontal" method="GET" action="{{ route('constancias.generar.b', $curso->id)}}">
                {{ csrf_field() }}


                <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tipo de constancia: </label>
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="auxiliar">
                                <select id="type" class="form-control" name="type" value="{{ old('type')}}" onchange="determinarFirmantes()">
                                @if($count_profesores > 3)
                                    <option value="AA">Coordinación</option>
                                    <option value="D">Coordinación General</option>
                                    <option value="I">Coordinación y Coordinador general</option>
                                    <option value="E">Director</option>
                                    <option value="F">Coordinación General  y Secretaría de Apoyo a la Docencia</option>
                                    <option value="G">Secretaría de Apoyo a la Docencia y Director</option>
                                    <option value="H">UNICA</option>
                                    <option value="f1">Un firmante</option>
                                    <option value="f2">Dos firmantes</option>
                                    <option value="f3">Tres firmantes</option>
                                    <option value="f4">Cuatro firmantes</option>
                                    <option value="f5">Cinco firmantes</option>
                                @else
                                    <option value="A">Instructores y Coordinador</option>
                                    <option value="B">Instructores y Coordinación General</option>
                                    <option value="C">Instructores y Secretaría de Apoyo a la Docencia</option>
                                    <option value="AA">Coordinación</option>
                                    <option value="D">Coordinación General</option>
                                    <option value="I">Coordinación y Coordinador general</option>
                                    <option value="E">Director</option>
                                    <option value="F">Coordinación General  y Secretaría de Apoyo a la Docencia</option>
                                    <option value="G">Secretaría de Apoyo a la Docencia y Director</option>
                                    <option value="H">UNICA</option>
                                    <option value="f1">Un firmante</option>
                                    <option value="f2">Dos firmantes</option>
                                    <option value="f3">Tres firmantes</option>
                                    <option value="f4">Cuatro firmantes</option>
                                    <option value="f5">Cinco firmantes</option>
                                @endif
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                </div>
                <br>
                <div class="form-group col-md-4">
                    {!!Form::label("numero", "Número Inicial:")!!}
                </div>
                <div class="form-group col-md-6">
                    {!!Form::text("numero", null, [ "class" => "form-control", "placeholder" => "Número", "required"])!!}
                </div>
                

            <br>
            <div id = "generacion" style="display:none">
                <div class="col-md-4 form-group{{ $errors->has('generacion') ? ' has-error' : '' }}">
                    <label for="generacion" class="col-md-4 control-label">Generación: </label>
                </div>
                <div class="col-md-6 form-group{{ $errors->has('generacion') ? ' has-error' : '' }}">
                    <input id="numgen" type="number" class="form-control" name="generacion" value="{{ old('generacion') }}" >
                </div>
            </div>

                <div id="nombre" style="display:none" class="form-group{{ $errors->has('name1A') ? ' has-error' : '' }}">
                    <label for="name1A" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1A" type="text" class="form-control" name="name1A" value="{{ old('name1A') }}" >
                        @if ($errors->has('name1A'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1A') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div id="cargo" style="display:none" class="form-group{{ $errors->has('posicion1A') ? ' has-error' : '' }}">
                    <label for="posicion1A" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1A" type="text" class="form-control" name="posicion1A" value="{{ old('posicion1A') }}" >
                        @if ($errors->has('posicion1A'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1A') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            
            <div id = "unFirmante" style="display:none">
                <div class="form-group{{ $errors->has('texto1') ? ' has-error' : '' }}">
                    <label for="text1" class="col-md-4 control-label">Texto Intermedio: </label>
                    <div class="col-md-6">
                                <select id="texto1" class="form-control" name="texto1" value="{{ old('texto1')}}" onchange="determinarTexto()">
                                    <option value="por haber acreditado el ">por haber acreditado el <<i>tipo de curso</i>></option>
                                    <option value="por haber asistido al ">por haber asistido al <<i>tipo de curso</i>></option>
                                    <option value="por haber sido parte del ">por haber sido parte del <<i>tipo de curso</i>></option>
                                    <option value="D">Personalizado</option>

                                </select>
                                @if ($errors->has('text1'))
                            <span class="help-block">
                                <strong>{{ $errors->first('text1') }}</strong>
                            </span>
                        @endif

                        <div id="textoPersonalizado1" style="display:none">

                            <div class="form-group{{ $errors->has('texto1') ? ' has-error' : '' }}">
                                <input id="texto1P" type="text" class="form-control" name="texto1P" value="{{ old('texto1P') }}" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name1A') ? ' has-error' : '' }}">
                    <label for="name1A" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1A" type="text" class="form-control" name="name1A" value="{{ old('name1A') }}" >
                        @if ($errors->has('name1A'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1A') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1A') ? ' has-error' : '' }}">
                    <label for="posicion1A" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1A" type="text" class="form-control" name="posicion1A" value="{{ old('posicion1A') }}" >
                        @if ($errors->has('posicion1A'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1A') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div id = "dosFirmantes" style="display:none">

                <div class="form-group{{ $errors->has('texto2') ? ' has-error' : '' }}">
                    <label for="text2" class="col-md-4 control-label">Texto Intermedio: </label>
                    <div class="col-md-6">
                                <select id="texto2" class="form-control" name="texto2" value="{{ old('texto2')}}" onchange="determinarTexto()">
                                    <option value="por haber acreditado el ">por haber acreditado el <<i>tipo de curso</i>></option>
                                    <option value="por haber asistido al ">por haber asistido al <<i>tipo de curso</i>></option>
                                    <option value="por haber sido parte del ">por haber sido parte del <<i>tipo de curso</i>></option>
                                    <option value="D">Personalizado</option>

                                </select>
                                @if ($errors->has('text2'))
                            <span class="help-block">
                                <strong>{{ $errors->first('text2') }}</strong>
                            </span>
                        @endif

                        <div id="textoPersonalizado2" style="display:none">

                            <div class="form-group{{ $errors->has('texto2P') ? ' has-error' : '' }}">
                                <input id="texto2P" type="text" class="form-control" name="texto2P" value="{{ old('texto2P') }}" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name1B') ? ' has-error' : '' }}">
                    <label for="name1B" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1B" type="text" class="form-control" name="name1B" value="{{ old('name1B') }}" >
                        @if ($errors->has('name1B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1B') ? ' has-error' : '' }}">
                    <label for="posicion1B" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1B" type="text" class="form-control" name="posicion1B" value="{{ old('posicion1B') }}" >
                        @if ($errors->has('posicion1B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1B') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name2B') ? ' has-error' : '' }}">
                    <label for="name2B" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name2B" type="text" class="form-control" name="name2B" value="{{ old('name2B') }}" >
                        @if ($errors->has('name2B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name2B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion2B') ? ' has-error' : '' }}">
                    <label for="posicion2B" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion2B" type="text" class="form-control" name="posicion2B" value="{{ old('posicion2B') }}" >
                        @if ($errors->has('posicion2B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion2B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div id = "tresFirmantes" style="display:none">
            <div class="form-group{{ $errors->has('texto3') ? ' has-error' : '' }}">
                    <label for="text3" class="col-md-4 control-label">Texto Intermedio: </label>
                    <div class="col-md-6">
                                <select id="texto3" class="form-control" name="texto3" value="{{ old('texto3')}}" onchange="determinarTexto()">
                                    <option value="por haber acreditado el ">por haber acreditado el <<i>tipo de curso</i>></option>
                                    <option value="por haber asistido al ">por haber asistido al <<i>tipo de curso</i>></option>
                                    <option value="por haber sido parte del ">por haber sido parte del <<i>tipo de curso</i>></option>
                                    <option value="D">Personalizado</option>

                                </select>
                                @if ($errors->has('text3'))
                            <span class="help-block">
                                <strong>{{ $errors->first('text3') }}</strong>
                            </span>
                        @endif

                        <div id="textoPersonalizado3" style="display:none">

                            <div class="form-group{{ $errors->has('texto3P') ? ' has-error' : '' }}">
                                <input id="texto3P" type="text" class="form-control" name="texto3P" value="{{ old('texto3P') }}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name1C') ? ' has-error' : '' }}">
                    <label for="name1C" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1C" type="text" class="form-control" name="name1C" value="{{ old('name1C') }}" >
                        @if ($errors->has('name1C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1C') ? ' has-error' : '' }}">
                    <label for="posicion1C" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1C" type="text" class="form-control" name="posicion1C" value="{{ old('posicion1C') }}" >
                        @if ($errors->has('posicion1C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1C') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name2C') ? ' has-error' : '' }}">
                    <label for="name2C" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name2C" type="text" class="form-control" name="name2C" value="{{ old('name2C') }}" >
                        @if ($errors->has('name2C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name2C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion2C') ? ' has-error' : '' }}">
                    <label for="posicion2C" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion2C" type="text" class="form-control" name="posicion2C" value="{{ old('posicion2C') }}" >
                        @if ($errors->has('posicion2C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion2C') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name3C') ? ' has-error' : '' }}">
                    <label for="name3C" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name3C" type="text" class="form-control" name="name3C" value="{{ old('name3C') }}" >
                        @if ($errors->has('name3C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name3C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion3C') ? ' has-error' : '' }}">
                    <label for="posicion3C" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion3C" type="text" class="form-control" name="posicion3C" value="{{ old('posicion3C') }}" >
                        @if ($errors->has('posicion3C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion3C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

<div id = "cuatroFirmantes" style="display:none">
<div class="form-group{{ $errors->has('texto4') ? ' has-error' : '' }}">
                    <label for="text4" class="col-md-4 control-label">Texto Intermedio: </label>
                    <div class="col-md-6">
                                <select id="texto4" class="form-control" name="texto4" value="{{ old('texto4')}}" onchange="determinarTexto()">
                                    <option value="por haber acreditado el ">por haber acreditado el <<i>tipo de curso</i>></option>
                                    <option value="por haber asistido al ">por haber asistido al <<i>tipo de curso</i>></option>
                                    <option value="por haber sido parte del ">por haber sido parte del <<i>tipo de curso</i>></option>
                                    <option value="D">Personalizado</option>

                                </select>
                                @if ($errors->has('text4'))
                            <span class="help-block">
                                <strong>{{ $errors->first('text4') }}</strong>
                            </span>
                        @endif

                        <div id="textoPersonalizado4" style="display:none">

                            <div class="form-group{{ $errors->has('texto4P') ? ' has-error' : '' }}">
                                <input id="texto4P" type="text" class="form-control" name="texto4P" value="{{ old('texto4P') }}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name1D') ? ' has-error' : '' }}">
                    <label for="name1D" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1D" type="text" class="form-control" name="name1D" value="{{ old('name1D') }}" >
                        @if ($errors->has('name1D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1D') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1D') ? ' has-error' : '' }}">
                    <label for="posicion1D" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1D" type="text" class="form-control" name="posicion1D" value="{{ old('posicion1D') }}" >
                        @if ($errors->has('posicion1D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1D') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name2D') ? ' has-error' : '' }}">
                    <label for="name2D" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name2D" type="text" class="form-control" name="name2D" value="{{ old('name2D') }}" >
                        @if ($errors->has('name2D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name2D') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion2D') ? ' has-error' : '' }}">
                    <label for="posicion2D" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion2D" type="text" class="form-control" name="posicion2D" value="{{ old('posicion2D') }}" >
                        @if ($errors->has('posicion2D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion2D') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name3D') ? ' has-error' : '' }}">
                    <label for="name3D" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name3D" type="text" class="form-control" name="name3D" value="{{ old('name3D') }}" >
                        @if ($errors->has('name3D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name3D') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion3D') ? ' has-error' : '' }}">
                    <label for="posicion3D" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion3D" type="text" class="form-control" name="posicion3D" value="{{ old('posicion3D') }}" >
                        @if ($errors->has('posicion3D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion3D') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name4D') ? ' has-error' : '' }}">
                    <label for="name4D" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name4D" type="text" class="form-control" name="name4D" value="{{ old('name4D') }}" >
                        @if ($errors->has('name4D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name4D') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion4D') ? ' has-error' : '' }}">
                    <label for="posicion4D" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion4D" type="text" class="form-control" name="posicion4D" value="{{ old('posicion4D') }}" >
                        @if ($errors->has('posicion4D'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion4D') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>


            <div id = "cincoFirmantes" style="display:none">
            <div class="form-group{{ $errors->has('texto5') ? ' has-error' : '' }}">
                    <label for="text5" class="col-md-4 control-label">Texto Intermedio: </label>
                    <div class="col-md-6">
                                <select id="texto5" class="form-control" name="texto5" value="{{ old('texto5')}}" onchange="determinarTexto()">
                                    <option value="por haber acreditado el ">por haber acreditado el <<i>tipo de curso</i>></option>
                                    <option value="por haber asistido al ">por haber asistido al <<i>tipo de curso</i>></option>
                                    <option value="por haber sido parte del ">por haber sido parte del <<i>tipo de curso</i>></option>
                                    <option value="D">Personalizado</option>

                                </select>
                                @if ($errors->has('text5'))
                            <span class="help-block">
                                <strong>{{ $errors->first('text5') }}</strong>
                            </span>
                        @endif

                        <div id="textoPersonalizado5" style="display:none">

                            <div class="form-group{{ $errors->has('texto5P') ? ' has-error' : '' }}">
                                <input id="texto5P" type="text" class="form-control" name="texto5P" value="{{ old('texto5P') }}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name1E') ? ' has-error' : '' }}">
                    <label for="name1E" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1E" type="text" class="form-control" name="name1E" value="{{ old('name1E') }}" >
                        @if ($errors->has('name1E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1E') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1E') ? ' has-error' : '' }}">
                    <label for="posicion1E" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1E" type="text" class="form-control" name="posicion1E" value="{{ old('posicion1E') }}" >
                        @if ($errors->has('posicion1E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1E') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name2E') ? ' has-error' : '' }}">
                    <label for="name2E" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name2E" type="text" class="form-control" name="name2E" value="{{ old('name2E') }}" >
                        @if ($errors->has('name2E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name2E') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion2E') ? ' has-error' : '' }}">
                    <label for="posicion2E" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion2E" type="text" class="form-control" name="posicion2E" value="{{ old('posicion2E') }}" >
                        @if ($errors->has('posicion2E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion2E') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name3E') ? ' has-error' : '' }}">
                    <label for="name3E" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name3E" type="text" class="form-control" name="name3E" value="{{ old('name3E') }}" >
                        @if ($errors->has('name3E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name3E') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion3E') ? ' has-error' : '' }}">
                    <label for="posicion3E" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion3E" type="text" class="form-control" name="posicion3E" value="{{ old('posicion3E') }}" >
                        @if ($errors->has('posicion3E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion3E') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name4E') ? ' has-error' : '' }}">
                    <label for="name4E" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name4E" type="text" class="form-control" name="name4E" value="{{ old('name4E') }}" >
                        @if ($errors->has('name4E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name4E') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion4E') ? ' has-error' : '' }}">
                    <label for="posicion4E" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion4E" type="text" class="form-control" name="posicion4E" value="{{ old('posicion4E') }}" >
                        @if ($errors->has('posicion4E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion4E') }}</strong>
                            </span>
                        @endif
                        <br>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name5E') ? ' has-error' : '' }}">
                    <label for="name5E" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name5E" type="text" class="form-control" name="name5E" value="{{ old('name5E') }}" >
                        @if ($errors->has('name5E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name5E') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion5E') ? ' has-error' : '' }}">
                    <label for="posicion5E" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion5E" type="text" class="form-control" name="posicion5E" value="{{ old('posicion5E') }}" >
                        @if ($errors->has('posicion5E'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion5E') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

    <br>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">Generar</button>
    </div>
</form>

      </div>

     </section>


    <script type="text/javascript">

        function determinarTexto(){
            var a = document.getElementById("texto1");
            var b = document.getElementById("texto2");
            var valueA = a.options[a.selectedIndex].value;
            var valueB = b.options[b.selectedIndex].value;
          var textoPersonalizado1 = document.getElementById("textoPersonalizado1");
          var textoPersonalizado2 = document.getElementById("textoPersonalizado2");


          if(valueA == "D"){
            textoPersonalizado1.style.display = "block";
          }else{
            textoPersonalizado1.style.display = "none";

          }

          if(valueB == "D"){
            textoPersonalizado2.style.display = "block";
          }else{
            textoPersonalizado2.style.display = "none";

          }
        }

      function determinarFirmantes(){
          
          var e = document.getElementById("type");
          var strE = e.options[e.selectedIndex].text;
          console.log(strE);
          var divUnFirmante = document.getElementById("unFirmante");
          var divDosFirmantes = document.getElementById("dosFirmantes");
          var divTresFirmantes = document.getElementById("tresFirmantes");
          var divCuatroFirmantes = document.getElementById("cuatroFirmantes");
          var divCincoFirmantes = document.getElementById("cincoFirmantes");
          var divUNICA = document.getElementById("generacion");
          var divNombe = document.getElementById("nombre");
          var divCargo = document.getElementById("cargo");



          if(strE == "Un firmante"){
              divUnFirmante.style.display = "block";
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
              divUNICA.style.display = "none"
          }else if(strE == "Dos firmantes"){
              divDosFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
              divUNICA.style.display = "none"
          }else if(strE == "Tres firmantes"){
              divTresFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
              divUNICA.style.display = "none"
          }else if(strE == "Cuatro firmantes"){
              divCuatroFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
              divUNICA.style.display = "none"
          }else if(strE == "Cinco firmantes"){
              divCincoFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divUNICA.style.display = "none"
          }else if(strE == "UNICA"){
            divUnFirmante.style.display = "none"
            divDosFirmantes.style.display = "none"
            divTresFirmantes.style.display = "none"
            divCuatroFirmantes.style.display = "none"
            divCincoFirmantes.style.display = "none"
            divUNICA.style.display = "block"
            divNombre.style.display = "none"
            divCargo.style.display = "none"
          }else{
            divUnFirmante.style.display = "none"
            divDosFirmantes.style.display = "none"
            divTresFirmantes.style.display = "none"
            divCuatroFirmantes.style.display = "none"
            divCincoFirmantes.style.display = "none"
            divUNICA.style.display = "none"
          }
      }


    </script>


@endsection
