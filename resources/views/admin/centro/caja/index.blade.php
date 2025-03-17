@extends('layouts.admin-centro')
@section('title', 'Gestión de Facturas')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Listado de Facturas</h2>

    <!-- Buscador -->
    <form action="{{ route('caja.index') }}" method="GET" class="mb-6 flex flex-wrap gap-4">
        <input type="text" name="dni" value="{{ request('dni') }}" placeholder="Buscar por DNI"
            class="flex-1 p-3 border border-gray-950 rounded-lg focus:ring-2 focus:ring-rose-500 focus:outline-none">
        <button type="submit"
            class="bg-rose-600 text-white px-6 py-3 rounded-lg hover:bg-rose-700 transition">Buscar</button>
    </form>

    @if ($dni && !$paciente)
    <p class="text-center text-red-500 mb-6">El paciente con DNI <strong>{{ $dni }}</strong> no se encuentra registrado.</p>
    @endif

    @if ($paciente)
    <!-- Información del Paciente -->
    <div class="bg-white p-5 rounded-lg shadow-md border mb-6">
        <p class="font-semibold">Paciente Encontrado:</p>
        <p><strong>Nombre:</strong> {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</p>
        <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
        <div class="mt-4">
            <a href="{{ route('caja.crearFactura', ['id_paciente' => $paciente->id_paciente]) }}"
                class="bg-rose-600 text-white px-6 py-3 rounded-lg hover:bg-rose-700 transition">
                Crear Nueva Factura
            </a>
        </div>
    </div>
    @endif

    <!-- Botón para generar factura general 
    <form id="form-generar-factura-general" action="{{ route('caja.generarFacturaGeneral') }}" method="POST" class="mb-4">
        @csrf
        <input type="hidden" name="facturas" id="facturas-hidden">
        <button id="btn-generar-factura-general" type="submit" disabled
            class="bg-green-600 text-white px-6 py-3 rounded-lg opacity-50 cursor-not-allowed transition">
            Generar Factura General
        </button>
    </form> -->

    @if ($facturas->isNotEmpty())
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-left text-sm bg-white border border-rose-200">
            <thead class="bg-rose-600 text-white">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Paciente</th>
                    <th class="p-4">DNI</th>
                    <th class="p-4">Personal Médico</th>
                    <th class="p-4">Servicio</th>
                    <th class="p-4">Método de Pago</th>
                    <th class="p-4 text-center">Estado</th>
                    <th class="p-4 text-right">Subtotal</th>
                    <th class="p-4 text-right">Impuesto</th>
                    <th class="p-4 text-right">Total</th>
                    <th class="p-4 text-center sticky right-0 bg-rose-600 z-10">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                <tr class="border-b border-rose-200">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="factura-checkbox w-5 h-5" name="facturas[]"
                            value="{{ $factura->id_factura }}" data-paciente="{{ $factura->id_paciente }}">
                    </td>
                    <td class="p-4">{{ $factura->fecha_factura }}</td>
                    <td class="p-4">{{ $factura->paciente->primer_nombre }} {{ $factura->paciente->primer_apellido }}</td>
                    <td class="p-4">{{ $factura->paciente->dni }}</td>
                    <td class="p-4">{{ $factura->personalMedico->usuario->nombre ?? 'N/A' }}</td>
                    <td class="p-4">{{ $factura->servicios->first()->servicio->nombre_servicio ?? 'No asignado' }}</td>
                    <td class="p-4">{{ ucfirst(strtolower($factura->metodo_pago ?? 'No definido')) }}</td>
                    <td class="p-4 text-center">{{ ucfirst(strtolower($factura->estado_pago)) }}</td>
                    <td class="p-4 text-right">S/ {{ number_format($factura->subtotal, 2) }}</td>
                    <td class="p-4 text-right">S/ {{ number_format($factura->impuesto, 2) }}</td>
                    <td class="p-4 text-right">S/ {{ number_format($factura->total, 2) }}</td>
                    <td class="p-4 text-center bg-white sticky right-0 z-10">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('caja.verFactura', $factura->id_factura) }}"
                                class="bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 text-xs">Ver</a>
                            <a href="{{ route('caja.editarFactura', $factura->id_factura) }}"
                                class="bg-yellow-500 text-black px-3 py-2 rounded-lg hover:bg-yellow-600 text-xs">Editar</a>
                            <form action="{{ route('caja.eliminarFactura', $factura->id_factura) }}" method="POST" onsubmit="return confirmacionEliminar(event)" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 text-xs">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif

    <div class="mt-6 flex justify-center">{{ $facturas->links() }}</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.factura-checkbox');
        const btnGenerar = document.getElementById('btn-generar-factura-general');
        const facturasHiddenInput = document.getElementById('facturas-hidden');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);
                const pacientes = [...new Set(selected.map(cb => cb.dataset.paciente))];
                btnGenerar.disabled = selected.length === 0;
                btnGenerar.classList.toggle('opacity-50', selected.length === 0);
                btnGenerar.classList.toggle('cursor-not-allowed', selected.length === 0);
                facturasHiddenInput.value = selected.map(cb => cb.value).join(',');
            });
        });
    });
</script>
@endsection