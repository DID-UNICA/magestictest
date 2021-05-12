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
                <h3>Antecedentes de {{$catalogoCurso->nombre_curso}}</h3>

            </div>
            <div class="panel-body">

                <table class="col-md-6">
										<tr>
                      <th style='text-align:center;'>Antecedentes</th>
                    </tr>
                    <tr>
                        <th>Clave</th>
                        <th>Nombre del curso</th>
                        <th>Coordinación</th>
                        <th></th>

                    </tr>
                    @foreach($antecedentes as $antecedente )
                        <tr>
                            <td>{{$antecedente->clave_curso}}</td>
                            <td>{{$antecedente->nombre_curso}}</td>
                            <td>{{$antecedente->getCoordinacion()}}</td>
                            <td>
                                <a style="margin-bottom: 10px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$antecedente->clave_curso}}">Descartar</a>
                            </td>
                        </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$antecedente->clave_curso}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Descartar Antecedentes</h4>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de descartar el antecedente {{ $antecedente->nombre_curso }}?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('catalogo-cursos/descartarAntecedente', [$catalogoCurso->id,$antecedente->id]) }}" class="btn btn-danger">Descartar de Antecedentes</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                </table>
								<table class="col-md-6">
										<tr>
                      <th style='text-align:center;'>Catálogos</th>
                    </tr>
                    <tr>
                        <th>Clave</th>
                        <th>Nombre del curso</th>
                        <th>Coordinación</th>
                        <th></th>
                    </tr>
                    @foreach($catalogos as $catalogo )
                        <tr>
                            <td>{{$catalogo->clave_curso}}</td>
                            <td>{{$catalogo->nombre_curso}}</td>
                            <td>{{$catalogo->getCoordinacion()}}</td>
                            <td>
															<a href="{{ URL::to('catalogo-cursos/alta-antecedente', [$catalogoCurso->id,$catalogo->id]) }}" style="margin-bottom: 10px;" type="button" class="btn btn-primary">Añadir</a>
                            </td>
                        </tr>
                    @endforeach
                </table>




            </div>

    </section>

@endsection