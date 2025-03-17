@extends('layouts.admin-centro')

@section('title', 'Añadir Medicamento')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-5 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Añadir Medicamento</h2>
    </div>

    <!-- Contenido del Formulario -->
    <div class="p-6">
        <form action="{{ route('medicamentos.store', $receta->id_receta) }}" method="POST">
            @csrf

            <!-- Medicamento -->
            <div class="mb-4">
                <label for="medicamento" class="block font-bold text-gray-800 mb-1">Nombre del Medicamento</label>
                <input type="text" name="medicamento" id="medicamento"
                    value="{{ old('medicamento') }}" required
                    class="w-full p-3 border border-black rounded-md bg-green-100 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Dosis -->
            <div class="mb-4">
                <label for="dosis" class="block font-bold text-gray-800 mb-1">Dosis</label>
                <input type="text" name="dosis" id="dosis"
                    value="{{ old('dosis') }}" required
                    class="w-full p-3 border border-black rounded-md bg-green-100 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Frecuencia -->
            <div class="mb-4">
                <label for="frecuencia" class="block font-bold text-gray-800 mb-1">Frecuencia</label>
                <input type="text" name="frecuencia" id="frecuencia"
                    value="{{ old('frecuencia') }}" required
                    class="w-full p-3 border border-black rounded-md bg-green-100 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Duración -->
            <div class="mb-4">
                <label for="duracion" class="block font-bold text-gray-800 mb-1">Duración</label>
                <input type="text" name="duracion" id="duracion"
                    value="{{ old('duracion') }}" required
                    class="w-full p-3 border border-black rounded-md bg-green-100 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Instrucciones -->
            <div class="mb-4">
                <label for="instrucciones" class="block font-bold text-gray-800 mb-1">Instrucciones (Opcional)</label>
                <textarea name="instrucciones" id="instrucciones" rows="4"
                    class="w-full p-3 border border-black rounded-md bg-green-100 focus:ring-2 focus:ring-green-500 resize-y">{{ old('instrucciones') }}</textarea>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('medicamentos.index', $receta->id_receta) }}"
                    class="px-10 py-3 bg-green-500 text-white rounded-lg border-2 border-black hover:bg-green-400">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-10 py-3 bg-green-500 text-white rounded-lg border-2 border-black hover:bg-green-400">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection