@extends('layouts.admin-centro')

@section('title', 'Crear Factura')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-8">
    <div class="bg-white rounded-xl shadow-lg border-2 border-black p-6">
        <div class="bg-rose-700 text-white py-4 px-6 rounded-t-lg">
            <h2 class="text-3xl font-semibold text-center">Crear Factura</h2>
        </div>

        @if ($errors->any())
        <div class="mt-4 p-4 bg-red-100 text-red-700 border-2 border-red-500 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('caja.storeFactura') }}" method="POST" class="mt-6 space-y-6">
            @csrf

            <!-- Datos del Paciente -->
            <div class="border-b-2 border-black pb-4">
                <h3 class="text-xl font-semibold text-gray-900">Datos del Paciente</h3>
                <p><strong>Nombre:</strong> {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</p>
                <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
                <input type="hidden" name="id_paciente" value="{{ $paciente->id_paciente }}">
            </div>

            <!-- Selección de Médico -->
            <div>
                <label for="id_personal_medico" class="block font-semibold text-gray-900">Médico:</label>
                <select name="id_personal_medico" id="id_personal_medico" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="" selected disabled>Seleccione un médico</option>
                    @foreach ($medicos->groupBy('especialidad.nombre_especialidad') as $especialidad => $medicosGrupo)
                    <optgroup label="{{ $especialidad ?? 'Sin especialidad' }}">
                        @foreach ($medicosGrupo as $medico)
                        <option value="{{ $medico->id_personal_medico }}">
                            {{ $medico->usuario->nombre ?? 'Nombre no disponible' }}
                        </option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>

            <!-- Selección de Servicio -->
            <div>
                <label for="id_servicio" class="block font-semibold text-gray-900">Servicio:</label>
                <select name="id_servicio" id="id_servicio" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="" selected disabled>Seleccione un servicio</option>
                    @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id_servicio }}">
                        {{ $servicio->nombre_servicio }} - S/ {{ number_format($servicio->precio, 2) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Método de Pago -->
            <div>
                <label for="metodo_pago" class="block font-semibold text-gray-900">Método de Pago:</label>
                <select name="metodo_pago" id="metodo_pago" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="" selected disabled>Seleccione el método de pago</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>

            <!-- Resumen -->
            <div class="border-b-2 border-black pb-4">
                <h3 class="text-xl font-semibold text-gray-900">Resumen</h3>
                <p class="text-gray-700">Nota: El subtotal, impuesto y total se calcularán automáticamente al guardar la factura.</p>
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <button type="submit"
                    class="px-6 py-3 bg-rose-500 text-white rounded-lg border-2 border-black hover:bg-rose-400">
                    Guardar Factura
                </button>
                <a href="{{ route('caja.index') }}"
                    class="px-6 py-3 bg-rose-500 text-white rounded-lg border-2 border-black hover:bg-rose-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection