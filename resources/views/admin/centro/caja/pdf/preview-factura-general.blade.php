@extends($layout)

@section('title', 'Vista Previa de Factura General')

@section('content')
<!-- NO SE ESTA USANDO ESTA VISTA -->
<div
    style="max-width: 1000px; margin: auto; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <!-- Logo del centro médico -->
        @if (Auth::user()->centroMedico->logo)
        <img src="{{ asset('storage/' . Auth::user()->centroMedico->logo) }}" alt="Logo Centro Médico"
            style="max-height: 200px; max-width: 200px; margin-bottom: 20px;">
        @endif

        <!-- Información del centro médico -->
        <h2>{{ Auth::user()->centroMedico->nombre ?? 'Centro Médico' }}</h2>
        <p><strong>RUC:</strong> {{ Auth::user()->centroMedico->ruc ?? 'N/A' }}</p>
        <p><strong>Dirección:</strong> {{ Auth::user()->centroMedico->direccion ?? 'N/A' }}</p>
    </div>

    <!-- Detalles del paciente -->
    <h3 style="text-align: center; margin-bottom: 20px;">Factura General</h3>
    <div style="margin-bottom: 20px;">
        <p><strong>Paciente:</strong> {{ $facturas->first()->paciente->primer_nombre }}
            {{ $facturas->first()->paciente->primer_apellido }}
        </p>
        <p><strong>DNI:</strong> {{ $facturas->first()->paciente->dni }}</p>
        <p><strong>Fecha:</strong> {{ now()->format('Y-m-d H:i') }}</p>
    </div>

    <!-- Tabla de facturas -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;">
        <thead>
            <tr style="background: #004643; color: #fff;">
                <th style="padding: 10px; border: 1px solid #ddd;">#</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Fecha</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Servicio</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Atendido por</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Subtotal</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Impuesto</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $factura)
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $factura->id_factura }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $factura->fecha_factura }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    @if ($factura->servicios->isNotEmpty())
                    {{ $factura->servicios->first()->servicio->nombre_servicio }}
                    @else
                    No asignado
                    @endif
                </td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    {{ $factura->personalMedico->usuario->nombre ?? 'N/A' }}
                </td>
                <td style="padding: 10px; border: 1px solid #ddd;">S/ {{ number_format($factura->subtotal, 2) }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">S/ {{ number_format($factura->impuesto, 2) }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">S/ {{ number_format($factura->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #f2f2f2;">
                <td colspan="4" style="padding: 10px; border: 1px solid #ddd; text-align: right;">
                    <strong>Total General:</strong>
                </td>
                <td colspan="3" style="padding: 10px; border: 1px solid #ddd; text-align: right;">
                    S/ {{ number_format($facturas->sum('total'), 2) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Formulario para cambiar tamaño de hoja -->
    <form id="form-tamaño-hoja" action="{{ route('caja.generarFacturaGeneral') }}" method="POST"
        style="margin-bottom: 20px;">
        @csrf
        <input type="hidden" name="facturas" value="{{ $facturas->pluck('id_factura')->implode(',') }}">
        <label for="tamaño">Seleccionar tamaño de hoja:</label>
        <select name="tamaño" id="tamaño" style="margin-right: 10px;" onchange="document.getElementById('form-tamaño-hoja').submit();">
            <option value="A4" {{ $tamaño === 'A4' ? 'selected' : '' }}>A4</option>
            <option value="A5" {{ $tamaño === 'A5' ? 'selected' : '' }}>A5</option>
            <option value="Ticket" {{ $tamaño === 'Ticket' ? 'selected' : '' }}>Ticket</option>
        </select>
    </form>

    <!-- Visor de PDF embebido -->
    <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}"
        style="width: 100%; height: 600px; border: none;"></iframe>
</div>
@endsection