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
                    <h1>{{ $user->nombre }}</h1>
                </div>
                <div class="panel-body">




                    <div class="row">
                        <div class="row col-md-12 ">{!! Form::open(['route' => array('carrera.actualizar', $user->id), "method" => "PUT"]) !!}

                            <div class="form-group col-md-4">
                                {!!Form::label("clave", "Clave")!!}
                                {!!Form::text("clave", $user->clave, [ "class" => "form-control", "placeholder" => "Clave", "required",""])!!}
                            </div>
                            <div class="form-group col-md-4">
                                {!!Form::label("nombre", "Nombre")!!}
                                {!!Form::text("nombre", $user->nombre, [ "class" => "form-control", "placeholder" => "Nombre", "required",""])!!}
                            </div>

                            <div class="form-group col-md-6">
                                {!!Form::label("id_division", "Division:")!!}
                                {!!Form::select("id_division", $user->allDivisions()->pluck('nombre','id'),$user->id_division,['class'=>'form-control'])!!}
                            </div>





                            <div>
                                <button type="submit" class="btn btn-primary col-md-offset-1">Actualizar</button>
                            </div>
                            {!! Form::close() !!}
                        </div>



                    </div>

        </section>

@endsection

