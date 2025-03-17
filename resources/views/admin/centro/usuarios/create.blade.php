@extends('layouts.admin-centro')

@section('title', 'Crear Usuario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-lime-900">
            <h2 class="text-3xl font-semibold text-white text-center">Crear Usuario</h2>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('usuarios-centro.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nombre" class="block text-lg font-semibold text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="email" class="block text-lg font-semibold text-gray-700">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="password" class="block text-lg font-semibold text-gray-700">Contraseña:</label>
                <input type="password" name="password" id="password" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="password_confirmation" class="block text-lg font-semibold text-gray-700">Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="id_rol" class="block text-lg font-semibold text-gray-700">Rol:</label>
                <select name="id_rol" id="id_rol" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach($roles as $rol)
                    <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tipo_personal" class="block text-lg font-semibold text-gray-700">Tipo de Personal:</label>
                <select name="tipo_personal" id="tipo_personal" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccionar tipo de personal</option>
                    <option value="medico">Médico</option>
                    <option value="no_medico">No Médico</option>
                </select>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-lime-900 text-white rounded-lg border-2 border-lime-500 hover:bg-lime-400">
                    Guardar
                </button>
                <a href="{{ route('usuarios-centro.index') }}" class="px-20 py-3 bg-lime-900 text-white rounded-lg border-2 border-lime-500 hover:bg-lime-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection