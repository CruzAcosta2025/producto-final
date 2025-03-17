@extends('layouts.admin-centro')

@section('title', 'Editar Solicitud de Sangre')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-blue-900">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Solicitud de Sangre</h2>
        </div>

        <form action="{{ route('sangre.solicitudes.update', $solicitud->id_solicitud) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="paciente_nombre" class="block text-lg font-semibold text-gray-700">Nombre del Paciente:</label>
                <input type="text" id="paciente_nombre" name="paciente_nombre" value="{{ $solicitud->paciente_nombre }}" 
                       class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="tipo_sangre" class="block text-lg font-semibold text-gray-700">Tipo de Sangre:</label>
                <select id="tipo_sangre" name="tipo_sangre" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $tipo)
                        <option value="{{ $tipo }}" {{ $solicitud->tipo_sangre == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="cantidad" class="block text-lg font-semibold text-gray-700">Cantidad de Unidades:</label>
                <input type="number" id="cantidad" name="cantidad" value="{{ $solicitud->cantidad }}" min="1" max="10"
                       class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="motivo" class="block text-lg font-semibold text-gray-700">Motivo:</label>
                <textarea id="motivo" name="motivo" rows="4"
                          class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $solicitud->motivo }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Guardar
                </button>
                <a href="{{ route('sangre.solicitudes.index') }}" class="px-20 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
