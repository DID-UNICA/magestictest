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
    @if(session()->has('msj'))
        <div class="alert alert-success" role='alert'>{{session('msj')}}</div>
      @endif

    @if(session()->has('error'))
        <div class="alert alert-danger" role='alert'>{{session('error')}}</div>
      @endif
    <section class="content-inner">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Antescedentes de {{$catalogoCurso->nombre_curso}}---</h3>

            </div>
            <div class="panel-body">

                <table class="col-md-12">
                    <tr>
                        <th>Clave</th>
                        <th>Nombre del curso</th>
                        <th>Coordinación</th>
                        <th></th>

                    </tr>
                    @foreach($antescedentes as $antescedente )
                        <tr>
                            <td>{{$antescedente->clave_curso}}</td>
                            <td>{{$antescedente->nombre_curso}}</td>
                            <td>{{$antescedente->getCoordinacion()}}</td>
                            <td>
                                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$antescedente->clave_curso}}">Descartar de Antescedentes</a>
                            </td>
                        </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$antescedente->clave_curso}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Descartar Antescedentes</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de descartar el antescedente {{ $antescedente->nombre_curso }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('catalogo-cursos/descartarAntescedente', [$catalogoCurso->id,$antescedente->id]) }}" class="btn btn-danger">Descartar de Antescedentes</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                </table>




            </div>

    </section>

@endsection