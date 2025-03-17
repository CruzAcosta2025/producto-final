@extends('layouts.admin-centro')

@section('title', 'Crear Examen Médico')

@section('content')
<div class="max-w-2xl mx-auto p-6 w-11/12">
    <div class="bg-white border-2 border-black rounded-lg shadow-lg">
        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-teal-500 to-teal-900 p-5 rounded-t-lg">
            <h2 class="text-white text-xl md:text-2xl font-bold">Registrar Examen Médico</h2>
        </div>

        <!-- Contenido del Formulario -->
        <div class="p-6">
            <form action="{{ route('examenes.store', $historial->id_historial) }}" method="POST">
                @csrf

                <!-- Tipo de Examen -->
                <div class="mb-4">
                    <label for="tipo_examen" class="block font-bold text-gray-800 mb-1">Tipo de Examen</label>
                    <input type="text" id="tipo_examen" name="tipo_examen" class="w-full p-3 border border-black rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500" required maxlength="100">
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label for="descripcion" class="block font-bold text-gray-800 mb-1">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="w-full p-3 border border-black rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500 resize-y" required></textarea>
                </div>

                <!-- Resultados -->
                <div class="mb-4">
                    <label for="resultados" class="block font-bold text-gray-800 mb-1">Resultados</label>
                    <textarea id="resultados" name="resultados" rows="4" class="w-full p-3 border border-black rounded-md bg-gray-100 focus:ring-2 focus:ring-teal-500 resize-y"></textarea>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('examenes.index', $historial->id_historial) }}" class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg border border-black">Cancelar</a>
                    <button type="submit" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-lg border border-black">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
