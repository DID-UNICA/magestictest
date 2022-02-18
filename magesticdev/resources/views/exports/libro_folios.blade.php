<html>
<table>
    <thead>
    <tr>
        <th>FOLIO</th>
        <th>TIPO PARTICIPANTE/INSTRUCTOR</th>
        <th>NOMBRE</th>
        <th>CURSO</th>
        <th>SEMIPERIODO</th>
        <th>FECHA DE ENVÍO</th>
        <th>EMITIDA POR</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cursos as $curso)
      @foreach($curso->instructores as $instructor)
      <tr>
      <td>{{$instructor->folio_inst}}</td>
        <td>INSTRUCTOR</td>
        <td>{{$instructor->nombre}}</td>
        <td>{{$curso->nombre_catalogo}}</td>
        <td>{{$curso->semiperiodo}}</td>
        <td>{{$curso->fecha_envio_reconocimiento}}</td>
        <td>{{$curso->emision}}</td>
      </tr>
      @endforeach
      @foreach($curso->participantes as $participante)
        <tr>
          <td>{{$participante->folio_inst}}</td>
          <td>PARTICIPANTE</td>
          <td>{{$participante->nombre}}</td>
          <td>{{$curso->nombre_catalogo}}</td>
          <td>{{$curso->semiperiodo}}</td>
          <td>{{$curso->fecha_envio_constancia}}</td>
          <td>{{$curso->emision}}</td>
        </tr>
      @endforeach
    @endforeach
    </tbody>
</html>