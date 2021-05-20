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
                      <h1>{{ $user->getNombreCurso() }}</h1>
                </div>
                <div class="panel-body">



 
<div class="row">
<div class="row">
  <div class="row col-md-12 ">{!! Form::open(['route' => array('curso.actualizar', $user->id), "method" => "PUT"]) !!}
    <div class="col-md-12 row">
      <div class="form-group col-md-6">
          {!!Form::label("catalogo_id", "Nombre:")!!}
          <select class="form-control" id="catalogo_id" name="catalogo_id">
            @foreach($cursos as $curso)
                    <option value="{{$user->getIdCatalogo()}}">{{$user->getNombreCurso()}}</option>
                @if ($curso->id != $user->id)
                    <option value="{{$curso->getIdCatalogo()}}">{{$curso->getNombreCurso()}}</option>
                @endif
            @endforeach
          </select>
      </div>

      <div class="form-group col-md-6">
            <label for="name" class="col-md-12 control-label">Periodo:</label>
              <div class="col-md-4">
                <input id="semestreAnio" type="text" class="form-control" name="semestreAnio" value="{{$user->semestre_anio}}" minlength="4" maxlength= "4" required>

                @if ($errors->has('semestreAnio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('semestreAnio') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-4">
                <div class="row">
                @if ($user->semestre_pi == '1')
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
                @if ($user->semestre_si == 'i')
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
          {!!Form::date("fecha_inicio", $user->fecha_inicio, [ "class" => "form-control", "placeholder" => "Fecha de inicio", "required",""])!!}
      </div>

    <div class="form-group col-md-6">
        {!!Form::label("fecha_fin", "Fecha de fin:")!!}
        {!!Form::date("fecha_fin", $user->fecha_fin, [ "class" => "form-control", "placeholder" => "Fecha de fin", "required",""])!!}
    </div>
  </div>

    <div class="form-group col-md-6">
        {!!Form::label("hora_inicio", "Hora de inicio:")!!}
        {!!Form::text("hora_inicio", $user->hora_inicio, [ "class" => "form-control", "placeholder" => "Hora de inicio", "required",""])!!}
    </div>
    <div class="form-group col-md-6">
        {!!Form::label("hora_fin", "Hora de fin:")!!}
        {!!Form::text("hora_fin", $user->hora_fin, [ "class" => "form-control", "placeholder" => "Hora de fin", "required",""])!!}
    </div>


    <div class="form-group col-md-6">
        {!!Form::label("dias_semana", "Días a la semana:")!!}
        {!!Form::text("dias_semana", $user->dias_semana, [ "class" => "form-control", "placeholder" => "Días a la semana", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("numero_sesiones", "Número de sesiones")!!}
        {!!Form::number("numero_sesiones", $user->numero_sesiones, [ "class" => "form-control", "placeholder" => "Sesiones", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("costo", "Costo:")!!}
        {!!Form::number("costo", $user->costo, [ "class" => "form-control", "placeholder" => "Costo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("cupo_maximo", "Cupo máximo:")!!}
        {!!Form::number("cupo_maximo", $user->cupo_maximo, [ "class" => "form-control", "placeholder" => "Cupo máximo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("cupo_minimo", "Cupo mínimo")!!}
        {!!Form::number("cupo_minimo", $user->cupo_minimo, [ "class" => "form-control", "placeholder" => "Cupo mínimo", "required",""])!!}
    </div>

    <div class="form-group col-md-6">
        {!!Form::label("salon_id", "Sede:")!!}
        {!!Form::select("salon_id", $user->allSalon()->pluck('sede','id'),$user->getIdSalon(),['class'=>'form-control'])!!}
    </div>
    <div class="col-md-4">
    <hr>
    <button type="submit" class="btn btn-primary btn-md col-md-offset-1">Actualizar</button>
    <a href="{{ URL::to('curso', $user->id) }}" class="btn btn-danger">Cancelar</a>
  </div>
  {!! Form::close() !!}
</div>
      </div>
     </section>
@endsection
  
