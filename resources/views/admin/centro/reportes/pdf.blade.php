<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte - {{ $reporte->tipo_reporte }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1, h2, h3 {
            color: #3b82f6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <h1>Reporte: {{ $reporte->tipo_reporte }}</h1>
    <p>{{ $reporte->descripcion }}</p>
    <p>Generado el: {{ $reporte->fecha_reporte }}</p>

    @if($reporte->tipo_reporte === 'Facturación')
        <h2>Total Facturado</h2>
        <p><strong>S/ {{ number_format($contenido['total_facturado'], 2) }}</strong></p>
        <h3>Detalle de Facturas</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Paciente</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contenido['detalle'] as $factura)
                    <tr>
                        <td>{{ $factura['fecha_factura'] }}</td>
                        <td>{{ $factura['paciente'] }}</td>
                        <td>S/ {{ number_format($factura['total'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($reporte->tipo_reporte === 'IngresosEgresos')
        <h2>Resumen Financiero</h2>
        <p><strong>Ingresos:</strong> S/ {{ number_format($contenido['ingresos'], 2) }}</p>
        <p><strong>Egresos:</strong> S/ {{ number_format($contenido['egresos'], 2) }}</p>
        <p><strong>Ganancia:</strong> S/ {{ number_format($contenido['ganancia'], 2) }}</p>
        <h3>Detalle de Transacciones</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contenido['detalle'] as $transaccion)
                    <tr>
                        <td>{{ $transaccion['fecha_transaccion'] }}</td>
                        <td>{{ $transaccion['tipo_transaccion'] }}</td>
                        <td>S/ {{ number_format($transaccion['monto'], 2) }}</td>
                        <td>{{ $transaccion['descripcion'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($reporte->tipo_reporte === 'ServiciosMasSolicitados')
        <h2>Servicios Más Solicitados</h2>
        <table>
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contenido['detalle'] as $servicio)
                    <tr>
                        <td>{{ $servicio['servicio'] }}</td>
                        <td>{{ $servicio['cantidad'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($reporte->tipo_reporte === 'PacientesAtendidos')
        <h2>Pacientes Atendidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Servicios Recibidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contenido['detalle'] as $paciente)
                    <tr>
                        <td>{{ $paciente['paciente']['nombre'] }}</td>
                        <td>{{ $paciente['paciente']['dni'] }}</td>
                        <td>
                            <ul>
                                @foreach($paciente['servicios'] as $servicio)
                                    <li>{{ $servicio['nombre_servicio'] }} ({{ $servicio['cantidad'] }})</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
