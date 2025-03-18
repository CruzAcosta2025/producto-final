@extends('layouts.admin-centro')

@section('title', 'Historial Clínico')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-10">
    <h2 class="text-3xl font-bold text-gray-950 mb-6">Historial Clínico</h2>

    <!-- Formulario de búsqueda de paciente por DNI -->
    <form action="{{ route('historial.index') }}" method="GET" class="mb-4 flex items-center space-x-4">
        <label for="dni" class="text-lg font-medium text-gray-700">Buscar:</label>
        <input type="text" name="dni" id="dni" placeholder="Ingresar DNI" required
            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
        <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition duration-300">Buscar</button>
    </form>

    <!-- Si se encuentra un paciente, mostrar su información -->
    @if (isset($paciente))
    <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Información del Paciente</h3>
        <p><strong>Nombre:</strong> {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}</p>
        <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
        <p><strong>Fecha de Nacimiento:</strong> {{ $paciente->fecha_nacimiento }}</p>
        <p><strong>Centro Médico:</strong> {{ Auth::user()->centroMedico->nombre }}</p>

        <!-- Mostrar opciones según si tiene o no historial clínico -->
        @if ($paciente->historialClinico->isNotEmpty())
        <a href="{{ route('historial.show', $paciente->historialClinico->first()->id_historial) }}"
            class="inline-block mt-4 px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition duration-300">
            Ver Historial Clínico
        </a>
        @else
        <form action="{{ route('historial.store.paciente', ['idPaciente' => $paciente->id_paciente]) }}" method="POST">
            @csrf
            <button type="submit" class="inline-block mt-4 px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition duration-300">
                Crear Historial Clínico
            </button>
        </form>
        @endif
    </div>
    @elseif(isset($dni))
    <p class="text-red-600 font-medium">No se encontró ningún paciente con el DNI {{ $dni }}.</p>
    @endif

    <!-- Tabla de todos los historiales clínicos -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-orange-100 border border-orange-600 rounded-lg shadow-md">
            <thead class="bg-orange-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left border border-orange-700 text-center">ID Historial</th>
                    <!-- <th class="px-6 py-3 text-left border border-orange-700 text-center">Paciente</th> -->
                    <th class="px-6 py-3 text-left border border-orange-700 text-center">Fecha de Creación</th>
                    <th class="px-6 py-3 text-left border border-orange-700 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiales as $historial)
                <tr class="border border-orange-500 hover:bg-orange-200 transition">
                    <td class="px-6 py-4 border border-orange-500 text-center">{{ $historial->id_historial }}</td>
                    @if($historial->paciente)
                    <p>Paciente: {{ $historial->paciente->primer_nombre }} {{ $historial->paciente->primer_apellido }} {{ $historial->paciente->segundo_apellido }}</p>
                    @else
                    <p><strong>Paciente no encontrado</strong></p>
                    @endif
                    <td class="px-6 py-4 border border-orange-500 text-center">{{ $historial->fecha_creacion }}</td>
                    <td class="px-3 py-2 flex flex-wrap justify-center gap-2">

                        <a href="{{ route('historial.show', $historial->id_historial) }}"
                            class="bg-amber-700 text-white px-3 py-2 rounded-md hover:bg-amber-800 transition">Ver</a>
                        <a href="{{ route('historial.edit', $historial->id_historial) }}"
                            class="bg-blue-700 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">Editar</a>
                        <form action="{{ route('historial.destroy', $historial->id_historial) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md border border-black">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection