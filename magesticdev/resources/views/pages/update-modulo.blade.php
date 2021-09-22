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
    <br>
      <div class="panel panel-default">
      @include ('partials.messages')
                <div class="panel-heading">
                      <h1>{{ $modulo->getNombreCurso() }}</h1>
                </div>
                <div class="panel-body">



 
<div class="row">
<div class="row">
  <div class="row col-md-12 ">{!! Form::open(['route' => array('modulo.update', $modulo->id), "method" => "PUT"]) !!}
    <div class="col-md-12 row">
      <div class="form-group col-md-6">
          {!!Form::label("catalogo_id", "Nombre:")!!}
          <select class="form-control" id="catalogo_id" name="catalogo_id">
            <option selected value="{{$modulo->catalogo_id}}">{{$modulo->getNombreCurso()}}</option>
            @foreach($catalogos as $catalogo)
                @if ($catalogo->id != $modulo->catalogo_id)
                    <option value="{{$catalogo->id}}">{{$catalogo->getNombreClave()}}</option>
                @endif
            @endforeach
          </select>
      </div>

      <div class="form-group col-md-6">
            <label for="name" class="col-md-12 control-label">Periodo:</label>
              <div class="col-md-4">
                <input id="semestreAnio" type="text" class="form-control" name="semestreAnio" value="{{$modulo->semestre_anio}}" minlength="4" maxlength= "4" required>

                @if ($errors->has('semestreAnio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('semestreAnio') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-4">
                <div class="row">
                @if ($modulo->semestre_pi == '1')
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
                @if ($modulo->semestre_si == 'i')
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
          {!!Form::date("fecha_inicio", $modulo->fecha_inicio, [ "class" => "form-control", "placeholder" => "Fecha de inicio", "required",""])!!}
      </div>

    <div class="form-group col-md-6">
        {!!Form::label("fecha_fin", "Fecha de fin:")!!}
        {!!Form::date("fecha_fin", $modulo->fecha_fin, [ "class" => "form-control", "placeholder" => "Fecha de fin", "required",""])!!}
    </div>
  </div>

    <div class="form-group col-md-6">
        {!!Form::label("hora_inicio", "Hora de inicio:")!!}
        {!!Form::text("hora_inicio", $modulo->hora_inicio, [ "class" => "form-control", "placeholder" => "Hora de inicio", "required",""])!!}
    </div>
    <div class="form-group col-md-6">
        {!!Form::label("hora_fin", "Hora de fin:")!!}
        {!!Form::text("hora_fin", $modulo->hora_fin, [ "class" => "form-control", "placeholder" => "Hora de fin", "required",""])!!}
    </div>


    <div class="form-group col-md-6">
        {!!Form::label("dias_semana", "Días a la semana:")!!}
        {!!Form::text("dias_semana", $modulo->dias_semana, [ "class" => "form-control", "placeholder" => "Días a la semana", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("numero_sesiones", "Número de sesiones:")!!}
        {!!Form::number("numero_sesiones", $modulo->numero_sesiones, [ "class" => "form-control", "placeholder" => "Número Sesiones", "required",""])!!}
    </div>

    <div class="form-group col-md-12">
        {!!Form::label("sesiones", "Sesiones:")!!}
        {!!Form::number("sesiones", $modulo->sesiones, [ "class" => "form-control", "placeholder" => "Sesiones", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("acreditacion", "Acreditación:")!!}
        {!!Form::number("acreditacion", $modulo->acreditacion, [ "class" => "form-control", "placeholder" => "Acreditación", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("costo", "Costo:")!!}
        {!!Form::number("costo", $modulo->costo, [ "class" => "form-control", "placeholder" => "Costo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("cupo_maximo", "Cupo máximo:")!!}
        {!!Form::number("cupo_maximo", $modulo->cupo_maximo, [ "class" => "form-control", "placeholder" => "Cupo máximo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("cupo_minimo", "Cupo mínimo")!!}
        {!!Form::number("cupo_minimo", $modulo->cupo_minimo, [ "class" => "form-control", "placeholder" => "Cupo mínimo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("salon_id", "Sede:")!!}
        {!!Form::select("salon_id", $modulo->allSalon()->pluck('sede','id'),$modulo->getIdSalon(),['class'=>'form-control'])!!}
    </div>
    <div class="col-md-4">
    <hr>
    <button type="submit" class="btn btn-primary btn-md col-md-offset-1">Actualizar</button>
    <a href="{{ route('modulo.ver', $modulo->id) }}" class="btn btn-danger">Cancelar</a>
  </div>
  {!! Form::close() !!}
</div>
      </div>
     </section>
@endsection
  
