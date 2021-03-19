<html>
<table>
    <thead>
    <tr style='background-color: #575757;'>
        <th>cve_curso</th>
        <th>semestre</th>
        <th>RFC_profesor</th>
        <th>Nombre Completo</th>
        <th>Categoria y nivel</th>
        <th>División secretaría</th>
        <th>Nombre del curso</th>
        <th>Duración del curso</th>
        <th>Fecha inicio</th>
        <th>Fecha fin</th>
        <th>Confirmó</th>
        <th>Asistió</th>
        <th>Acreditó</th>
        <th>Causa de no acreditación</th>
        <th>Canceló</th>
        <th>Lista de espera</th>
        <th>Orden de lista de espera</th>
        <th>Calificación</th>
        <th>Cancelado</th>
        <th>Correo electrónico</th>
        <th>Teléfono</th>
        <th>División secretaría U</th>
        <th>Edad</th>
        <th>Rango de edades</th>
    </tr>
    </thead>
    <tbody>
    @foreach($registros as $registro)
        <tr>
            <td>{{ $registro->clave }}</td>
            <td>{{ $registro->semestre }}</td>
            <td>{{ $registro->rfc }}</td>
            <td>{{ $registro->nombre }}</td>
            <td>{{ $registro->categoria }}</td>
            <td>{{ $registro->nombrec }}</td>
            <td>{{ $registro->duracion }}</td>
            <td>{{ $registro->fecha_inicio }}</td>
            <td>{{ $registro->fecha_fin }}</td>
            @if ($registro->confirmacion == 1)
                <td>VERDADERO</td>
            @else
                <td>FALSO</td>
            @endif
            @if ($registro->asistencia == 1)
                <td>VERDADERO</td>
            @else
                <td>FALSO</td>
            @endif
            @if ($registro->acreditacion == 1)
                <td>VERDADERO</td>
            @else
                <td>FALSO</td>
            @endif
            <td>{{ $registro->causa }}</td>
            @if ($registro->cancelacion == 1)
                <td>VERDADERO</td>
            @else
                <td>FALSO</td>
            @endif
            @if ($registro->lista == 1)
                <td>VERDADERO</td>
            @else
                <td>FALSO</td>
            @endif
            <td>{{ $registro->num_lista }}</td>
            <td>{{ $registro->calificacion }}</td>
            @if ($registro->cancelacion == 1)
                <td>VERDADERO</td>
            @else
                <td>FALSO</td>
            @endif
            <td>{{ $registro->email }}</td>
            <td>{{ $registro->telefono }}</td>
            <td>{{ $registro->edad }}</td>
            @if ($registro->edad >= 21 && $registro->edad <= 29)
                <td>21-29</td>
            @elseif ($registro->edad >= 31 && $registro->edad <= 39)
                <td>31-39</td>
            @elseif ($registro->edad >= 41 && $registro->edad <= 49)
                <td>41-49</td>
            @elseif ($registro->edad >= 51 && $registro->edad <= 59)
                <td>51-59</td>
            @elseif ($registro->edad >= 61 && $registro->edad <= 69)
                <td>61-69</td>
            @elseif ($registro->edad >= 70)
                <td>70 o mayor</td>
            @else
                <td>ERROR</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
</html>