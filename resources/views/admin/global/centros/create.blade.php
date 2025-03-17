@extends('layouts.app')

@section('title', 'Crear Centro Médico')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg border-2 border-gray-500 overflow-hidden">
        <div class="px-6 py-4 bg-blue-900">
            <h2 class="text-3xl font-semibold text-white text-center">Crear Centro Médico</h2>
        </div>

        <form action="{{ route('centros.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Nombre -->
            <div class="space-y-2">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Dirección -->
            <div class="space-y-2">
                <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección:</label>
                <input type="text" name="direccion" id="direccion" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- RUC -->
            <div class="space-y-2">
                <label for="ruc" class="block text-sm font-medium text-gray-700">RUC:</label>
                <input type="text" name="ruc" id="ruc" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Color del Tema -->
            <div class="space-y-2">
                <label for="color_tema" class="block text-sm font-medium text-gray-700">Color del Tema:</label>
                <div class="flex items-center space-x-4">
                    <input type="color" name="color_tema" id="color_tema" required
                        class="w-12 h-12 rounded-lg border-2 border-gray-500 cursor-pointer">
                    <span class="text-sm font-semibold text-gray-600" id="colorTemaHex">#000000</span>
                </div>
            </div>

            <!-- Estado -->
            <div class="space-y-2">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
                <select name="estado" id="estado"
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
                    <option value="ACTIVO">Activo</option>
                    <option value="INACTIVO">Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end items-center space-x-3">
                <a href="{{ route('centros.index') }}"
                    class="px-5 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-5 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">

                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection