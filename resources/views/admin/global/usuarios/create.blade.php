@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg border-2 border-gray-500 overflow-hidden">

        <!-- Encabezado -->
        <div class="px-6 py-4 bg-blue-900">
            <h2 class="text-3xl font-semibold text-white text-center">Crear Usuario</h2>
        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('usuarios.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
            </div>

            <!-- Rol -->
            <div>
                <label for="id_rol" class="block text-sm font-medium text-gray-700">Rol:</label>
                <select name="id_rol" id="id_rol" required
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
                    @foreach($roles as $rol)
                    <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>{{ $rol->nombre_rol }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Centro Médico -->
            <div>
                <label for="id_centro" class="block text-sm font-medium text-gray-700">Centro Médico:</label>
                <select name="id_centro" id="id_centro"
                    class="w-full px-4 py-3 border-2 border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-700">
                    <option value="">N/A (Solo si el usuario es Administrador Global)</option>
                    @foreach($centros as $centro)
                    <option value="{{ $centro->id_centro }}" {{ old('id_centro') == $centro->id_centro ? 'selected' : '' }}>{{ $centro->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3">
                <button type="submit" class="px-5 py-3 bg-blue-900 text-white rounded-lg border-2 border-blue-700 hover:bg-blue-800">
                    Guardar
                </button>
                <a href="{{ route('usuarios.index') }}" class="px-5 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection