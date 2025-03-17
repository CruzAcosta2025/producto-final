@extends('layouts.admin-centro')

@section('title', 'Gestión de Permisos')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Gestión de Permisos</h2>
        <a href="{{ route('permisos.create') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition">
            + Crear Nuevo Permiso
        </a>
    </div>

    <!-- Tabla de Permisos -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-red-100 border border-red-400 rounded-lg shadow-md">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left border border-red-400">Nombre del Módulo</th>
                    <th class="px-6 py-3 text-left border border-red-400">Tipo de Permiso</th>
                    <th class="px-6 py-3 text-left border border-red-400">Centro Médico</th>
                    <th class="px-6 py-3 text-center border border-red-400">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permisos as $permiso)
                <tr class="border border-red-500 hover:bg-red-200 transition">
                    <td class="px-6 py-4 border border-red-400">{{ $permiso->nombre_modulo }}</td>
                    <td class="px-6 py-4 border border-red-400">{{ $permiso->tipo_permiso }}</td>
                    <td class="px-6 py-4 border border-red-400">{{ $permiso->centroMedico->nombre }}</td>
                    <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                        <a href="{{ route('permisos.edit', $permiso->id_permiso) }}"
                            class="bg-blue-800 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">
                            Editar
                        </a>
                        <form action="{{ route('permisos.destroy', $permiso->id_permiso) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar este permiso?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-800 text-white px-3 py-2 rounded-md hover:bg-red-700 transition">
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