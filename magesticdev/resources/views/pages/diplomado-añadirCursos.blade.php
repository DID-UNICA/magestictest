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
            @if(session()->has('msj'))
            <div class="alert alert-success" role='alert'>{{session('msj')}}</div>
        @endif
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                @include ('partials.messages')
                    <h3>Añadir Cursos a Diplomados</h3>
                </div>
                <div class="panel-body">
                    <form id="cursoform" class="form-horizontal" method="POST" action="{{ route('diplomado.addCursos') }}">
                        {{ csrf_field() }}


                        <input type="hidden" name="diplomado" value="{{$id}}">
                        <div class="form-group{{ $errors->has('id_division') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Cursos</label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <select class="form-control" onchange="fun();" id="catalogoCursos" name="catalogoCursos">
                                            <option disabled selected>Seleccione un catalogo</option>
                                            @foreach($catCursos as $catcurso)
                                            <option value="{{$catcurso->id}}">{{$catcurso->nombre_curso}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <select  class="form-control" id='curso_id' multiple="multiple" name="curso_id[]" form="cursoform" size=10 multiple required>
                                                <option value="0" disabled></option>
                                        </select>

                                        @if ($errors->has('coordinacion_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('coordinacion_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
    <script>
        var cursos = [{{sizeof($cursos)}}];
        @for($i = 0; $i<sizeof($cursos); $i++)
            cursos[{{$i}}] = {
                id: {{ $cursos[$i]->id}},
                catalogo_id: {{ $cursos[$i]->catalogo_id}},
                fecha_inicio: "{{$cursos[$i]->fecha_inicio}}",
                semestre: "{{$cursos[$i]->getSemestre()}}",
                profesores: "{{$cursos[$i]->getProfesores()}}"
            };
        @endfor
        function fun(){
            var selectBox = document.getElementById("catalogoCursos");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            getSelectedValue(selectedValue);
        }
        function getSelectedValue(selected){
            var content = "";
            var opcion = "";
            for(i=0; i<cursos.length; i++){
                if(selected==cursos[i].catalogo_id){
                    opcion="<option value=\"" +cursos[i].id +" \"\>"+" "+cursos[i].profesores+" "+cursos[i].semestre+"</option>\n";
                    content=content+opcion;
                }
            }
            document.getElementById("curso_id").innerHTML = content;
        }
    </script>



                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar Diplomado
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

        </section>

@endsection 