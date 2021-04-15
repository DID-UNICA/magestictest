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
    @foreach($registros as $registro)
    <tr>
      <td>{{ $registro['folio'] }}</td>
      <td>{{ $registro['tipo'] }}</td>
      <td>{{ $registro['nombre'] }}</td>
      <td>{{ $registro['curso'] }}</td>
      <td>{{ $registro['semiperiodo'] }}</td>
      <td>{{ $registro['fecha_envio'] }}</td>
      <td>{{ $registro['emision'] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</html>