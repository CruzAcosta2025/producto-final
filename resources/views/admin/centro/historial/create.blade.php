@extends('layouts.admin-centro')

@section('title', 'Crear Historial Clínico')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-10 border border-gray-200">
    <h2 class="text-3xl font-bold text-gray-950 mb-6">Crear Historial Clínico</h2>

    <form action="{{ route('historial.store', ['idPaciente' => $paciente->id_paciente]) }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="fecha_creacion" class="block text-lg font-medium text-gray-700">Fecha de Creación</label>
            <input type="date" name="fecha_creacion" id="fecha_creacion" required
                class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-lime-500 transition duration-300">
        </div>

        <div class="flex space-x-4">
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300">
                Guardar Historial
            </button>
            <a href="{{ route('historial.index') }}"
                class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-400 transition duration-300">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
