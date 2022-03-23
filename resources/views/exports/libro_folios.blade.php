<html>
<table>
    <thead>
    <tr>
        <th style='font-weight:bold; background-color:#f1c232'>FOLIO INSTITUCIONAL</th>
        <th style='font-weight:bold; background-color:#f1c232'>FOLIO PEQUEÑO</th>
        <th style='font-weight:bold; background-color:#f1c232'>TIPO PARTICIPANTE/INSTRUCTOR</th>
        <th style='font-weight:bold; background-color:#f1c232'>NOMBRE</th>
        <th style='font-weight:bold; background-color:#f1c232'>CURSO</th>
        <th style='font-weight:bold; background-color:#f1c232'>SEMIPERIODO</th>
        <th style='font-weight:bold; background-color:#f1c232'>FECHA DE ENVÍO</th>
        <th style='font-weight:bold; background-color:#f1c232'>EMITIDA POR</th>
    </tr>
    </thead>
    <tbody>
      <tr>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
      </tr>
    @foreach($usuarios as $usuario)
      <tr>
        @if(get_class($usuario) == 'App\ProfesoresCurso')
          <td style='background-color:#ca6464'>{{$usuario->folio_inst}}</td>
          <td>{{$usuario->folio_peque}}</td>
          <td>INSTRUCTOR</td>
        @else
          <td style='background-color:#CFE2F3'>{{$usuario->folio_inst}}</td>
          <td>{{$usuario->folio_peque}}</td>
          <td>PARTICIPANTE</td>
        @endif
        <td style='background-color:yellow'>{{$usuario->nombre}}</td>
        <td>{{$usuario->nombre_catalogo}}</td>
        <td>{{$usuario->semiperiodo}}</td>
        <td>{{$usuario->fecha_envio_reconocimiento}}</td>
        <td>{{$usuario->emision}}</td>
      </tr>
    @endforeach
    </tbody>
</html>