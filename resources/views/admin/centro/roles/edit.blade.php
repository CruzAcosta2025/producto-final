@extends('layouts.admin-centro')

@section('title', 'Editar Rol')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-blue-800">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Rol</h2>
        </div>
        
        <form action="{{ route('roles.update', $rol->id_rol) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre_rol" class="block text-lg font-semibold text-gray-700">Nombre del Rol:</label>
                <select name="nombre_rol" id="nombre_rol" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach($rolesPermitidos as $rolPermitido)
                        <option value="{{ $rolPermitido }}" {{ $rol->nombre_rol == $rolPermitido ? 'selected' : '' }}>
                            {{ $rolPermitido }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="descripcion" class="block text-lg font-semibold text-gray-700">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4">{{ $rol->descripcion }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-blue-700 hover:bg-blue-900 text-white font-bold rounded-lg shadow-md">
                    Actualizar
                </button>
                <a href="{{ route('roles.index') }}" class="px-20 py-3 bg-blue-700 hover:bg-blue-900 text-white font-bold rounded-lg shadow-md">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
