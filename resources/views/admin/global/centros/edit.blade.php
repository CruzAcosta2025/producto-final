@extends('layouts.app')

@section('title', 'Editar Centro Médico')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg border-2 border-gray-500 overflow-hidden">
        
        <!-- Encabezado -->
        <div class="px-6 py-4 bg-blue-900">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Centro Médico</h2>
        </div>

        <!-- Formulario -->
        <form action="{{ route('centros.update', $centro->id_centro) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ $centro->nombre }}" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Dirección -->
            <div>
                <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección:</label>
                <input type="text" name="direccion" id="direccion" value="{{ $centro->direccion }}" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- RUC -->
            <div>
                <label for="ruc" class="block text-sm font-medium text-gray-700">RUC:</label>
                <input type="text" name="ruc" id="ruc" value="{{ $centro->ruc }}" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Color del Tema -->
            <div>
                <label for="color_tema" class="block text-sm font-medium text-gray-700">Color del Tema:</label>
                <input type="color" name="color_tema" id="color_tema" value="{{ $centro->color_tema }}" required
                    class="w-12 h-12 rounded-lg border-2 border-gray-500 cursor-pointer">
            </div>

            <!-- Estado -->
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
                <select name="estado" id="estado" class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
                    <option value="ACTIVO" {{ $centro->estado == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                    <option value="INACTIVO" {{ $centro->estado == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end items-center space-x-3">
                <button type="submit" class="px-5 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Actualizar
                </button>
                <a href="{{ route('centros.index') }}" class="px-5 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
