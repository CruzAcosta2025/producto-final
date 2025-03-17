@extends('layouts.admin-centro')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-lime-900">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Usuario</h2>
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

        <form action="{{ route('usuarios-centro.update', $usuario->id_usuario) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-lg font-semibold text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $usuario->nombre }}" required>
            </div>

            <div>
                <label for="email" class="block text-lg font-semibold text-gray-700">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $usuario->email }}" required>
            </div>

            <div>
                <label for="password" class="block text-lg font-semibold text-gray-700">Contraseña (Dejar en blanco para no cambiar):</label>
                <input type="password" name="password" id="password" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="id_rol" class="block text-lg font-semibold text-gray-700">Rol:</label>
                <select name="id_rol" id="id_rol" class="w-full p-3 border-2 border-black rounded-lg bg-lime-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id_rol }}" {{ $usuario->id_rol == $rol->id_rol ? 'selected' : '' }}>
                            {{ $rol->nombre_rol }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-lime-900 text-white rounded-lg border-2 border-lime-500 hover:bg-lime-400">
                    Actualizar
                </button>
                <a href="{{ route('usuarios-centro.index') }}" class="px-20 py-3 bg-lime-900 text-white rounded-lg border-2 border-lime-500 hover:bg-lime-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
