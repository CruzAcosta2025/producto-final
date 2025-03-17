@extends('layouts.admin-centro')

@section('title', 'Editar Servicio')

@section('content')
<div class="max-w-xl mx-auto px-6 py-8">
    <div class="bg-white rounded-xl shadow-lg border-2 border-black p-6">
        <div class="bg-orange-600 text-white py-4 px-6 rounded-t-lg">
            <h2 class="text-2xl font-semibold text-center">Editar Servicio</h2>
        </div>

        <form action="{{ route('servicios.update', $servicio->id_servicio) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre del Servicio -->
            <div>
                <label for="nombre_servicio" class="block font-semibold text-gray-900">Nombre del Servicio:</label>
                <input type="text" id="nombre_servicio" name="nombre_servicio" value="{{ $servicio->nombre_servicio }}" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Categoría -->
            <div>
                <label for="categoria_servicio" class="block font-semibold text-gray-900">Categoría:</label>
                <select id="categoria_servicio" name="categoria_servicio" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="DIAGNOSTICO" {{ $servicio->categoria_servicio == 'DIAGNOSTICO' ? 'selected' : '' }}>DIAGNÓSTICO</option>
                    <option value="CONSULTA" {{ $servicio->categoria_servicio == 'CONSULTA' ? 'selected' : '' }}>CONSULTA</option>
                    <option value="EXAMEN" {{ $servicio->categoria_servicio == 'EXAMEN' ? 'selected' : '' }}>EXAMEN</option>
                </select>
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block font-semibold text-gray-900">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full p-3 border-2 border-black rounded-lg bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ $servicio->descripcion }}</textarea>
            </div>

            <!-- Precio -->
            <div>
                <label for="precio" class="block font-semibold text-gray-900">Precio:</label>
                <input type="number" id="precio" name="precio" value="{{ $servicio->precio }}" step="0.01" required
                    class="w-full p-3 border-2 border-black rounded-lg bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Estado -->
            <div>
                <label for="estado" class="block font-semibold text-gray-900">Estado:</label>
                <select id="estado" name="estado"
                    class="w-full p-3 border-2 border-black rounded-lg bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="activo" {{ $servicio->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $servicio->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('servicios.index') }}"
                    class="px-6 py-3 bg-orange-400 text-white rounded-lg border-2 border-black hover:bg-orange-300">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-orange-400 text-white rounded-lg border-2 border-black hover:bg-orange-300">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection