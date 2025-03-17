<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Consulta</title>
</head>
<body>
    <h1>Datos del DNI</h1>
    @if (isset($datos['error']))
        <p>Error: {{ $datos['error'] }}</p>
    @else
        <p><strong>DNI:</strong> {{ $datos['numeroDocumento'] }}</p>
        <p><strong>Nombre Completo:</strong> {{ $datos['nombre'] }}</p>
        <p><strong>Apellido Paterno:</strong> {{ $datos['apellidoPaterno'] }}</p>
        <p><strong>Apellido Materno:</strong> {{ $datos['apellidoMaterno'] }}</p>
        <p><strong>Nombres:</strong> {{ $datos['nombres'] }}</p>
    @endif
</body>
</html>
