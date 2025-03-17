@extends('layouts.admin-centro')

@section('title', 'Editar Especialidad')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-teal-900 rounded-t-lg">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Especialidad</h2>
        </div>

        <form action="{{ route('especialidad.update', $especialidad->id_especialidad) }}" method="POST" class="space-y-4 mt-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre_especialidad" class="block font-semibold text-gray-700">Nombre de la Especialidad:</label>
                <input type="text" name="nombre_especialidad" id="nombre_especialidad" value="{{ old('nombre_especialidad', $especialidad->nombre_especialidad) }}" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-teal-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('nombre_especialidad')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block font-semibold text-gray-700">Descripción:</label>
                <textarea name="descripcion" id="descripcion" rows="4" placeholder="Escribe una breve descripción..."
                    class="w-full p-3 border-2 border-black rounded-lg bg-teal-100 focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none">{{ old('descripcion', $especialidad->descripcion) }}</textarea>
                @error('descripcion')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between mt-6">
                <button type="submit" class="px-10 py-3 bg-teal-500 text-white rounded-lg border-2 border-teal-500 hover:bg-teal-400">
                    Actualizar
                </button>
                <a href="{{ route('especialidad.index') }}" class="px-10 py-3 bg-teal-500 text-white rounded-lg border-2 border-teal-500 hover:bg-teal-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection