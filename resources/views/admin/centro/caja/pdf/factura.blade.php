<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $factura->id_factura }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header img {
            max-height: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado con logo e información del centro -->
        <div class="header">
            @if (Auth::user()->centroMedico->logo)
            <img src="{{ public_path('storage/' . Auth::user()->centroMedico->logo) }}" alt="Logo Centro Médico"
                style="max-height: 150px; max-width: 150px; margin-bottom: 10px;">
            @endif
            <h2>{{ Auth::user()->centroMedico->nombre ?? 'Centro Médico' }}</h2>
            <p><strong>RUC:</strong> {{ Auth::user()->centroMedico->ruc ?? 'N/A' }}</p>
            <p><strong>Dirección:</strong> {{ Auth::user()->centroMedico->direccion ?? 'N/A' }}</p>
        </div>

        <!-- Detalles de la factura -->
        <div class="details">
            <p><strong>Factura #:</strong> {{ $factura->id_factura }}</p>
            <p><strong>Paciente:</strong> {{ $factura->paciente->primer_nombre }}
                {{ $factura->paciente->primer_apellido }}
            </p>
            <p><strong>DNI:</strong> {{ $factura->paciente->dni }}</p>
            <p><strong>Fecha:</strong> {{ $factura->fecha_factura }}</p>
            <p><strong>Atendido por:</strong> {{ $factura->personalMedico->usuario->nombre ?? 'Sin asignar' }}</p>
        </div>

        <!-- Tabla de servicios -->
        <table>
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factura->servicios as $servicio)
                <tr>
                    <td>{{ $servicio->servicio->nombre_servicio }}</td>
                    <td>S/ {{ number_format($servicio->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td>S/ {{ number_format($factura->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Impuesto (18%):</strong></td>
                    <td>S/ {{ number_format($factura->impuesto, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td>S/ {{ number_format($factura->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Pie de página -->
        <div class="footer">
            <p>Gracias por confiar en {{ Auth::user()->centroMedico->nombre ?? 'nuestro centro médico' }}.</p>
        </div>
    </div>
</body>

</html>