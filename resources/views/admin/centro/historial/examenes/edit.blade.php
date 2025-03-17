@extends('layouts.admin-centro')

@section('title', 'Editar Examen Médico')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-lg border-2 border-teal-600">
    <h2 class="text-2xl font-bold text-teal-700 mb-6">Editar Examen Médico</h2>
    <form action="{{ route('examenes.update', [$historial->id_historial, $examen->id_examen]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="tipo_examen" class="block font-bold text-gray-700 mb-1">Tipo de Examen:</label>
            <input type="text" id="tipo_examen" name="tipo_examen" 
                   class="w-full p-3 border border-teal-600 rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500"
                   value="{{ old('tipo_examen', $examen->tipo_examen) }}" required maxlength="100">
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block font-bold text-gray-700 mb-1">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      class="w-full p-3 border border-teal-600 rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500"
                      required>{{ old('descripcion', $examen->descripcion) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="resultados" class="block font-bold text-gray-700 mb-1">Resultados:</label>
            <textarea id="resultados" name="resultados" rows="3"
                      class="w-full p-3 border border-teal-600 rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500">
                {{ old('resultados', $examen->resultados) }}
            </textarea>
        </div>

        <div class="flex justify-start space-x-4 mt-6">
            <a href="{{ route('examenes.index', $historial->id_historial) }}"
               class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg border border-black">
                Cancelar
            </a>
            <button type="submit"
                    class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-lg border border-black">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
