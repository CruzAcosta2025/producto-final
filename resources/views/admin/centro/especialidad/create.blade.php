@extends('layouts.admin-centro')

@section('title', 'Agregar Especialidad')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-teal-700 rounded-t-lg">
            <h2 class="text-3xl font-semibold text-white text-center">Agregar Especialidad</h2>
        </div>

        <form action="{{ route('especialidad.store') }}" method="POST" class="space-y-4 mt-4">
            @csrf

            <div>
                <label for="nombre_especialidad" class="block font-semibold text-gray-700">Nombre de la Especialidad:</label>
                <input type="text" name="nombre_especialidad" id="nombre_especialidad" value="{{ old('nombre_especialidad') }}" required
                    placeholder="Ej: Cardiología"
                    class="w-full p-3 border-2 border-black rounded-lg bg-teal-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label for="descripcion" class="block font-semibold text-gray-700">Descripción:</label>
                <textarea name="descripcion" id="descripcion" rows="4" placeholder="Escribe una breve descripción..."
                    class="w-full p-3 border-2 border-black rounded-lg bg-teal-100 focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex justify-between mt-6">
                <button type="submit" class="px-10 py-3 bg-teal-500 text-white rounded-lg border-2 border-teal-500 hover:bg-teal-400">
                    Guardar
                </button>
                <a href="{{ route('especialidad.index') }}" class="px-10 py-3 bg-teal-500 text-white rounded-lg border-2 border-teal-500 hover:bg-teal-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection