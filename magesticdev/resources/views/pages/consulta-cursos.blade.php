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
      <div class="alert alert-danger" role='alert'>{{session('msj')}}</div>
    @endif
    @if(sizeof($cursos)==0)
      <div class="alert alert-danger" role='alert'>No hay resultados</div>
    @endif
      <br>
      <div class="panel panel-default">
      @include ('partials.messages')
        <div class="panel-heading">
          <div class="container">
            <h3>Cursos Programados</h3>
            {!! Form::open(["route" => ["curso.Csearch"], "method" => "POST"]) !!}
              <div class="input-group">
                <div class="row row-eq-height align-items-center">
                  <div class="row">
                    <div class="col-md-12">
                      {!!Form::text("pattern", null, [ "class" => "form-control", "placeholder" => "Buscar Curso", "id"=>"entrada"])!!}
                    </div>
                  </div>
                  <div id="E1" class="row row-eq-height align-items-center">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-12"><hr><label style="padding-left:10px">Fecha Inicio</label><br></div>
                        <div class="col-md-4">
                          <label id="AnioP" for="name" class="col-md-6 control-label">Año:</label>
                          <br>
                          <input id="Anio" type="year"  class="form-control" name="anio" placeholder="Año">
                        </div>
                        <div class="col-md-2">
                          <div class="row">
                            <label id="SemP" for="name" class="col-md-6 control-label">Semestre:</label>
                          </div>
                          <div class="row">
                            {!!Form::select('Sem', array('1' => '1', '2' => '2'), null, ["id" => "Sem", "class" => "btn dropdown-toggle"]);!!}
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label id="IOP" for="name" class="col-md-6 control-label">Tipo:</label>
                          {!!Form::select('IO', array('i' => 'Intersemestral', 's' => 'Semestral'), null, ["id" => "IO", "class" => "btn dropdown-toggle"]);!!}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12"><hr><label style="padding-left:10px">Fecha Final</label><br></div>
                        <div class="col-md-4">
                          <label id="AnioP2" for="name" class="col-md-6 control-label">Año:</label>
                          <br>
                          <input id="Anio2" type="year"  class="form-control" name="anio2" placeholder="Año">
                        </div>
                        <div class="col-md-2">
                          <div class="row">
                            <label id="SemP2" for="name" class="col-md-6 control-label">Semestre:</label>
                          </div>
                          <div class="row">
                            {!!Form::select('Sem2', array('1' => '1', '2' => '2'), null, ["id" => "Sem2", "class" => "btn dropdown-toggle"]);!!}
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label id="IOP2" for="name" class="col-md-6 control-label">Tipo:</label>
                            {!!Form::select('IO2', array('i' => 'Intersemestral', 's' => 'Semestral'), null, ["id" => "IO2", "class" => "btn dropdown-toggle"]);!!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr id="hr">
                  <div class="row">
                    <div class="col-md-12">
                      <select name="type" class = 'btn dropdown-toggle pull-left' id='myselect' onchange="deter()">
                        <option value="nombre_curso" >Por nombre</option>
                        <option value="clave" >Por clave</option>
                        <option value="fechas" >Por periodo</option>
                        <option value="titular" >Por profesor titular</option>
                      </select>
                      <span class="input-group-btn col-md-2">
                        <button class="btn btn-secondary" type="submit">Buscar</button>
                      </span>
                    </div>      
                  </div>
                </div>
              </div>
            {!! Form::close() !!}
            <h3>Generar Reporte</h3>
            {!! Form::open(["route" => ["reporte.generar"], "method" => "GET"]) !!}
              <div class="input-group">
                <div class="row row-eq-height align-items-center">
                  <div  id="F1" class="row row-eq-height align-items-center">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-12"><hr><label style="padding-left:10px"> Seleccionar Periodo</label><br></div>
                        <div class="col-md-4">
                          <label id="AnioP3" for="name" class="col-md-6 control-label">Año:</label>
                          <br>
                          <input id="Anio3" type="year" required class="form-control" name="anio3" placeholder="Año">
                        </div>
                        <div class="col-md-2">
                          <div class="row">
                            <label id="SemP2" for="name" class="col-md-6 control-label">Semestre:</label>
                          </div>
                          <div class="row">
                            {!!Form::select('Sem2', array('1' => '1', '2' => '2'), null, ["id" => "Sem2", "class" => "btn dropdown-toggle"]);!!}
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label id="IOP2" for="name" class="col-md-6 control-label">Tipo:</label>
                          {!!Form::select('IO2', array('i' => 'Intersemestral', 's' => 'Semestral'), null, ["id" => "IO2", "class" => "btn dropdown-toggle"]);!!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div style="padding-top: 10px" class="col-md-12">
                    <select name="type2" class = 'btn dropdown-toggle pull-left' id='myselect2' onchange="deter2()">
                      <option value="excel"> Reporte en Excel</option>
                      <option value="periodo" >Reporte de Cursos</option>
                      <option value="sugerencia" >Reporte de Sugerencias</option>
                    </select>
                    <span class="input-group-btn col-md-2">
                      <button class="btn btn-secondary" type="submit">Generar</button>
                    </span>
                  </div> 
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="panel-body">
        <table class="col-md-12">
     <tr>
        <th>Nombre</th>
         <th>Instructor</th>
        <th>Salon</th>
        <th></th>
     </tr>
    @foreach($cursos as $curso)
        <tr>
        <td>{{ $curso->getNombreCurso() }} </td>
        <td>{{$curso->getProfesores() }}</td>
        <td>{{ $curso->getSalon()}}</td>
        <td class="boton">
            <a href="{{ URL::to('curso/generar-formatos',$curso->id) }}" class="btn btn-primary" style="margin-bottom: 15px;">Generar formatos</a>
            <a href="{{ URL::to('curso/ver-profesores',$curso->id) }}" class="btn btn-warning" style="margin-bottom: 15px;">Ver Curso</a>
            <a href="{{ URL::to('curso/inscripcion',$curso->id)}}" class="btn btn-success" style="margin-bottom: 15px;">Inscribir</a>
            <a href="{{ URL::to('curso', $curso->id) }}" class="btn btn-info" style="margin-bottom: 15px;">Detalles</a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$curso->id}}" style="margin-bottom: 15px;">Dar de baja</button>
        </td>
      </tr>

                  <!-- Modal -->
                    <div class="modal fade" id="myModal{{$curso->id}}" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar Curso</h4>
                          </div>
                          <div class="modal-body">
                            <p><b>¿Está seguro de eliminar el curso {{ $curso->getNombreCurso() }}?<br>Profesores:{{$curso->getProfesores() }}</b></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-normal" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <a href="{{ URL::to('curso/baja', $curso->id) }}" class="btn btn-danger">Dar de baja</a>
                          </div>
                        </div>
                      </div>
                    </div>
    @endforeach

</table>

                
      

      </div>
      <script type="text/javascript">
        function selectCheck() {
                document.getElementById('entrada').style.display = 'none';
                document.getElementById('E1').style.display = 'block';
        }
        function esconder() {
                document.getElementById('entrada').style.display = 'block';
                document.getElementById('E1').style.display = 'none';
        }

        function deter(){
          var e = document.getElementById("myselect");
          var strE = e.options[e.selectedIndex].text;
          console.log(strE);
          if(strE !="Por periodo"){
              esconder();
          }else{
              selectCheck();
          }
        }
        function deter2(){
          var e = document.getElementById("myselect2");
          var strE = e.options[e.selectedIndex].text;
          if(strE =="Reporte en Excel"){
            document.getElementById('F1').style.display = 'none';
            document.getElementById('Anio3').removeAttribute("required");
          }else{
            document.getElementById('F1').style.display = 'block';
            document.getElementById('Anio3').setAttribute("required", "");
          }
        }
          esconder();
          deter2();
      </script>

     </section>
     
@endsection
  

  
