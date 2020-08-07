<!-- Guardado en resources/views/pages/admin.blade.php -->

@extends('layouts.principal')

@section('contenido')


    <script>
        var id_fac = 50;
        var carreras = [];
        var facultades = [];
        var test = [];
        var i = 0;
        window.onload =  initial;
        @for($i = 0; $i<sizeof($carreras); $i++)
            carreras[{{$i}}] = {
            id: {{ $carreras[$i]->id}},
            nombre: "{{ $carreras[$i]->nombre}}",
            id_facultad: {{ $carreras[$i]->id_facultad}}
        }
        @endfor
                @for($i = 0; $i<sizeof($facultades); $i++)
            facultades[{{$i}}] = {
            id: {{ $facultades[$i]->id}},
            nombre: "{{ $facultades[$i]->nombre}}"
        }
        @endfor
        function initial(){
            rfc_check();
        }
        function externo() {
            document.getElementById("externo").style.display = "initial";
            document.getElementById("facultad").style.display = "none";
            document.getElementById("carreras").style.display = "none";
        }
        function interno() {
            document.getElementById("externo").style.display = "none";
            document.getElementById("facultad").style.display = "initial";
            document.getElementById("carreras").style.display = "none";
            changeFunc();
        }
        function rfc_check(){
            var con_n = document.getElementById("rfc1_n");
            var con_v = document.getElementById("rfc1_v");
            var sin_n = document.getElementById("rfc2_n")
            var sin_v = document.getElementById("rfc2_v");
            var radioCon = document.getElementById("radioCon");
            var radioSin = document.getElementById("radioSin");
           
            if(radioCon.checked == true && radioSin.checked == false){
                con_n.style.display = "initial";
                con_v.style.display = "block";
                sin_n.style.display = "none";
                sin_v.style.display = "none";
                con_v.setAttribute("required", "");
                sin_v.removeAttribute("required");
            

            }
            else if(radioCon.checked == false && radioSin.checked == true){
                sin_n.style.display = "initial";
                sin_v.style.display = "block";
                con_n.style.display = "none";
                con_v.style.display = "none";
                sin_v.setAttribute("required", "");
                con_v.removeAttribute("required"); 
            
            }
            else{
                
                con_n.style.display = "none";
                con_v.style.display = "none";
                sin_n.style.display = "none";
                sin_v.style.display = "none";
            }
        }
        function showCarreras() {
            document.getElementById("carreras").style.display = "initial";
        }
        function changeFunc() {
            showCarreras();
            var selectBox = document.getElementById("facultad_option");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            id_fac = selectedValue;
            getSelectedValue();
        }
        function getSelectedValue(){
            var content = "";
            var opcion = "";
            for(i=0; i<carreras.length; i++){
                if(id_fac==carreras[i].id_facultad){
                    opcion="<option value=\"" +carreras[i].id +"\"\>"+carreras[i].nombre+"</option>\n";
                    content=content+opcion;
                }
            }
            document.getElementById("carrera_option").innerHTML = content;
        }
    </script>

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
       @if(session()->has('D'))
        <div class="alert alert-danger" role='alert'>{{session('msj')}}</div>
       @else
        <div class="alert alert-success" role='alert'>{{session('msj')}}</div>
       @endif
     @endif

        <br>
        <div class="panel panel-default">
        @include ('partials.messages')
            <div class="panel-heading">
                <h3>Alta de profesor</h3>
                <h4>Coordinación de Gestión y Vinculación</h4>
            </div>
        </div>
        <div class="panel-body">

            <form class="form-horizontal" method="POST" action="{{ route('profesor.store') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
                    <label for="nombres" class="col-md-4 control-label">Nombre</label>
                    <div class="col-md-6">
                        <input id="nombres" type="text" class="form-control" name="nombres" value="{{ old('nombres') }}"  required oninvalid="this.setCustomValidity('Ingrese un nombre por favor')" oninput="this.setCustomValidity('')">
                        @if ($errors->has('nombres'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nombres') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('apellido_paterno') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Apellido Paterno</label>
                    <div class="col-md-6">
                        <input id="apellido_paterno" type="text" class="form-control" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required oninvalid="this.setCustomValidity('Ingrese un apellido por favor')" oninput="this.setCustomValidity('')">
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
                        <input id="apellido_materno" type="text" class="form-control" name="apellido_materno" value="{{ old('apellido_materno') }}" >
                        @if ($errors->has('apellido_materno'))
                            <span class="help-block">
                                <strong>{{ $errors->first('apellido_materno') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('rfc') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">RFC</label>
                    <div class="col-md-6">

                        Con Homoclave <input name="grupoRFC"  id="radioCon" value="a" onclick="rfc_check()" class="col-md-1 control-label" type="radio">
                        <br>
                        Sin Homoclave <input name="grupoRFC"  id="radioSin" value="b" onclick="rfc_check()" class="col-md-1 control-label" type="radio" required>
                        @if ($errors->has('rfc'))
                            <span class="help-block">
                                <strong>{{ $errors->first('rfc') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group col-md-4" style="text-align:right; margin-right:1px">
                    {!!Form::label("rfc1_n", "RFC con homoclave:", ["id" =>"rfc1_n"])!!}
                </div>
                <div class="form-group col-md-6">
                    {!!Form::text("rfc1_v", null, [ "name"=>"rfc1","id" => "rfc1_v", 'maxlength' => 13, "class" => "form-control", "placeholder" => "RFC"])!!}
                </div>
                <div class="form-group col-md-4" style="text-align:right; margin-right:1px">
                    {!!Form::label("rfc2_n", "RFC sin homoclave:", ["id" =>"rfc2_n"])!!}
                </div>
                <div class="form-group col-md-6">
                    {!!Form::text("rfc2_v", null, [ "name"=>"rfc2","id" => "rfc2_v", "class" => "form-control", 'maxlength' => 10, "placeholder" => "RFC"])!!}
                </div>
            <div class="form-group{{ $errors->has('numero_trabajador') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Número de Trabajador</label>
                    <div class="col-md-6">
                        <input id="numero_trabajador" type="text" class="form-control" name="numero_trabajador" value="{{ old('numero_trabajador') }}" required>
                        @if ($errors->has('numero_trabajador'))
                            <span class="help-block">
                                <strong>{{ $errors->first('numero_trabajador') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('curp') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">CURP</label>
                    <div class="col-md-6">
                        <input minlength="18" maxlength= "18" id="curp" type="text" class="form-control" name="curp" value="{{ old('curp') }}" required oninvalid="this.setCustomValidity('Ingrese su CURP por favor')" oninput="this.setCustomValidity('')">
                        @if ($errors->has('curp'))
                            <span class="help-block">
                                <strong>{{ $errors->first('curp') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('categoria_nivel_id') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Categoria y nivel:</label>
                    <div class="col-md-6">
                        <select name="categoria_nivel_id" class="btn dropdown-toggle pull-left">
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }} ">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('coordinacion_id'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('coordinacion_id') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Fecha de nacimiento</label>
                    <div class="col-md-6">
                        <input id="fecha_nacimiento" type="date" class="form-control" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required oninvalid="this.setCustomValidity('Ingrese una fecha por favor')" oninput="this.setCustomValidity('')">
                        @if ($errors->has('fecha_nacimiento'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Telefono</label>
                    <div class="col-md-6">
                        <input id="telefono" type="text" class="form-control" name="telefono" value="{{ old('telefono') }}">
                        @if ($errors->has('telefono'))
                            <span class="help-block">
                                <strong>{{ $errors->first('telefono') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('grado') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Grado</label>

                    <select name="grado" class="btn dropdown-toggle pull-left">
                        <option  value="Licenciatura">Licenciatura</option>
                        <option  value="Licenciatura">Ingeniería</option>
                        <option  value="Maestria">Maestria</option>
                        <option  value="Doctorado">Doctorado</option>
                    </select>

                    @if ($errors->has('grado'))
                        <span class="help-block">
                            <strong>{{ $errors->first('grado') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required oninvalid="this.setCustomValidity('Ingrese su email por favor')" oninput="this.setCustomValidity('')">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Genero</label>
                    <div class="col-md-6">
                        Femenino: <input type="radio" name="genero" value="femenino" >
                        Masculino: <input type="radio" name="genero" value="masculino" >
                        @if ($errors->has('genero'))
                            <span class="help-block">
                                <strong>{{ $errors->first('genero') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('semblanza_corta') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Semblanza Corta</label>
                    <div class="col-md-6">
                        <input id="semblanza_corta" type="text" class="form-control" name="semblanza_corta" value="{{ old('semblanza_corta') }}" >
                        @if ($errors->has('semblanza_corta'))
                            <span class="help-block">
                                <strong>{{ $errors->first('semblanza_corta') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Facebook</label>
                    <div class="col-md-6">
                        <input id="facebook" type="text" class="form-control" name="facebook" value="{{ old('facebook') }}" >
                        @if ($errors->has('facebook'))
                            <span class="help-block">
                                <strong>{{ $errors->first('facebook') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('comentarios') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Comentarios</label>
                    <div class="col-md-6">
                        <input id="comentarios" type="text" class="form-control" name="comentarios" value="{{ old('comentarios') }}" >
                        @if ($errors->has('comentarios'))
                            <span class="help-block">
                                <strong>{{ $errors->first('comentarios') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('unam') ? ' has-error' : '' }}">
                    <label for="unam" class="col-md-4 control-label">Profesor de la UNAM </label>
                    <div class="col-md-6">

                        Si: <input  onclick="interno()" id="unam_si" type="radio" class="" name="unam" value='1' >
                        No:  <input id="unam_no" onclick="externo()"   type="radio" class="" name="unam" value='0' >
                        @if ($errors->has('unam'))
                            <span class="help-block">
                                <strong>{{ $errors->first('unam') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div style="display:none;" id="externo" class="form-group{{ $errors->has('procedencia') ? ' has-error' : '' }}">
                    <label for="procedencia" class="col-md-4 control-label">Procedencia</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="procedencia" value="{{ old('procedencia') }}" >
                        @if ($errors->has('procedencia'))
                            <span class="help-block">
                                <strong>{{ $errors->first('procedencia') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div style="display:none;" id="facultad" class="form-group{{ $errors->has('facultad_id') ? ' has-error' : '' }}">
                <div class="col-md-4" style="text-align:right; margin-right:1px">
                    {!!Form::label("facultad", "Facultad:", ["id" =>"facultad_n"])!!}
                </div>
                    <div class="col-md-6">
                    <select id="facultad_option" onchange="changeFunc();" name="facultad_id" class="form-control">
                    @foreach($facultades as $fac)
                        <option  value="{{ $fac->id }} "> {{ $fac->nombre }} </option>
                    @endforeach
                  </select>
                        @if ($errors->has('facultad_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('facultad_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div id="carreras" style="display:none;" class="form-group{{ $errors->has('carrera_id') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Carrera</label>
                    <div class="col-md-6">
                        <select  id="carrera_option" name="carrera_id" class="form-control">
                        @for($i = 0; $i<sizeof($carreras); $i++)
                            <option value="{{$carreras[$i]->id }}"> {{$carreras[$i]->nombre}}  </option>
                        @endfor
                        </select>

                        @if ($errors->has('carrera_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('carrera_id') }}</strong>
                            </span>
                        @endif
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
