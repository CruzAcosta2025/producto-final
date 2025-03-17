@extends('layouts.admin-centro')

@section('title', 'Gestión de Horarios')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Gestión de Horarios</h2>
        <a href="{{ route('horarios.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition">
            + Nuevo Horario
        </a>
    </div>

    <!-- Buscador -->
    <form method="GET" action="{{ route('horarios.index') }}" class="mb-6">
        <div class="flex gap-3">
            <input type="text" name="dni" value="{{ $dni }}" placeholder="Buscar por DNI"
                class="flex-1 p-3 border border-gray-950 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <button type="submit" class="bg-indigo-600 border-black text-white px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition">
                Buscar
            </button>
        </div>
    </form>

    @if ($horarios->isEmpty())
    <p class="text-gray-600 text-center py-4">No se encontraron horarios registrados.</p>
    @else
    <!-- Tabla de Horarios -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-indigo-100 border border-indigo-600 rounded-lg shadow-md">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left border border-indigo-700">Día</th>
                    <th class="px-6 py-3 text-left border border-indigo-700">Hora Inicio</th>
                    <th class="px-6 py-3 text-left border border-indigo-700">Hora Fin</th>
                    <th class="px-6 py-3 text-left border border-indigo-700">Personal Médico</th>
                    <th class="px-6 py-3 text-center border border-indigo-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($horarios as $horario)
                <tr class="border border-indigo-500 hover:bg-indigo-200 transition">
                    <td class="px-6 py-4 border border-indigo-500">{{ $horario->dia_semana }}</td>
                    <td class="px-6 py-4 border border-indigo-500">{{ date('h:i A', strtotime($horario->hora_inicio)) }}</td>
                    <td class="px-6 py-4 border border-indigo-500">{{ date('h:i A', strtotime($horario->hora_fin)) }}</td>
                    <td class="px-6 py-4 border border-indigo-500">{{ $horario->personalMedico->usuario->nombre }}</td>
                    <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                        <a href="{{ route('horarios.edit', $horario->id_horario) }}" class="bg-blue-700 text-white px-3 py-2 rounded-md hover:bg-blue-600 transition">
                            Editar
                        </a>
                        <form action="{{ route('horarios.destroy', $horario->id_horario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este horario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 transition">
                                Eliminar
                            </button>
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