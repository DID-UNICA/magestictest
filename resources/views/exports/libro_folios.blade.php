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
    @foreach($cursos as $curso)
      @foreach($curso->instructores as $instructor)
      <tr>
        <td style='background-color:#ca6464'>{{$instructor->folio_inst}}</td>
        <td>{{$instructor->folio_peque}}</td>
        <td>INSTRUCTOR</td>
        <td style='background-color:yellow'>{{$instructor->nombre}}</td>
        <td>{{$curso->nombre_catalogo}}</td>
        <td>{{$curso->semiperiodo}}</td>
        <td>{{$curso->fecha_envio_reconocimiento}}</td>
        <td>{{$curso->emision}}</td>
      </tr>
      @endforeach
      @foreach($curso->participantes as $participante)
        <tr>
          <td style='background-color:#CFE2F3'>{{$participante->folio_inst}}</td>
          <td>{{$instructor->folio_peque}}</td>
          <td>PARTICIPANTE</td>
          <td style='background-color:yellow'>{{$participante->nombre}}</td>
          <td>{{$curso->nombre_catalogo}}</td>
          <td>{{$curso->semiperiodo}}</td>
          <td>{{$curso->fecha_envio_constancia}}</td>
          <td>{{$curso->emision}}</td>
        </tr>
      @endforeach
    @endforeach
    </tbody>
</html>