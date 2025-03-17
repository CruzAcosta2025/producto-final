@extends('layouts.admin-centro')
@section('title', 'Crear Nuevo Rol')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-blue-800">
            <h2 class="text-3xl font-semibold text-white text-center">Crear Nuevo Rol</h2>
        </div>
        
        <form action="{{ route('roles.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nombre_rol" class="block text-lg font-semibold text-gray-700">Nombre del Rol:</label>
                <select name="nombre_rol" id="nombre_rol" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecciona un rol</option>
                    @foreach($rolesPermitidos as $rol)
                    <option value="{{ $rol }}">{{ $rol }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="descripcion" class="block text-lg font-semibold text-gray-700">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-blue-700 hover:bg-blue-900 text-white font-bold rounded-lg shadow-md">
                    Guardar
                </button>
                <a href="{{ route('roles.index') }}" class="px-20 py-3 bg-blue-700 hover:bg-blue-900 text-white font-bold rounded-lg shadow-md">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection