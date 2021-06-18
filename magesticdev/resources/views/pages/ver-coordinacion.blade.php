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
                <div class="panel-heading">
                    <h1>{{ $user->nombre_coordinacion }} </h1>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="row">
                            <div class="row col-md-12 " style="margin:2px;">
                                <div class="form-group col-md-4">
                                    {!!Form::label("nombre", "Nombre:")!!}
                                    {!!Form::text("nombre", $user->nombre_coordinacion, [ "class" => "form-control", "placeholder" => "Nombre", "required","disabled"])!!}
                                </div>

                                <div class="form-group col-md-4">
                                    {!!Form::label("coordinador", "Coordinador:")!!}
                                    {!!Form::text("coordinador", $user->coordinador, [ "class" => "form-control", "placeholder" => "Coordinador", "required","disabled"])!!}
                                </div>

                                <div class="form-group col-md-4">
                                    {!!Form::label("coordinador", "Género:")!!}
                                    @if($user->genero === 'M')
                                      {!!Form::text("coordinador", 'Masculino', [ "class" => "form-control", "placeholder" => "Coordinador", "required","disabled"])!!}
                                    @elseif($user->genero === 'F')
                                      {!!Form::text("coordinador", 'Femenino', [ "class" => "form-control", "placeholder" => "Coordinador", "required","disabled"])!!}
                                    @else
                                      {!!Form::text("coordinador", 'Indefinido', [ "class" => "form-control", "placeholder" => "Coordinador", "required","disabled"])!!}
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    {!!Form::label("usuario", "Usuario del Coordinador:")!!}
                                    {!!Form::text("usuario", $user->usuario, [ "class" => "form-control", "placeholder" => "Usuario", "required","disabled"])!!}
                                </div>

                                <div class="form-group col-md-4">
                                    {!!Form::label("abreviatura", "Abreviatura del nombre:")!!}
                                    {!!Form::text("abreviatura", $user->abreviatura, [ "class" => "form-control", "placeholder" => "Abreviatura", "required","disabled"])!!}
                                </div>

                                <div class="form-group col-md-6">
                                    {!!Form::label("comentarios", "Comentarios:")!!}
                                    {!!Form::text("comentarios", $user->comentarios, [ "class" => "form-control", "placeholder" => "Comentarios", "required","disabled"])!!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label("grado", "Abreviatura de grado del Coordinador:")!!}
                                    {!!Form::text("grado", $user->grado, [ "class" => "form-control", "placeholder" => "Grado", "required","disabled"])!!}
                                </div>
                            </div>

                            <a href="{{ URL::to('coordinacion/actualizar', $user->id) }}" class="btn btn-primary" style="margin-left:3%;">Actualiza información</a>
                            <a href="{{ URL::to('coordinacion') }}" class="btn btn-info" style="margin-left:3%;">Regresar</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal" style="margin-left:3%;">Dar de baja</button>

                    <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Coordinación</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de eliminar la coordinación?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('coordinacion/baja', $user->id) }}" class="btn btn-danger">Dar de baja</a>

                          </div>
                        </div>
                      </div>
                    </div>


                        </div>



                    </div>

        </section>

@endsection

