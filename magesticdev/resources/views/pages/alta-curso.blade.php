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
    @if(session()->has('create'))
      <div class="alert alert-success" role='alert'>{{session('create')}}</div>
    @endif
    <br>
      <div class="panel panel-default">
                <div class="panel-heading">

                    <h3>Alta Curso para catálogo</h3>
                    <h4>{{$user->nombre_curso}}</h4>
                </div>
        </div>
                <div class="panel-body">
                    <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('curso.store') }}">
                        {{ csrf_field() }}


                         <div class="form-group{{ $errors->has('semestre_imparticion') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Periodo:</label>

                            <div class="col-md-3">
                                <input id="semestreAnio" type="text" class="form-control" name="semestreAnio" value="{{ old('semestreAnio') }}" minlength="4" maxlength= "4" required>

                                @if ($errors->has('semestreAnio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('semestreAnio') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <select name="semestreTemporada"  form="cursoform" class="form-control">
                                    <option value="1"> 1 </option>
                                    <option value="2"> 2 </option>
                                </select>
                                @if ($errors->has('semestreTemporada'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('semestreTemporada') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <select name="semestreInter"  form="cursoform" class="form-control">
                                    <option value="i">Intersemestral </option>
                                    <option value="s">Semestral </option>
                                </select>
                                @if ($errors->has('semestreInter'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('semestreInter') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                         <div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Fecha de inicio:</label>

                            <div class="col-md-6">
                                <input id="fecha_inicio" placeholder="MM/DD/AA" type="date" class="form-control" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>

                                @if ($errors->has('fecha_inicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha_inicio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('fecha_fin') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Fecha de fin: </label>

                            <div class="col-md-6">
                                <input placeholder="MM/DD/AA" id="fecha_fin" type="date" class="form-control" name="fecha_fin" value="{{ old('fecha_fin') }}" required>

                                @if ($errors->has('fecha_fin'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha_fin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('hora_inicio') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Hora de inicio:</label>

                            <div class="col-md-3">

                                <input id="hora_inicio" type="time" class="form-control" name="hora_inicio" value="{{ old('hora_inicio') }}" required>

                                @if ($errors->has('hora_inicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hora_inicio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('hora_fin') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Hora de fin:</label>

                            <div class="col-md-3">

                                <input id="hora_fin" type="time" class="form-control" name="hora_fin" value="{{ old('hora_fin') }}" required>

                                @if ($errors->has('hora_fin'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hora_fin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('dias_semana') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Días a la semana:</label>

                            <div class="col-md-6">
                                <table align='center' width="100%">
                                    <tr>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miércoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                        <th>Sábado</th>
                                    </tr>
                                    <tr>
                                        <td width="15%">
                                            <input type="checkbox" name="L" id="dias_L" onclick="dia_sel()">
                                        </td>
                                        <td width="15%">
                                            <input type="checkbox" name="M" id="dias_M" onclick="dia_sel()">
                                        </td>
                                        <td width="15%">
                                            <input type="checkbox" name="X" id="dias_X" onclick="dia_sel()">
                                        </td>
                                        <td width="15%">
                                            <input type="checkbox" name="J" id="dias_J" onclick="dia_sel()">
                                        </td>
                                        <td width="15%">
                                            <input type="checkbox" name="V" id="dias_V" onclick="dia_sel()">
                                        </td>
                                        <td width="15%">
                                            <input type="checkbox" name="S" id="dias_S" onclick="dia_sel()">
                                        </td>
                                    </tr>
                                </table>
                                <!--Modificaciones Carlos -->

                                <p1 style="color: red;"> *Recuerde que la fecha de fin debe coincidir con el día de la semana seleccionado </p1>

                                @if ($errors->has('dias_semana'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dias_semana') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('numero_sesiones') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Número de sesiones:</label>

                            <div class="col-md-6">
                                <input id="numero_sesiones" type="number" min="1" class="form-control" name="numero_sesiones" value="{{ old('numero_sesiones') }}" required>

                                @if ($errors->has('numero_sesiones'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numero_sesiones') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('acreditacion') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Acreditación:</label>

                            <div class="col-md-6">
                                <input id="acreditacion" type="number" min="1" class="form-control" name="acreditacion" value="{{ old('acreditacion') }}" required>

                                @if ($errors->has('acreditacion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('acreditacion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('costo') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Costo</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input id="costo" type="number" min="0" class="form-control" name="costo" step='0.01' value="{{ old('costo') }}" required>
                                </div>
                                @if ($errors->has('costo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('costo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cupo_maximo') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Cupo máximo:</label>
                            <div class="col-md-6">
                                <input id="cupo_maximo" type="number" min =1 class="form-control" name="cupo_maximo" value="{{ old('cupo_maximo') }}" required>

                                @if ($errors->has('cupo_maximo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cupo_maximo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cupo_minimo') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Cupo mínimo:</label>

                            <div class="col-md-6">
                                <input id="cupo_minimo" type="number" min="1" class="form-control" name="cupo_minimo" value="{{ old('cupo_minimo') }}" required>

                                @if ($errors->has('cupo_minimo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cupo_minimo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
<!--
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Estado del curso</label>
                            <div class="col-md-6">
                                <select name="status"  form="cursoform" class="form-control">
                                    <option value="Activo">Activo </option>
                                    <option value="Inactivo">Inactivo </option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->

                        <input id="catalogo_id" type="hidden" class="form-control" name="catalogo_id" value="{{ $user->id}}" required>

                        <div class="form-group{{ $errors->has('salon_id') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Sede:</label>

                            <div class="col-md-6">
                                <select name="salon_id" form="cursoform" class="form-control">
                                @foreach($salones as $salon)

                                    <option value="{{ $salon->id }} "> {{ $salon->sede}} </option>

                                @endforeach
                                </select>
                                @if ($errors->has('salon_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('salon_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button disabled type="submit" class="btn btn-primary" id="boton" onclick="validador()">
                                    Crear
                                </button>
                                @if($user->tipo === 'S')
                                <p1 style="color: red;"> *El curso es un seminario, recuerde que después de añadir instructores es necesario asignarlos a sus temas</p1>
                                @endif
                            </div>

                        </div>
                    </form>
      </div>

      <script>
            //Función que compara fechas
            function Compare_date(start_date,end_date){
                if(start_date > end_date){
                    return true;
                }else{
                    return false;
                }
            }

            //Función que compara horas
            function Compare_time(start_time,end_time){

            }
            // Si Compare_Date()
            //    Si Compare_time()
            //       submit
            //    Si no ERROR TIEMPO
            //  Si no ERROR FECHA
            function dia_sel(){
                document.getElementById('boton').disabled=false;
            }
            function validador(argument) {
                
            }
      </script>

     </section>

@endsection
