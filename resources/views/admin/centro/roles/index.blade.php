@extends('layouts.admin-centro')

@section('title', 'Gestión de Roles')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Gestión de Roles</h2>
        <a href="{{ route('roles.create') }}" class="bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
            + Crear Nuevo Rol
        </a>
    </div>

    <!-- Tabla de Roles -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-blue-100 border border-blue-800 rounded-lg shadow-md">
            <thead class="bg-blue-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left border border-blue-700">Nombre del Rol</th>
                    <th class="px-6 py-3 text-left border border-blue-700">Descripción</th>
                    <th class="px-6 py-3 text-left border border-blue-700">Centro Médico</th>
                    <th class="px-6 py-3 text-center border border-blue-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $rol)
                <tr class="border border-blue-500 hover:bg-blue-200 transition">
                    <td class="px-6 py-4 border border-blue-500">{{ $rol->nombre_rol }}</td>
                    <td class="px-6 py-4 border border-blue-500">{{ $rol->descripcion }}</td>
                    <td class="px-6 py-4 border border-blue-500">{{ $rol->centroMedico->nombre }}</td>
                    <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                        <a href="{{ route('roles.edit', $rol->id_rol) }}"
                            class="bg-blue-800 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">
                            Editar
                        </a>
                        <a href="{{ route('roles-permisos.edit', $rol->id_rol) }}"
                            class="bg-indigo-800 text-white px-3 py-2 rounded-md hover:bg-indigo-800 transition">
                            Asignar Permisos
                        </a>
                        <form action="{{ route('roles.destroy', $rol->id_rol) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar este rol?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-800 text-white px-3 py-2 rounded-md hover:bg-red-800 transition">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection