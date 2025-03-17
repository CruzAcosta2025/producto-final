@extends('layouts.admin-centro')

@section('title', 'Registrar Receta')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-rose-500 to-red-600 p-5 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Registrar Receta</h2>
    </div>

    <!-- Contenido del Formulario -->
    <div class="p-6">
        <form action="{{ route('recetas.store', $historial->id_historial) }}" method="POST">
            @csrf

            <!-- Selección del Médico -->
            <div class="mb-4">
                <label for="id_medico" class="block font-bold text-gray-800 mb-1">Médico</label>
                <select name="id_medico" id="id_medico"
                    class="w-full p-3 border border-black rounded-md bg-red-100 focus:ring-2 focus:ring-red-500">
                    <option value="">Seleccione un médico</option>
                    @foreach ($personalMedico as $medico)
                    <option value="{{ $medico->id_personal_medico }}">
                        {{ $medico->usuario->nombre }} - {{ $medico->especialidad->nombre_especialidad ?? 'Sin Especialidad' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha de la Receta -->
            <div class="mb-4">
                <label for="fecha_receta" class="block font-bold text-gray-800 mb-1">Fecha de la Receta</label>
                <input type="date" name="fecha_receta" id="fecha_receta" value="{{ old('fecha_receta') }}" required
                    class="w-full p-3 border border-black rounded-md bg-red-100 focus:ring-2 focus:ring-red-500">
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('recetas.index', ['dni' => $paciente->dni]) }}"
                    class="px-10 py-3 bg-red-500 text-white rounded-lg border-2 border-black hover:bg-red-400">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-10 py-3 bg-red-500 text-white rounded-lg border-2 border-black hover:bg-red-400">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection