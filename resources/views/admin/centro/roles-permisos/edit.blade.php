@extends('layouts.admin-centro')

@section('title', 'Asignar Permisos al Rol')

@section('content')
<div class="container mx-auto p-6 bg-blue-100 rounded-lg shadow-lg border-2 border-black">
    <h2 class="text-2xl font-bold text-blue-900 mb-6">Asignar Permisos al Rol: {{ $rol->nombre_rol }}</h2>
    
    <form action="{{ route('roles-permisos.update', $rol->id_rol) }}" method="POST">
        @csrf
        @method('PUT')

        @foreach ($permisos as $modulo => $moduloPermisos)
            <div class="mb-6 p-4 border-2 border-black bg-blue-200 rounded-lg">
                <h3 class="text-lg font-bold text-blue-900 mb-2">{{ $modulo }}</h3>
                @foreach ($moduloPermisos as $permiso)
                    <label class="block text-blue-800 font-medium">
                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id_permiso }}"
                            class="mr-2 accent-blue-700"
                            {{ $rol->permisos->contains($permiso->id_permiso) ? 'checked' : '' }}>
                        {{ ucfirst($permiso->tipo_permiso) }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-3 px-6 rounded-lg shadow-md">Guardar Cambios</button>
            <a href="{{ route('roles.index') }}" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-3 px-6 rounded-lg shadow-md">Cancelar</a>
        </div>
    </form>
</div>
@endsection
