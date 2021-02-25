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
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        @if(session()->has('msj'))
            <div class="alert alert-success" role='alert'>{{session('msj')}}</div>
        @endif
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Alta Catálogo de cursos</h3>
                <h4>Coordinación de Gestión y Vinculación</h4>
            </div>
            <div class="panel-body">

                <form id="catalogocursoform" class="form-horizontal" method="POST" action="{{ route('catalogo-cursos.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('clave_curso') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Clave:</label>

                        <div class="col-md-6 col-sm-3">
                            <input id="clave_curso" type="text" class="form-control" name="clave_curso" value="{{ old('clave_curso') }}" maxlength="8" required oninvalid="this.setCustomValidity('Ingrese la clave por favor')" oninput="this.setCustomValidity('')">

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
                                <select onchange="cantidadtemas()" id="tipo" class="form-control" name="tipo" value="{{ old('tipo')}}">
                                    <option value="T">Taller </option>
                                    <option value="C">Curso </option>
                                    <option value="F">Foro </option>
                                    <option value="S">Seminario </option>
                                    <option value="E">Evento </option>
                                    <option value="CT">Curso-Taller</option>
                                    <option value="D">Módulo de diplomado</option>
                                </select>
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>

                    <div id=NumTemas style="display:none" class="form-group{{ $errors->has('presentacion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Número de Temas: </label>
                        <div class="col-md-6">
                            <input type="number"  class="form-control" name="temas" min=1 value="{{ old('temas') }}">
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('institucion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Institución:</label>

                        <div class="col-md-6">
                                <select id="institucion" class="form-control" name="institucion" value="{{ old('institucion')}}">
                                    <option value="DGAPA">DGAPA</option>
                                    <option value="CD">Centro de Docencia</option>
                                </select>
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>
                    

                    <div class="form-group{{ $errors->has('presentacion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Semblanza: </label>

                        <div class="col-md-6">
                            <input id="presentacion" type="text"  class="form-control" name="presentacion" value="{{ old('presentacion') }}">

                            @if ($errors->has('presentacion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('presentacion') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('dirigido') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Dirigido:</label>

                        <div class="col-md-6">
                            <textarea rows="4" cols="50" id="dirigido" type="text" class="form-control" name="dirigido" value="{{ old('dirigido') }}">@if ($errors->has('dirigido'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dirigido') }}</strong>
                                    </span>
                            @endif</textarea>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('objetivo') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Objetivo:</label>

                        <div class="col-md-6">
                            <textarea rows="4" cols="50" id="objetivo" type="text" class="form-control" name="objetivo" value="{{ old('objetivo') }}">@if ($errors->has('objetivo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('objetivo') }}</strong>
                                    </span>
                            @endif</textarea>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('contenido') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Contenidos (Iniciando y separando por guiones):</label>
                        <div class="col-md-6">
                                <input rows="4" cols="50" id="contenido" type="text" placeholder="-Contenido1-Contenido2-Contenido3" class="form-control" name="contenido" value="{{ old('contenido') }}">
                                @if ($errors->has('contenido'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('contenido') }}</strong>
                                </span>
                                
                            @endif
                            </input>
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('acreditacion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Acreditación:</label>

                        <div class="col-md-6">
                            <textarea rows="4" cols="50" id="acreditacion" type="text" class="form-control" name="acreditacion" value="{{ old('acreditacion') }}">@if ($errors->has('acreditacion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('acreditacion') }}</strong>
                                    </span>
                            @endif</textarea>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('evaluacion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Evaluación:</label>

                        <div class="col-md-6">
                            <textarea rows="4" cols="50" id="acreditacion" type="text" class="form-control" name="evaluacion" value="{{ old('evaluacion') }}">@if ($errors->has('evaluacion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('evaluacion') }}</strong>
                                    </span>
                            @endif</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('fecha_disenio') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Fecha de diseño:</label>

                        <div class="col-md-6">
                            <input id="fecha_disenio" type="date"  class="form-control" name="fecha_disenio" value="{{ old('fecha_disenio') }}" required oninvalid="this.setCustomValidity('Ingrese una fecha de diseño por favor entre 01/01/2010 y 30/12/2030')" oninput="this.setCustomValidity('')" min="2010-01-01" max="2030-12-30">

                            @if ($errors->has('fecha_disenio'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('fecha_disenio') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('antescedente_id') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Antecedentes:</label>
                        <div class="col-md-6">
                            <select onchange="deter()" id='antescedente_id' class="form-control" multiple="multiple" name="antescedente_id[]" value="{{ old('antescedente_id')}}>
                            @foreach($catalogo_cursos as $catalogo_curso)
                                <option value="{{ $catalogo_curso->id }} ">{{ $catalogo_curso->nombre_curso }} ({{ $catalogo_curso->clave_curso }})</option>
                                    $antescedente_id = $request->input('antescedente_id');
                            @endforeach
                                <option id="Otros" value="Otros">Otros</option>
                            </select>
                            @if ($errors->has('antescedente_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('antescedente_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div id="E1" class="form-group{{ $errors->has('antesE') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Otros Antecedentes:</label>
                        <div class="col-md-6">
                            <textarea rows="4" cols="50" type="text" class="form-control" name="antesc"></textarea>
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
        <script type="text/javascript">
            function selectCheck() {
                    
                    document.getElementById('E1').style.display = 'block';
            }
            function esconder() {
                    
                    document.getElementById('E1').style.display = 'none';
            }
            function deter(){
              if(document.getElementById("Otros").selected){
                  selectCheck();
              }else{
                  esconder();
              }
            }
            function cantidadtemas(){
                var tipo;
                tipo = document.getElementById("tipo").value;
                if (tipo == "S"){
                    document.getElementById('NumTemas').style.display = 'block';
                }
                else{
                    document.getElementById('NumTemas').style.display = 'none';
                }
            }
              esconder();
        </script>
    </section>

@endsection

