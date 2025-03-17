@extends('layouts.admin-centro')

@section('title', 'Detalle del Reporte')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Encabezado -->
        <div style="background: linear-gradient(to right, #3b82f6, #1d4ed8); padding: 20px;">
            <h2 style="color: #ffffff; margin: 0; text-align: center; font-size: 1.5rem;">
                {{ $reporte->tipo_reporte }} ({{ $reporte->fecha_reporte }})
            </h2>
            <p style="color: #dbeafe; text-align: center; font-size: 1rem; margin: 10px 0 0;">
                {{ $reporte->descripcion }}
            </p>
        </div>

        <!-- Contenido del Reporte -->
        <div style="padding: 20px;">
            @if($reporte->tipo_reporte === 'Facturación')
                <div style="margin-bottom: 20px;">
                    <h3 style="color: #3b82f6; font-size: 1.25rem;">Total Facturado</h3>
                    <p style="font-size: 1.1rem; font-weight: bold;">S/ {{ number_format($contenido['total_facturado'], 2) }}</p>
                </div>
                <div>
                    <h3 style="color: #3b82f6; font-size: 1.25rem;">Detalle de Facturas</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <thead>
                            <tr style="background-color: #f3f4f6;">
                                <th style="padding: 8px; text-align: left;">Fecha</th>
                                <th style="padding: 8px; text-align: left;">Paciente</th>
                                <th style="padding: 8px; text-align: left;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contenido['detalle'] as $factura)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 8px;">{{ $factura['fecha_factura'] }}</td>
                                    <td style="padding: 8px;">{{ $factura['paciente'] }}</td>
                                    <td style="padding: 8px;">S/ {{ number_format($factura['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($reporte->tipo_reporte === 'IngresosEgresos')
                <div style="margin-bottom: 20px;">
                    <h3 style="color: #3b82f6; font-size: 1.25rem;">Resumen Financiero</h3>
                    <p><strong>Ingresos:</strong> S/ {{ number_format($contenido['ingresos'], 2) }}</p>
                    <p><strong>Egresos:</strong> S/ {{ number_format($contenido['egresos'], 2) }}</p>
                    <p><strong>Ganancia:</strong> S/ {{ number_format($contenido['ganancia'], 2) }}</p>
                </div>
            @elseif($reporte->tipo_reporte === 'ServiciosMasSolicitados')
                <div>
                    <h3 style="color: #3b82f6; font-size: 1.25rem;">Servicios Más Solicitados</h3>
                    <table>
                        <thead>
                            <tr style="background-color: #f3f4f6;">
                                <th style="padding: 8px; text-align: left;">Servicio</th>
                                <th style="padding: 8px; text-align: left;">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contenido['detalle'] as $servicio)
                                <tr>
                                    <td style="padding: 8px;">{{ $servicio['servicio'] }}</td>
                                    <td style="padding: 8px;">{{ $servicio['cantidad'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($reporte->tipo_reporte === 'PacientesAtendidos')
                <div>
                    <h3 style="color: #3b82f6; font-size: 1.25rem;">Pacientes Atendidos</h3>
                    <table>
                        <thead>
                            <tr style="background-color: #f3f4f6;">
                                <th style="padding: 8px; text-align: left;">Nombre</th>
                                <th style="padding: 8px; text-align: left;">DNI</th>
                                <th style="padding: 8px; text-align: left;">Servicios Recibidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contenido['detalle'] as $paciente)
                                <tr>
                                    <td style="padding: 8px;">{{ $paciente['paciente']['nombre'] }}</td>
                                    <td style="padding: 8px;">{{ $paciente['paciente']['dni'] }}</td>
                                    <td style="padding: 8px;">
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
                </div>
            @endif
        </div>

        <!-- Botones -->
        <div style="display: flex; gap: 15px; margin: 20px;">
            <!-- Exportar a PDF -->
            <form action="{{ route('reportes.exportar.pdf', $reporte->id_reporte) }}" method="POST">
                @csrf
                <button type="submit"
                    style="background-color: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                    Exportar a PDF
                </button>
            </form>
            <!-- Exportar a Excel (deshabilitado) -->
            <button type="button"
                style="background-color: #6b7280; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: not-allowed;">
                Exportar a Excel (deshabilitado)
            </button>
        </div>
    </div>
</div>
@endsection
