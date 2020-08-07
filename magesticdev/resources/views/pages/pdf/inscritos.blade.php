<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscritos a cursos</title>
</head>
<style>
    div.container {
        text-align:center;
    }
html{
    width:100%;
    height: 100%;
}
body {
  font-family: Arial, Helvetica, Sans-serif;
  align-items: center;
  font-size: 15px;
  height: 95%;
  margin: 30px 30px 30px;

}
h4 {
    margin-left:10; 
    margin-right:10;
    font-style:italic;
}
#abajo{
    margin: 150px,10px,20px;
}
hr{
    border: 2px solid #000;
  border-spacing: 0;
 
  }
#separar{
    margin: 30px;
}
#mayusculas{
    text-transform: uppercase;
}

#encabezado{
    margin: 0px 20px 10px;
    height: 5%;
}
#imagen{
    padding: 0px;
}

</style>
<body>
    <div>
        <table id="encabezado" style="width: 100%" align="center">
            <tr>
                <td width="10%" align="center" id="imagen">
                    <img src="img/m.png" alt="" align="right" height="100">             
                </td>
                <td width="60%" align="center"><h1>Nombre del Curso</h1></td>
               <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%"></td>
                <td width="60%"></td>
                <td width="10%" align="center">Semestre</td>
            </tr>
        </table>
        <hr/>
        <div id="separar"></div>
        <hr/ >


 
        <table style="width: 100%" class="cuerpo">
            <tr>
                <td></td>
                <td></td>
                <td>Instructor</td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td></td>
                <td id="mayusculas">Nombre Completo</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Hora inicio:</td>
                <td>No. de sesiones:</td>
                <td></td>
            </tr>
            <tr>
                <td>Hora fin:</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <div>
        <table style="width: 100%" align="center">
            <tr>
                <td id="lista" width="20%"></td>
                <td id="nombre" align="center" width="20%"><b>Nombre Completo</b></td>
                <td id="division" align="center" width="20%"></td>
                <td id="status" width="20%"></td>
            </tr>
        </table>
        <hr/>
        <table style="width: 100%">
            <?php
            foreach($alumnos as $alumno){
            print("<tr>
                <td width=20% align=center>{$alumno->id}</td>
                <td width=20% align=center>{$alumno->Nombre}{$alumno->apPaterno}{$alumno->apMaterno}</td>
                <td width=20% align=center>{$alumno->Materia}</td>
                <td width=20% align=center>{$alumno->Espera}</td>
            </tr>");
            }
            ?> 
        </table>    
       
    
    </div>
    <div></div>
    <a href="{{ url('/inscritos/pdf') }}" class="btn btn-info" style="text-align:right">PDF</a></td>
</body>
</html>