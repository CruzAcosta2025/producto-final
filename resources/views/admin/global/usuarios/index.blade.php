@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Usuarios</h1>
        <a href="{{ route('usuarios.create') }}"
            class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
            Agregar Usuario
        </a>
    </div>

    @if ($usuarios->isEmpty())
    <p class="text-gray-600">No hay usuarios registrados.</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="border border-gray-500 px-4 py-2">Nombre</th>
                    <th class="border border-gray-500 px-4 py-2">Email</th>
                    <th class="border border-gray-500 px-4 py-2">Rol</th>
                    <th class="border border-gray-500 px-4 py-2">Centro Médico</th>
                    <th class="border border-gray-500 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                    <td class="border border-gray-400 px-4 py-2">{{ $usuario->nombre }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $usuario->rol->nombre_rol }}</td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ $usuario->centroMedico ? $usuario->centroMedico->nombre : 'N/A' }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2 text-center">
                        <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
                            class="text-blue-600 hover:text-blue-800">
                            Editar
                        </a>
                        @if ($usuario->rol->nombre_rol !== 'Administrador Global')
                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 ml-2"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                Eliminar
                            </button>
                        </form>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
