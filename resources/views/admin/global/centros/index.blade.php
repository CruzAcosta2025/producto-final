@extends('layouts.app')

@section('title', 'Centros Médicos')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Centros Médicos</h1>
        <a href="{{ route('centros.create') }}"
            class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
            Agregar Centro Médico
        </a>
    </div>

    @if ($centros->isEmpty())
    <p class="text-gray-600">No hay centros médicos registrados.</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="border border-gray-500 px-4 py-2">Nombre</th>
                    <th class="border border-gray-500 px-4 py-2">Dirección</th>
                    <th class="border border-gray-500 px-4 py-2">RUC</th>
                    <th class="border border-gray-500 px-4 py-2">Estado</th>
                    <th class="border border-gray-500 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($centros as $centro)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                    <td class="border border-gray-400 px-4 py-2">{{ $centro->nombre }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $centro->direccion }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $centro->ruc }}</td>
                    <td class="border border-gray-400 px-4 py-2 text-center">
                        @if ($centro->estado === 'ACTIVO')
                        <span class="text-green-600 font-semibold">Activo</span>
                        @else
                        <span class="text-red-600 font-semibold">Inactivo</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <a href="{{ route('centros.edit', $centro->id_centro) }}"
                            class="text-blue-600 hover:text-blue-800">
                            Editar
                        </a>

                        @if ($centro->estado === 'ACTIVO')
                        <form action="{{ route('centros.disable', $centro->id_centro) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit" class="text-orange-600 hover:text-orange-800 ml-2"
                                onclick="return confirm('¿Estás seguro de que deseas deshabilitar este centro médico?')">
                                Deshabilitar
                            </button>
                        </form>
                        @else
                        <form action="{{ route('centros.enable', $centro->id_centro) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800 ml-2"
                                onclick="return confirm('¿Estás seguro de que deseas habilitar este centro médico?')">
                                Habilitar
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('centros.destroy', $centro->id_centro) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-red-600 hover:text-red-800 ml-2"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este centro médico?')">
                                Eliminar
                            </button>
                            <input type="hidden" name="confirmacion" value="1">
                            <input type="password" name="password" placeholder="Ingrese Contraseña para eliminar" required
                                class="border rounded px-2 py-1">
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection