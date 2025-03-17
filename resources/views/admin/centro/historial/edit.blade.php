@extends('layouts.admin-centro')

@section('title', 'Editar Historial Clínico')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-orange-600">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Historial Clínico</h2>
        </div>

        <form action="{{ route('historial.update', $historial->id_historial) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="fecha_creacion" class="block text-lg font-medium text-gray-800">Fecha de Creación</label>
                <input type="date" name="fecha_creacion" id="fecha_creacion" value="{{ $historial->fecha_creacion }}"
                    class="bg-orange-100 mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-orange-500 transition duration-300">
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="px-6 py-3 bg-orange-600 text-white rounded-lg shadow-md hover:bg-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-300 transition duration-300">
                    Guardar Cambios
                </button>
                <a href="{{ route('historial.index') }}"
                    class="px-6 py-3 bg-orange-600 text-white rounded-lg shadow-md hover:bg-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-400 transition duration-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection