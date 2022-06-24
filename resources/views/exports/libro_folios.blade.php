<html>
<table>
    <thead>
    <tr>
        <th style='font-weight:bold; background-color:#f1c232'>FOLIO INSTITUCIONAL</th>
        <th style='font-weight:bold; background-color:#f1c232'>FOLIO PEQUEÑO</th>
        <th style='font-weight:bold; background-color:#f1c232'>TIPO PARTICIPANTE/INSTRUCTOR</th>
        <th style='font-weight:bold; background-color:#f1c232'>NOMBRE</th>
        <th style='font-weight:bold; background-color:#f1c232'>NOMBRAMIENTO</th>
        <th style='font-weight:bold; background-color:#f1c232'>CLAVE DE CURSO</th>
        <th style='font-weight:bold; background-color:#f1c232'>CURSO</th>
        <th style='font-weight:bold; background-color:#f1c232'>FECHA DE INICIO</th>
        <th style='font-weight:bold; background-color:#f1c232'>FECHA DE FIN</th>
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
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
        <td style='background-color:#339b43'></td>
      </tr>
    @foreach($usuarios as $usuario)
      <tr>
        @if($usuario->type === 'COORDINADOR')
          <td style='background-color:#ca6464'>{{$usuario->folio_inst}}</td>
          <td>{{$usuario->folio_peque}}</td>
          <td>COORDINADOR</td>
        @elseif($usuario->type === 'INSTRUCTOR')
          <td style='background-color:#ca6464'>{{$usuario->folio_inst}}</td>
          <td>{{$usuario->folio_peque}}</td>
          <td>INSTRUCTOR</td>
        @else
          <td style='background-color:#CFE2F3'>{{$usuario->folio_inst}}</td>
          <td>{{$usuario->folio_peque}}</td>
          <td>PARTICIPANTE</td>
        @endif
        <td style='background-color:yellow'>{{$usuario->nombre}}</td>
        <td>{{$usuario->categoria}}</td>
        <td>{{$usuario->clave}}</td>
        <td>{{$usuario->nombre_catalogo}}</td>
        <td>{{$usuario->fecha_inicio}}</td>
        <td>{{$usuario->fecha_fin}}</td>
        <td>{{$usuario->semiperiodo}}</td>
        <td>{{$usuario->fecha_envio}}</td>
        <td>{{$usuario->emision}}</td>
      </tr>
    @endforeach
    </tbody>
</html>