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
      @include ('partials.messages')
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1>{{ $user->getNombreCurso() }} </h1>
        </div>
        <div class="panel-body">

          <div class="row">
            <div class="row">
              <div class="row col-md-12" style="margin: 5px;">
                <div class="form-group col-md-4">
                  {!!Form::label("nombre", "Nombre:")!!}
                  {!!Form::text("nombre", $user->getNombreCurso(), [ "class" => "form-control", "placeholder" => "Nombre", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-4">
                  {!!Form::label("semestre_imparticion", "Periodo:")!!}
                  {!!Form::text("semestre_imparticion", $user->semestre_anio.'-'.$user->semestre_pi.$user->semestre_si, [ "class" => "form-control", "placeholder" => "Semestre", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-4">
                  {!!Form::label("salon_id", "Sede:")!!}
                  {!!Form::text("salon_id", $user->getSalon(), [ "class" => "form-control", "placeholder" => "Sede", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("fecha_inicio", "Fecha de inicio:")!!}
                  {!!Form::text("fecha_inicio", $user->getFechaInicio(), [ "class" => "form-control", "placeholder" => "Fecha de inicio", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("fecha_fin", "Fecha de fin:")!!}
                  {!!Form::text("fecha_fin", $user->getFechaFin(), [ "class" => "form-control", "placeholder" => "Fecha de fin", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("hora_inicio", "Hora de inicio:")!!}
                  {!!Form::text("hora_inicio", $user->hora_inicio, [ "class" => "form-control", "placeholder" => "Hora de inicio", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("hora_fin", "Hora de fin:")!!}
                  {!!Form::text("hora_fin", $user->hora_fin, [ "class" => "form-control", "placeholder" => "Hora de fin", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("dias_semana", "Días a la semana:")!!}
                  {!!Form::text("dias_semana", $user->dias_semana, [ "class" => "form-control", "placeholder" => "Dias a la semana", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("numero_sesiones", "Número de sesiones:")!!}
                  {!!Form::text("numero_sesiones", $user->numero_sesiones, [ "class" => "form-control", "placeholder" => "Número Sesiones", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-12">
                  {!!Form::label("sesiones", "Sesiones:")!!}
                  {!!Form::text("sesiones", $user->sesiones, [ "class" => "form-control", "placeholder" => "YYYY-MM-DD,YYYY-MM-DD", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("acreditacion", "Acreditación:")!!}
                  {!!Form::text("acreditacion", $user->acreditacion, [ "class" => "form-control", "placeholder" => "Acreditacion", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("costo", "Costo:")!!}
                  {!!Form::text("costo", $user->costo, [ "class" => "form-control", "placeholder" => "Costo", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("cupo_maximo", "Cupo máximo:")!!}
                  {!!Form::text("cupo_maximo", $user->cupo_maximo, [ "class" => "form-control", "placeholder" => "Cupo máximo", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("cupo_minimo", "Cupo mínimo:")!!}
                  {!!Form::text("cupo_minimo", $user->cupo_minimo, [ "class" => "form-control", "placeholder" => "Cupo mínimo", "required","disabled"])!!}
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("profesores", "Instructor(es):")!!}
                  <textarea class="form-control" rows="5" cols="55" disabled>
                    @foreach($profesores as $profesor)
                      {{$profesor->getNombres()}}.
                    @endforeach
                  </textarea>
                </div>

                <div class="form-group col-md-6">
                  {!!Form::label("labelSGC", "SGC:")!!}
                  @if($user->sgc)
                  <input type="checkbox" name="SGC" id="SGC" style="border-radius:.12em;height: 24px;width: 24px;" checked disabled>
                  @else
                  <input type="checkbox" name="SGC" id="SGC" style="border-radius:.12em;height: 24px;width: 24px;" disabled>
                  @endif
                </div>

                <div class="form-group col-md-6" style="margin: 5px">
                  <a href="{{ URL::to('curso/actualizar', $user->id) }}" class="btn btn-info">Actualizar información</a>
                  <a href="{{ URL::to('curso/instructores', $user->id) }}" class="btn btn-success">Modificar Instructores</a>
                  <button type="button" class="btn btn-danger" style="margin: 10px;" data-toggle="modal" data-target="#myModal{{$user->id}}">Dar de baja</button>
                  @if($user->getTipo() === 'S')
                    <a href="{{ route('curso.modificarInstructores', $user->id) }}" class="btn btn-warning">Asignar temas</a>
                  @endif
                </div>
              </div>
            </div>
          </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Curso Programado</h4>
              </div>
              <div class="modal-body">
                <p>¿Está seguro de eliminar el curso programado {{ $user->getNombreCurso() }}?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                <a href="{{ URL::to('curso/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </section>
@endsection
