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
                  <h3>Generación de Formatos</h3>
                </div>
                <div class="panel-body">
                @include('flash::message')
                <div class="logos col-md-12 col-center">
                	<img class="img-escudo" src="{{ asset('img/cdd.png') }}">
                	Manejo y Gestión de información del Centro de Docencia.</h3>
                </div>

                <hr>
                <h2>Constancias <span class="fa fa-file-pdf-o"</span></h2>


                    <table class="table table-hover">
                       <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                            <div class="collapse navbar-collapse" id="menuCurso">
                     
              <form id="form" class="form-horizontal" method="POST" action="{{ route('constancias.generar') }}">
                {{ csrf_field() }}

                
                
            <div class="col-7">
            <label for="catalogoCursos" class="col-md-4 control-label">Curso: </label>
                <select class="form-control" onchange="fun();" id="catalogoCursos" name="catalogoCursos">
                    <option disabled selected>Seleccione un catálogo</option>
                    @foreach($cursosCatalogo as $catcurso)
                    <option value="{{$catcurso->id}}">{{$catcurso->nombre_curso}}</option>
                    @endforeach
                </select>
            </div>



          <table class="col-md-12">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Profesor</th>
                    <th>Sede</th>
                    <th>Periodo</th>
                    <th></th>
                </tr>
               
            </table>
                <table width="100%" class="col-md-12" id="cursosDesp"></table>

            <script>
                var cursos = [{{sizeof($cursos)}}];
        @for($i = 0; $i<sizeof($cursos); $i++)
            cursos[{{$i}}] = {
                id: {{ $cursos[$i]->id}},
                nombre:"{{$cursos[$i]->getNombreCurso()}}",
                tipo:"{{$cursos[$i]->getTipoCadena()}}",
                salon:"{{$cursos[$i]->getSalon()}}",
                catalogo_id: {{ $cursos[$i]->catalogo_id}},
                semestre: "{{$cursos[$i]->getSemestre()}}",
                profesores: "{{$cursos[$i]->getProfesores()}}"
            };
        @endfor
        function fun(){
            var selectBox = document.getElementById("catalogoCursos");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            getSelectedValue(selectedValue);
        }
        function fun2(id){
            document.getElementById("auxiliar").value=id;
            document.getElementById("form").submit();
        }
        function getSelectedValue(selected){
            var content = "";
            var opcion = "";
            for(i=0; i<cursos.length; i++){
                if(selected==cursos[i].catalogo_id){
                    opcion="<tr><td width=\"22%\">"+cursos[i].nombre+"</td><td width=\"10%\">"+cursos[i].tipo+"</td><td width=\"25%\">"+cursos[i].profesores+"</td><td width=\"15%\">"+cursos[i].salon+"</td><td width=\"15%\">"+cursos[i].semestre+"</td><td width=\"13%\"><button type=\"submit\" method=\"POST\" action=\"{{ route('constancias.generar') }}\" class=\"btn btn-primary form-control\" name=\"id\" value=\""+cursos[i].id+"\" onclick=\"fun2("+cursos[i].id+")\">Crear</button></tr>";
                    content=content+opcion;
                }
            }
            document.getElementById("cursosDesp").innerHTML = content;

        }
            </script>
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
          var divCuatroFirmantes = document.getElementById("cuatroFirmantes");
          var divCincoFirmantes = document.getElementById("cincoFirmantes");



          if(strE == "Un firmante"){
              divUnFirmante.style.display = "block";
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
          }else if(strE == "Dos firmantes"){
              divDosFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
          }else if(strE == "Tres firmantes"){
              divTresFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
          }else if(strE == "Cuatro firmantes"){
              divCuatroFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCincoFirmantes.style.display = "none"
          }else if(strE == "Cinco firmantes"){
              divCincoFirmantes.style.display = "block";
              divUnFirmante.style.display = "none"
              divDosFirmantes.style.display = "none"
              divTresFirmantes.style.display = "none"
              divCuatroFirmantes.style.display = "none"
          }else{
            divUnFirmante.style.display = "none"
            divDosFirmantes.style.display = "none"
            divTresFirmantes.style.display = "none"
            divCuatroFirmantes.style.display = "none"
            divCincoFirmantes.style.display = "none"
          }
      }
      
      
    </script>

	 
@endsection
  