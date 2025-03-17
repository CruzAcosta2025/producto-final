<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- NO SE ESTA USANDO ESTA VISTA -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura General - Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Ajuste para tickets */
            line-height: 1.2;
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
            margin-bottom: 10px;
        }

        .header img {
            max-height: 50px; /* Ajuste para tickets */
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 12px; /* Ajuste para tickets */
        }

        .header p {
            margin: 0;
            font-size: 10px;
        }

        .details {
            margin-bottom: 10px;
        }

        .details p {
            margin: 0;
        }

        .factura-item {
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }

        .factura-item p {
            margin: 2px 0;
        }

        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 10px;
        }

        .totales {
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        .totales p {
            margin: 3px 0;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            @if (Auth::user()->centroMedico->logo)
                <img src="{{ public_path('storage/' . Auth::user()->centroMedico->logo) }}" alt="Logo Centro Médico">
            @endif
            <h2>{{ Auth::user()->centroMedico->nombre ?? 'Centro Médico' }}</h2>
            <p><strong>RUC:</strong> {{ Auth::user()->centroMedico->ruc ?? 'N/A' }}</p>
            <p><strong>Dirección:</strong> {{ Auth::user()->centroMedico->direccion ?? 'N/A' }}</p>
        </div>

        <!-- Detalles -->
        <div class="details">
            <p><strong>Paciente:</strong> {{ $facturas->first()->paciente->primer_nombre }}
                {{ $facturas->first()->paciente->primer_apellido }}</p>
            <p><strong>DNI:</strong> {{ $facturas->first()->paciente->dni }}</p>
            <p><strong>Fecha:</strong> {{ now()->format('Y-m-d H:i') }}</p>
        </div>

        <!-- Listado de servicios por factura -->
        @foreach ($facturas as $factura)
            <div class="factura-item">
                <p><strong>Factura #{{ $factura->id_factura }}</strong></p>
                <p><strong>Fecha:</strong> {{ $factura->fecha_factura }}</p>
                @foreach ($factura->servicios as $servicio)
                    <p><strong>Servicio:</strong> {{ $servicio->servicio->nombre_servicio }}</p>
                    <p><strong>Atendido por:</strong> {{ $factura->personalMedico->usuario->nombre ?? 'N/A' }}</p>
                    <p><strong>Precio:</strong> S/ {{ number_format($servicio->subtotal, 2) }}</p>
                @endforeach
            </div>
        @endforeach

        <!-- Totales -->
        <div class="totales">
            <p><strong>Subtotal:</strong> S/ {{ number_format($facturas->sum('subtotal'), 2) }}</p>
            <p><strong>Impuesto (18%):</strong> S/ {{ number_format($facturas->sum('impuesto'), 2) }}</p>
            <p><strong>Total General:</strong> S/ {{ number_format($facturas->sum('total'), 2) }}</p>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>Gracias por confiar en {{ Auth::user()->centroMedico->nombre ?? 'nuestro centro médico' }}.</p>
        </div>
    </div>
</body>

</html>
