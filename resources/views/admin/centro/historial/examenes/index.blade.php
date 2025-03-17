@extends('layouts.admin-centro')

@section('title', 'Exámenes Médicos')

@section('content')
<div class="max-w-3xl mx-auto p-6 w-11/12">
    <div class="bg-white border-2 border-black rounded-lg shadow-lg">
        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-teal-500 to-teal-900 p-5 rounded-t-lg">
            <h2 class="text-white text-xl md:text-2xl font-bold">Exámenes Médicos</h2>
        </div>

        <!-- Formulario de Búsqueda -->
        <div class="p-6">
            <form action="{{ route('examenes.buscar') }}" method="GET" class="mb-4">
                @csrf
                <label for="dni" class="block font-bold text-gray-800 mb-1">Buscar por DNI del Paciente:</label>
                <input type="text" id="dni" name="dni" class="w-full p-3 border border-black rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500" placeholder="Ingrese DNI" required>
                <button type="submit" class="mt-3 px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-lg border border-black">Buscar</button>
            </form>
        </div>

        @if ($historial)
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-800">Paciente: {{ $historial->paciente->primer_nombre }} {{ $historial->paciente->primer_apellido }}</h3>
            <ul class="mt-4 space-y-2">
                @foreach ($examenes as $examen)
                    <li class="p-3 bg-gray-100 border border-black rounded-md flex justify-between items-center">
                        <span class="font-semibold">{{ $examen->tipo_examen }}</span> - <span>{{ $examen->fecha_examen }}</span>
                        <a href="{{ route('examenes.edit', [$historial->id_historial, $examen->id_examen]) }}" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg border border-black">Editar</a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('examenes.create', $historial->id_historial) }}" class="mt-4 px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-lg border border-black block text-center">Agregar Examen</a>
        </div>
        @endif

        <div class="p-6 flex justify-end">
            <a href="{{ route('historial.show', $historial->id_historial ?? 0) }}" class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg border border-black">Regresar al Historial</a>
        </div>
    </div>
</div>
@endsection
