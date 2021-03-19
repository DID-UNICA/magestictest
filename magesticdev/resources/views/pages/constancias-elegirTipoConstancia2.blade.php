@extends('layouts.principal')

@section('contenido')
  <!--Body content-->
<style>
    nav.navbar{
        background-color: #FAF8F8;
    }
</style>

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
                    <h3>Coordinación de Gestión y Vinculación</h3>
                </div>
                <div class="panel-body">
                @include('flash::message')
                <div class="logos col-md-12 col-center">
                	<img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                	Manejo y Gestión de información del Centro de Docencia.</h3>
                </div>

                <hr>
                <h2>Constancias en un Solo Archivo <span class="fa fa-file-pdf-o"</span></h2>


                    <table class="table table-hover">
                       <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                            <div class="collapse navbar-collapse" id="menuCurso">
                     
              <form class="form-horizontal" method="POST" action="{{ route('constancias.generar2') }}">
                {{ csrf_field() }}

                
                <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tipo de constancia: </label>
                            <div class="col-md-6">
                                <select id="type" class="form-control" name="type" value="{{ old('type')}}" onchange="determinarFirmantes()">
                                    <option value="A">Instructores y Coordinador</option>
                                    <option value="B">Instructores y Coordinación General</option>
                                    <option value="C">Instructores y Secretaría de Apoyo a la Docencia</option>
                                    <option value="AA">Coordinación</option>
                                    <option value="D">Coordinación General</option>
                                    <option value="I">Coordinación y Coordinador general</option>
                                    <option value="E">Director</option>
                                    <option value="F">Coordinación General y Secretaría de Apoyo a la Docencia</option>
                                    <option value="G">Secretaría de Apoyo a la Docencia y Director</option>
                                    <option value="H">UNICA</option>
                                    <option value="f1">Un firmante</option>
                                    <option value="f2">Dos firmantes</option>
                                    <option value="f3">Tres firmantes</option>

                                   
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                </div>
            <br>
            <div id = "unFirmante" style="display:none">
                <div class="form-group{{ $errors->has('name1A') ? ' has-error' : '' }}">
                    <label for="name1A" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1A" type="text" class="form-control" name="name1A" value="{{ old('name1A') }}" >
                        @if ($errors->has('name1A'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1A') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1A') ? ' has-error' : '' }}">
                    <label for="posicion1A" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1A" type="text" class="form-control" name="posicion1A" value="{{ old('posicion1A') }}" >
                        @if ($errors->has('posicion1A'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1A') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div id = "dosFirmantes" style="display:none">
                <div class="form-group{{ $errors->has('name1B') ? ' has-error' : '' }}">
                    <label for="name1B" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1B" type="text" class="form-control" name="name1B" value="{{ old('name1B') }}" >
                        @if ($errors->has('name1B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1B') ? ' has-error' : '' }}">
                    <label for="posicion1B" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1B" type="text" class="form-control" name="posicion1B" value="{{ old('posicion1B') }}" >
                        @if ($errors->has('posicion1B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div><br>

                <div class="form-group{{ $errors->has('name2B') ? ' has-error' : '' }}">
                    <label for="name2B" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name2B" type="text" class="form-control" name="name2B" value="{{ old('name2B') }}" >
                        @if ($errors->has('name2B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name2B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion2B') ? ' has-error' : '' }}">
                    <label for="posicion2B" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion2B" type="text" class="form-control" name="posicion2B" value="{{ old('posicion2B') }}" >
                        @if ($errors->has('posicion2B'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion2B') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div id = "tresFirmantes" style="display:none">
                <div class="form-group{{ $errors->has('name1C') ? ' has-error' : '' }}">
                    <label for="name1C" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name1C" type="text" class="form-control" name="name1C" value="{{ old('name1C') }}" >
                        @if ($errors->has('name1C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name1C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion1C') ? ' has-error' : '' }}">
                    <label for="posicion1C" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion1C" type="text" class="form-control" name="posicion1C" value="{{ old('posicion1C') }}" >
                        @if ($errors->has('posicion1C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion1C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div><br>

                <div class="form-group{{ $errors->has('name2C') ? ' has-error' : '' }}">
                    <label for="name2C" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name2C" type="text" class="form-control" name="name2C" value="{{ old('name2C') }}" >
                        @if ($errors->has('name2C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name2C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion2C') ? ' has-error' : '' }}">
                    <label for="posicion2C" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion2C" type="text" class="form-control" name="posicion2C" value="{{ old('posicion2C') }}" >
                        @if ($errors->has('posicion2C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion2C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div><br>
                <div class="form-group{{ $errors->has('name3C') ? ' has-error' : '' }}">
                    <label for="name3C" class="col-md-4 control-label">Nombre: </label>
                    <div class="col-md-6">
                        <input id="name3C" type="text" class="form-control" name="name3C" value="{{ old('name3C') }}" >
                        @if ($errors->has('name3C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name3C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('posicion3C') ? ' has-error' : '' }}">
                    <label for="posicion3C" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        <input id="posicion3C" type="text" class="form-control" name="posicion3C" value="{{ old('posicion3C') }}" >
                        @if ($errors->has('posicion3C'))
                            <span class="help-block">
                                <strong>{{ $errors->first('posicion3C') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>


          <table class="col-md-12">
                <tr>
                    <th>Nombre</th>
                    <th>Profesor</th>
                    <th>Salón</th>
                    <th>Periodo</th>
                    <th></th>
                </tr>
                @foreach($cursos as $curso)
                  <tr>
                      <td>{{ $curso->getNombreCurso() }} </td>
                      <td>{{ $curso->getProfesores() }}</td>
                      <td>{{ $curso->getSalon()}}</td>
                      <td>{{ $curso->semestre_imparticion }}</td>
                      <td>
                          <button type="submit" class="btn btn-primary form-control" name="id" value="{{$curso->id}}">
                            Crear
                        </button>
                </tr>
                  @endforeach

            </table>

          </form>

                
                                                        
      </div>

     </section>


    <script type="text/javascript">
      function determinarFirmantes(){
          console.log("Entré a script")
          var e = document.getElementById("type");
          var strE = e.options[e.selectedIndex].text;
          console.log(strE);
          var divUnFirmante = document.getElementById("unFirmante");
          var divDosFirmantes = document.getElementById("dosFirmantes");
          var divTresFirmantes = document.getElementById("tresFirmantes");


          if(strE == "Un firmante"){
              divUnFirmante.style.display = "block";
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
          }else if(strE == "Dos firmantes"){
              divDosFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divTresFirmantes.style.display = "none"
          }else if(strE == "Tres firmantes"){
              divTresFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
          }else{
            divUnFirmante.style.display = "none"
            divDosFirmantes.style.display = "none"
            divTresFirmantes.style.display = "none"

          }
      }
      
      
    </script>

	 
@endsection
  

  
