<!-- Guardado en resources/views/pages/admin.blade.php -->

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
    <br>
      <div class="panel panel-default">
      @include ('partials.messages')
                <div class="panel-heading">
                      <h1>{{ $curso->getNombreCurso() }}</h1>
                </div>
                <div class="panel-body">



 
<div class="row">
<div class="row">
  <div class="row col-md-12 ">{!! Form::open(['route' => array('curso.actualizar', $curso->id), "method" => "PUT"]) !!}
    <div class="col-md-12 row">
      <div class="form-group col-md-6">
          {!!Form::label("catalogo_id", "Nombre:")!!}
          <select class="form-control" id="catalogo_id" name="catalogo_id">
            <option selected value="{{$curso->catalogo_id}}">{{$curso->getNombreCurso()}}</option>
            @foreach($catalogos as $catalogo)
                @if ($catalogo->id != $curso->catalogo_id)
                    <option value="{{$catalogo->id}}">{{$catalogo->getNombreClave()}}</option>
                @endif
            @endforeach
          </select>
      </div>

      <div class="form-group col-md-6">
            <label for="name" class="col-md-12 control-label">Periodo:</label>
              <div class="col-md-4">
                <input id="semestreAnio" type="text" class="form-control" name="semestreAnio" value="{{$curso->semestre_anio}}" minlength="4" maxlength= "4" required>

                @if ($errors->has('semestreAnio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('semestreAnio') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-4">
                <div class="row">
                @if ($curso->semestre_pi == '1')
                <select name="semestreTemporada"   class="form-control">
                    <option value="1" selected>1 </option>
                    <option value="2">2 </option>
                </select>
                @else
                <select name="semestreTemporada"   class="form-control">
                    <option value="1">1 </option>
                    <option value="2" selected>2 </option>
                </select>
                @endif
                @if ($errors->has('semestreTemporada'))
                    <span class="help-block">
                        <strong>{{ $errors->first('semestreTemporada') }}</strong>
                    </span>
                @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                @if ($curso->semestre_si == 'i')
                <select name="semestreInter"   class="form-control">
                    <option value="i" selected>Intersemestral </option>
                    <option value="s">Semestral </option>
                </select>
                @else
                <select name="semestreInter"   class="form-control">
                    <option value="i">Intersemestral </option>
                    <option value="s" selected>Semestral </option>
                </select>
                @endif
                @if ($errors->has('semestreInter'))
                    <span class="help-block">
                        <strong>{{ $errors->first('semestreInter') }}</strong>
                    </span>
                @endif
                </div>
            </div>
    </div>
  </div>
      <div class="form-group col-md-6">
          {!!Form::label("fecha_inicio", "Fecha de inicio:")!!}
          {!!Form::date("fecha_inicio", $curso->fecha_inicio, [ "class" => "form-control", "placeholder" => "Fecha de inicio", "required",""])!!}
      </div>

    <div class="form-group col-md-6">
        {!!Form::label("fecha_fin", "Fecha de fin:")!!}
        {!!Form::date("fecha_fin", $curso->fecha_fin, [ "class" => "form-control", "placeholder" => "Fecha de fin", "required",""])!!}
    </div>
  </div>

    <div class="form-group col-md-6">
        {!!Form::label("hora_inicio", "Hora de inicio:")!!}
        {!!Form::text("hora_inicio", $curso->hora_inicio, [ "class" => "form-control", "placeholder" => "Hora de inicio", "required",""])!!}
    </div>
    <div class="form-group col-md-6">
        {!!Form::label("hora_fin", "Hora de fin:")!!}
        {!!Form::text("hora_fin", $curso->hora_fin, [ "class" => "form-control", "placeholder" => "Hora de fin", "required",""])!!}
    </div>


    <div class="form-group col-md-6">
        {!!Form::label("dias_semana", "Días a la semana:")!!}
        {!!Form::text("dias_semana", $curso->dias_semana, [ "class" => "form-control", "placeholder" => "Días a la semana", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("numero_sesiones", "Número de sesiones:")!!}
        {!!Form::number("numero_sesiones", $curso->numero_sesiones, [ "class" => "form-control", "placeholder" => "Número Sesiones", "required",""])!!}
    </div>

    <div class="form-group col-md-12">
        {!!Form::label("sesiones", "Sesiones:")!!}
        {!!Form::text("sesiones", $curso->sesiones, [ "class" => "form-control", "placeholder" => "YYYY-MM-DD,YYYY-MM-DD", "required",""])!!}
    </div>

    <div class="form-group">
        <div class="col-md-12 row">
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

    <div class="form-group col-md-6">
        {!!Form::label("acreditacion", "Acreditación:")!!}
        {!!Form::number("acreditacion", $curso->acreditacion, [ "class" => "form-control", "placeholder" => "Acreditación", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("costo", "Costo:")!!}
        {!!Form::number("costo", $curso->costo, [ "class" => "form-control", "placeholder" => "Costo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("cupo_maximo", "Cupo máximo:")!!}
        {!!Form::number("cupo_maximo", $curso->cupo_maximo, [ "class" => "form-control", "placeholder" => "Cupo máximo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("cupo_minimo", "Cupo mínimo:")!!}
        {!!Form::number("cupo_minimo", $curso->cupo_minimo, [ "class" => "form-control", "placeholder" => "Cupo mínimo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("salon_id", "Sede:")!!}
        {!!Form::select("salon_id", $curso->allSalon()->pluck('sede','id'),$curso->getIdSalon(),['class'=>'form-control'])!!}
    </div>
    <div class="form-group col-md-6">
        {!!Form::label("salon_id", "SGC:")!!}
        @if($curso->sgc)
        <input type="checkbox" name="SGC" id="SGC" style="border-radius:.12em;height: 24px;width: 24px;" checked>
        @else
        <input type="checkbox" name="SGC" id="SGC" style="border-radius:.12em;height: 24px;width: 24px;">
        @endif
        <p style="display:inline;font-size: large;vertical-align: super;" onclick="pSGC()"> Sistema de Gestión de Calidad</p>
    </div>
    <div class="col-md-4">
    <hr>
    <button type="submit" class="btn btn-primary btn-md col-md-offset-1">Actualizar</button>
    <a href="{{ URL::to('curso', $curso->id) }}" class="btn btn-danger">Cancelar</a>
  </div>
  {!! Form::close() !!}
</div>
</div>

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
        date: new Date(document.getElementById('sesiones').value.split(',')[0].replace('-',','))
    }).render();

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


    var semana_array = ['lunes','martes','miércoles','jueves','viernes','sábado'];

    Y.one("#dias_semana").on('change', function (ev) {
        var cadena_semana = document.getElementById('dias_semana').value.toLowerCase();
        for (var i = 0; i < semana_array.length; i++) {
            if (cadena_semana.indexOf(semana_array[i])>=0){
                regla_semana.push((i+1).toString());
            }else{
                var i_aux = regla_semana.indexOf((i+1).toString());
                if (i_aux > -1) {regla_semana.splice(i_aux, 1);}
            }
        }
        update_cal();
    });

    Y.on('load', function (ev) {
        inicio_fin();
        var cadena_semana = document.getElementById('dias_semana').value.toLowerCase();
        for (var i = 0; i < semana_array.length; i++) {
            if (cadena_semana.indexOf(semana_array[i])>=0){
                regla_semana.push((i+1).toString());
            }else{
                var i_aux = regla_semana.indexOf((i+1).toString());
                if (i_aux > -1) {regla_semana.splice(i_aux, 1);}
            }
        }
        update_cal();
        sesiones_array = document.getElementById('sesiones').value.split(',');
        sesiones_array_aux = [];
        for (var i = 0; i < sesiones_array.length; i++) {
            sesiones_array_aux.push( new Date(sesiones_array[i].replace('-',',')));
            //borrar
            //window.alert(new Date(sesiones_array[i].replace('-',',')));
        }
        calendar._addDatesToSelection(sesiones_array_aux);
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
  
