@extends($layout)
@section('title', 'Vista Previa de Factura')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white border rounded-lg shadow-md">
    <div class="text-center mb-6">
        <!-- Logo del centro médico con ajuste de tamaño -->
        @if (Auth::user()->centroMedico->logo)
        <img src="{{ asset('storage/' . Auth::user()->centroMedico->logo) }}" alt="Logo Centro Médico"
            class="mx-auto h-40 w-40 mb-4">
        @endif
        <!-- Información del centro médico -->
        <h2 class="text-xl font-semibold">{{ Auth::user()->centroMedico->nombre ?? 'Centro Médico' }}</h2>
        <p><strong>RUC:</strong> {{ Auth::user()->centroMedico->ruc ?? 'N/A' }}</p>
        <p><strong>Dirección:</strong> {{ Auth::user()->centroMedico->direccion ?? 'N/A' }}</p>
    </div>

    <!-- Detalles de la factura -->
    <h3 class="text-center text-lg font-bold">Factura #{{ $factura->id_factura }}</h3>

    <div class="mb-6">
        <p><strong>Paciente:</strong> {{ $factura->paciente->primer_nombre }} {{ $factura->paciente->primer_apellido }}</p>
        <p><strong>DNI:</strong> {{ $factura->paciente->dni }}</p>
        <p><strong>Fecha:</strong> {{ $factura->fecha_factura }}</p>
        <p><strong>Atendido por:</strong> {{ $factura->personalMedico->usuario->nombre ?? 'Sin asignar' }}</p>
    </div>

    <!-- Tabla de servicios -->
    <table class="w-full border border-gray-300 mb-6">
        <thead>
            <tr class="bg-rose-800 text-white">
                <th class="border border-gray-300 p-2 text-center">Servicio</th>
                <th class="border border-gray-300 p-2 text-center">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($factura->servicios as $servicio)
            <tr>
                <td class="border border-gray-300 p-2">{{ $servicio->servicio->nombre_servicio }}</td>
                <td class="border border-gray-300 p-2 text-center">S/ {{ number_format($servicio->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="border border-gray-300 p-2 font-semibold">Subtotal:</td>
                <td class="border border-gray-300 p-2 text-center">S/ {{ number_format($factura->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="border border-gray-300 p-2 font-semibold">Impuesto (18%):</td>
                <td class="border border-gray-300 p-2 text-center">S/ {{ number_format($factura->impuesto, 2) }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="border border-gray-300 p-2 font-bold">Total:</td>
                <td class="border border-gray-300 p-2 text-center font-bold">S/ {{ number_format($factura->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Formulario para cambiar tamaño de hoja -->
    <form action="{{ route('caja.verFactura', ['id' => $factura->id_factura]) }}" method="GET" class="mb-6">
        <label for="tamaño" class="block font-semibold">Seleccionar tamaño de hoja:</label>
        <select name="tamaño" id="tamaño" class="border p-2 rounded w-full" onchange="this.form.submit()">
            <option value="A4" {{ $tamaño === 'A4' ? 'selected' : '' }}>A4</option>
            <option value="A5" {{ $tamaño === 'A5' ? 'selected' : '' }}>A5</option>
            <option value="Ticket" {{ $tamaño === 'Ticket' ? 'selected' : '' }}>Ticket</option>
        </select>
    </form>

    <!-- Visor de PDF embebido -->
    <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}" class="w-full h-96 border-none"></iframe>
</div>
@endsection