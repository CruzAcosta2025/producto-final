@extends('layouts.admin-centro')

@section('title', 'Registrar Tratamiento')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-purple-700 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Registrar Tratamiento</h2>
    </div>

    <!-- Contenido del Formulario -->
    <div class="p-5">
        <form action="{{ route('tratamientos.store', $historial->id_historial) }}" method="POST">
            @csrf

            <!-- Descripción -->
            <div class="mb-5">
                <label for="descripcion" class="block font-semibold mb-2 text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="6"
                    class="w-full p-3 bg-purple-100 text-base border border-gray-700 rounded-lg resize-y focus:ring-2 focus:ring-purple-500">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fecha de Creación -->
            <div class="mb-5">
                <label for="fecha_creacion" class="block font-semibold mb-2 text-gray-700">Fecha de Creación</label>
                <input type="date" name="fecha_creacion" id="fecha_creacion"
                    value="{{ old('fecha_creacion', now()->format('Y-m-d')) }}"
                    class="w-full p-3 bg-purple-100 text-base border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500">
                @error('fecha_creacion')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('historial.show', $historial->id_historial) }}"
                    class="px-10 py-3 bg-purple-500 text-white rounded-lg border-2 border-black hover:bg-purple-400">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-10 py-3 bg-purple-500 text-white rounded-lg border-2 border-black hover:bg-purple-400">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection