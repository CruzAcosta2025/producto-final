@extends('layouts.admin-centro')
@section('title', 'Detalle de Factura')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Detalle de Factura</h1>

    <div class="card">
        <div class="card-header bg-dark text-white">
            Información de la Factura
        </div>
        <div class="card-body">
            <p><strong>Fecha:</strong> {{ $factura->fecha_factura }}</p>
            <p><strong>Paciente:</strong> {{ $factura->paciente->primer_nombre }} {{ $factura->paciente->primer_apellido }}</p>
            <p><strong>Médico:</strong> {{ $factura->personalMedico->usuario->nombre ?? 'No asignado' }}</p>
            <p><strong>Total:</strong> S/ {{ number_format($factura->total, 2) }}</p>
            <p><strong>Estado de Pago:</strong> {{ ucfirst($factura->estado_pago) }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Servicios Asociados
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->servicio->nombre }}</td>
                        <td>{{ $servicio->cantidad }}</td>
                        <td>S/ {{ number_format($servicio->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
