@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<script src="http://yui.yahooapis.com/3.18.1/build/yui/yui-min.js"></script>
<div class="content">
  <div class="top-bar">
    <a href="#menu" class="side-menu-link burger">
      <span class='burger_inside' id='bgrOne'></span>
      <span class='burger_inside' id='bgrTwo'></span>
      <span class='burger_inside' id='bgrThree'></span>
    </a>
  </div>
  <section class="content-inner">
    @include ('partials.messages')
    <br>
    <div class="panel panel-default">
      <div class="panel-heading">
          <h3>Alta Módulo</h3>
          <h4>{{$catalogo->nombre_curso}}</h4>
      </div>
    </div>
    <div class="panel-body">
      <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('modulo.store', $catalogo->id) }}">
      {{ csrf_field() }}
        <div class="form-group{{ $errors->has('semestre_imparticion') ? ' has-error' : '' }}">
          <label for="name" class="col-md-3 control-label">Periodo:</label>
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
          <label for="name" class="col-md-3 control-label">Fecha de inicio:</label>
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
            <label for="name" class="col-md-3 control-label">Fecha de fin: </label>
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
          <label for="name" class="col-md-3 control-label">Hora de inicio:</label>
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
          <label for="name" class="col-md-3 control-label">Hora de fin:</label>
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
          <label for="name" class="col-md-3 control-label">Días a la semana:</label>
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
            <p1 style="color: red;"> *Recuerde que la fecha de fin debe coincidir con el día de la semana seleccionado </p1>
            @if ($errors->has('dias_semana'))
              <span class="help-block">
                <strong>{{ $errors->first('dias_semana') }}</strong>
              </span>
            @endif
          </div>
        </div>
        <div class="form-group{{ $errors->has('numero_sesiones') ? ' has-error' : '' }}">
          <label for="name" class="col-md-3 control-label">Número de sesiones:</label>
          <div class="col-md-6">
            <input id="numero_sesiones" type="number" min="1" class="form-control" name="numero_sesiones" value="{{ old('numero_sesiones') }}" required>
            @if ($errors->has('numero_sesiones'))
              <span class="help-block">
                <strong>{{ $errors->first('numero_sesiones') }}</strong>
              </span>
            @endif
          </div>
        </div>


        <div class="form-group">
            <input id="sesiones" type="hidden" class="form-control" name="sesiones" value="-1" required>
            <label for="name" class="col-md-3 control-label">Sesiones:</label>
            <div class="col-md-9 row">
                <div class="col-md-12">
                    <div id="demo" class="yui3-skin-sam yui3-g">
                        <div id="leftcolumn" class="yui3-u">
                           <!-- Container for the calendar -->
                           <div id="mycalendar"></div>
                        </div>
                        <div id="rightcolumn" class="yui3-u">
                         <div id="links" style="padding-left:10px;">
                            Dias seleccionados: <span id="selecteddate"></span>
                         </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group{{ $errors->has('acreditacion') ? ' has-error' : '' }}">
          <label for="name" class="col-md-3 control-label">Acreditación:</label>
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
          <label for="name" class="col-md-3 control-label">Costo</label>
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
          <label for="name" class="col-md-3 control-label">Cupo máximo:</label>
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
          <label for="name" class="col-md-3 control-label">Cupo mínimo:</label>
          <div class="col-md-6">
            <input id="cupo_minimo" type="number" min="1" class="form-control" name="cupo_minimo" value="{{ old('cupo_minimo') }}" required>
            @if ($errors->has('cupo_minimo'))
              <span class="help-block">
                  <strong>{{ $errors->first('cupo_minimo') }}</strong>
              </span>
            @endif
          </div>
        </div>
        <div class="form-group{{ $errors->has('salon_id') ? ' has-error' : '' }}">
          <label for="name" class="col-md-3 control-label">Sede:</label>
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
            <label class="col-md-3 control-label">SGC:</label>

            <div class="col-md-6">
                <input type="checkbox" name="SGC" id="SGC" style="border-radius:.12em;height: 24px;width: 24px;">
                <p style="display:inline;font-size: large;vertical-align: super;" onclick="pSGC()"> Sistema de Gestión de Calidad</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <button disabled type="submit" class="btn btn-primary" id="boton" onclick="validador()">
                Crear
              </button>
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

    <script type="text/javascript">
      YUI().use('calendar', 'datatype-date', 'cssbutton',  function(Y) {

          // Create a new instance of calendar, placing it in
          // #mycalendar container, setting its width to 340px,
          // the flags for showing previous and next month's
          // dates in available empty cells to true, and setting
          // the date to today's date.
          var calendar = new Y.Calendar({
            contentBox: "#mycalendar",
            width:'340px',
            showPrevMonth: true,
            showNextMonth: true,
            selectionMode: 'multiple',
            date: new Date()}).render();

          // Get a reference to Y.DataType.Date
          var dtdate = Y.DataType.Date;

          // Listen to calendar's selectionChange event.
          calendar.on("selectionChange", function (ev) {

            // Get the date from the list of selected
            // dates returned with the event (since only
            // single selection is enabled by default,
            // we expect there to be only one date)
            var newDate = ev.newSelection;

            // Format the date and output it to a DOM
            // element.
            var meses = ['<br>\tEnero: ','<br>\tFebrero: ','<br>\tMarzo: ','<br>\tAbril: ','<br>\tMayo: ','<br>\tJunio: ','<br>\tJulio: ','<br>\tAgosto: ','<br>\tSeptiembre: ','<br>\tOctubre: ','<br>\tNoviembre: ','<br>\tDiciembre: '];
            var sesion_inicial = dtdate.format(newDate[0]);
            var anio_actual = sesion_inicial.slice(0,4);
            var mes_actual = sesion_inicial.slice(5,7);
            var fechas = '<br>' + anio_actual + ':' + meses[Number(mes_actual)-1] + sesion_inicial.slice(8);
            for (var i = 1; i < newDate.length; i++) {
                var sesion = dtdate.format(newDate[i]);
                if(sesion.slice(0,4) != anio_actual){
                    fechas += '<br><br>' + sesion.slice(0,4) + ':';
                    anio_actual = sesion.slice(0,4);
                }
                if(sesion.slice(5,7) != mes_actual){
                    fechas += meses[Number(sesion.slice(5,7))-1] + sesion.slice(8);
                    mes_actual = sesion.slice(5,7);
                }else{
                    fechas += ', ' + sesion.slice(8);
                }
            }
            Y.one("#selecteddate").setHTML(fechas);

            for (var i = 0 - 1; i < newDate.length; i++) {
                newDate[i] = dtdate.format(newDate[i]);
            }

            document.getElementById('sesiones').value = newDate;

          });

        var regla_anios = 'all';
        var regla_meses = 'all';
        var regla_dias = 'all';
        var regla_semana = [];
        var rules = {[regla_anios] : {[regla_meses] : {[regla_dias] : {[regla_semana.toString()] : 'reglas', "0,6": "all_weekends"}}}};

        function inicio_fin(){
            var fecha_inicio_anio = document.getElementById('fecha_inicio').value.slice(0,4);
            var fecha_fin_anio = document.getElementById('fecha_fin').value.slice(0,4);
            var fecha_inicio_mes = document.getElementById('fecha_inicio').value.slice(5,7);
            var fecha_fin_mes = document.getElementById('fecha_fin').value.slice(5,7);
            var fecha_inicio_dia = document.getElementById('fecha_inicio').value.slice(8);
            var fecha_fin_dia = document.getElementById('fecha_fin').value.slice(8);

            if(Number(fecha_inicio_anio)>Number(fecha_fin_anio) || (fecha_inicio_anio==fecha_fin_anio && Number(fecha_inicio_mes)>Number(fecha_fin_mes)) || (fecha_inicio_mes==fecha_fin_mes && Number(fecha_inicio_dia)>Number(fecha_fin_dia))){return;}

            if(fecha_inicio_anio!=fecha_fin_anio && fecha_inicio_anio!='' && fecha_fin_anio!=''){
                regla_anios = fecha_inicio_anio + '-' + fecha_fin_anio;
                if (Number(fecha_fin_anio)-Number(fecha_inicio_anio) > 1){
                    regla_meses = 'all';
                }else{
                    regla_meses = (Number(fecha_inicio_mes)-1).toString()
                    for (var i = Number(fecha_inicio_mes); i < 12; i++){
                        regla_meses += ','+i.toString();
                    }
                    for (var i = 0; i < (Number(fecha_fin_mes)-1); i++){
                        regla_meses += ','+i.toString();
                    }
                    regla_meses += ','+(Number(fecha_fin_mes)-1).toString();
                }
                regla_dias = 'all'
            }else{
                if (fecha_inicio_anio!='')
                    regla_anios = fecha_inicio_anio;
                else
                    regla_anios = fecha_fin_anio;

                if(fecha_inicio_mes!=fecha_fin_mes && fecha_inicio_mes!='' && fecha_fin_mes!=''){
                    regla_meses = (Number(fecha_inicio_mes)-1).toString() + '-' + (Number(fecha_fin_mes)-1).toString();
                    regla_dias = 'all'
                }else{
                    if (fecha_inicio_mes!='')
                        regla_meses = (Number(fecha_inicio_mes)-1).toString();
                    else
                        regla_meses = (Number(fecha_fin_mes)-1).toString();

                    if(fecha_inicio_dia!=fecha_fin_dia && fecha_inicio_dia!='' && fecha_fin_dia!=''){
                        regla_dias = Number(fecha_inicio_dia).toString() + '-' + Number(fecha_fin_dia).toString();
                    }else{
                        if (fecha_inicio_dia!='')
                            regla_dias = Number(fecha_inicio_dia).toString();
                        else
                            regla_dias = Number(fecha_fin_dia).toString();
                    }
                }
            }
            //borrar
            //window.alert(regla_anios+': '+regla_meses+': '+regla_dias+': '+regla_semana.toString());
        }

        var filterFunction = function (date, node, rules){if(rules.indexOf("all_weekends")>=0){node.addClass("redtext");}}

        function update_cal(){
            reglas_str = '{"'+[regla_anios]+'": {"';

            if (regla_meses.length > 2 && regla_meses.search('-')>0){
                var fecha_inicio_dia = document.getElementById('fecha_inicio').value.slice(8);
                var fecha_fin_dia = document.getElementById('fecha_fin').value.slice(8);
                reglas_str += [Number(regla_meses.split("-")[0]).toString()]+'": {"'+[Number(fecha_inicio_dia).toString()]+'-31": {"'+[regla_semana.toString()]+'": "reglas"}},"';
                for (var i = Number(regla_meses.split("-")[0])+1; i < Number(regla_meses.split("-")[1]); i++){
                    reglas_str += i.toString()+'": {"'+[regla_dias]+'": {"'+[regla_semana.toString()]+'": "reglas"}},"';
                }
                reglas_str += [Number(regla_meses.split("-")[1]).toString()]+'": {"1-'+[Number(fecha_fin_dia).toString()]+'": {"'+[regla_semana.toString()]+'": "reglas"}}}}';
            }else{
                reglas_str += [regla_meses]+'": {"'+[regla_dias]+'": {"'+[regla_semana.toString()]+'": "reglas", "0,6": "all_weekends"}}}}';
            }
            //borrar
            //window.alert(reglas_str);
            calendar.set("customRenderer", {rules: JSON.parse(reglas_str), filterFunction: filterFunction});
            calendar.set("enabledDatesRule", 'reglas');
            Y.one("#selecteddate").setHTML('');
        }

        Y.one("#fecha_inicio").on('change', function (ev) {
            ev.preventDefault();
            inicio_fin();
            update_cal();
        });

        Y.one("#fecha_fin").on('change', function (ev) {
            ev.preventDefault();
            inicio_fin();
            update_cal();
        });


        var lunes_box = false;
        var martes_box = false;
        var miercoles_box = false;
        var jueves_box = false;
        var viernes_box = false;
        var sabado_box = false;

        Y.one("#dias_L").on('click', function (ev) {
            lunes_box = !lunes_box;
            if (lunes_box){
                regla_semana.push('1');
            }else{
                regla_semana.splice(regla_semana.indexOf('1'), 1);
            }
            update_cal();
            document.getElementById('boton').disabled=false;
        });

        Y.one("#dias_M").on('click', function (ev) {
            martes_box = !martes_box;
            if (martes_box){
                regla_semana.push('2');
            }else{
                regla_semana.splice(regla_semana.indexOf('2'), 1);
            }
            update_cal();
            document.getElementById('boton').disabled=false;
        });

        Y.one("#dias_X").on('click', function (ev) {
            miercoles_box = !miercoles_box;
            if (miercoles_box){
                regla_semana.push('3');
            }else{
                regla_semana.splice(regla_semana.indexOf('3'), 1);
            }
            update_cal();
            document.getElementById('boton').disabled=false;
        });

        Y.one("#dias_J").on('click', function (ev) {
            jueves_box = !jueves_box;
            if (jueves_box){
                regla_semana.push('4');
            }else{
                regla_semana.splice(regla_semana.indexOf('4'), 1);
            }
            update_cal();
            document.getElementById('boton').disabled=false;
        });

        Y.one("#dias_V").on('click', function (ev) {
            viernes_box = !viernes_box;
            if (viernes_box){
                regla_semana.push('5');
            }else{
                regla_semana.splice(regla_semana.indexOf('5'), 1);
            }
            update_cal();
            document.getElementById('boton').disabled=false;
        });

        Y.one("#dias_S").on('click', function (ev) {
            sabado_box = !sabado_box;
            if (sabado_box){
                regla_semana.push('6');
            }else{
                regla_semana.splice(regla_semana.indexOf('6'), 1);
            }
            update_cal();
            document.getElementById('boton').disabled=false;
        });


      });
    </script>
    <script type="text/javascript">
        function pSGC(argument) {
            let sgc_box = document.getElementById('SGC');
            sgc_box.checked = !sgc_box.checked;
        }
    </script>

  </section>
@endsection
