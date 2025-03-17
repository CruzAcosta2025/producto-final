@extends('layouts.admin-centro')

@section('title', 'Listado de Alergias')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <div class="bg-white border-2 border-black rounded-lg shadow-lg overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-green-500 to-green-700 p-4">
            <h2 class="text-white text-2xl font-bold">Listado de Alergias</h2>
        </div>

        <div class="p-6">
            <!-- Buscador DNI -->
            <form method="GET" action="{{ route('alergias.index') }}" class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <input type="text" name="dni" value="{{ $dni }}" placeholder="Buscar por DNI"
                        class="flex-1 min-w-[200px] p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-100">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-orange-green text-white font-bold rounded-lg border border-black">
                        Buscar
                    </button>
                </div>
            </form>


            @if ($paciente)
            <h3 class="mb-4 text-lg font-semibold">Paciente: {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}</h3>

            @if ($paciente->historialClinico->isNotEmpty())
            <a href="{{ route('alergias.create', $paciente->historialClinico->first()->id_historial) }}"
                class="inline-block px-5 py-2 mb-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg border border-black">
                Nuevo Alergia
            </a>
            @else
            <p class="text-red-600 mb-4">El paciente no tiene un historial clínico.</p>
            @endif

            @if ($alergias->isEmpty())
            <p class="text-gray-600 mb-4">No hay alergias registrados para este paciente.</p>
            @else

            <!-- Tabla de Servicios -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-green-100 border border-green-600 rounded-lg shadow-md">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-center border border-green-700">Tipo</th>
                            <th class="px-6 py-3 text-center border border-green-700">Descripción</th>
                            <th class="px-6 py-3 text-center border border-green-700">Severidad</th>
                            <th class="px-6 py-3 text-center border border-green-700">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($alergias as $alergia)
                        <tr class="border border-green-500 hover:bg-green-200 transition">
                            <td class="px-6 py-4 text-center border border-green-500">{{ $alergia->tipo }}</td>
                            <td class="px-6 py-4 text-center border border-green-500">{{ $alergia->descripcion }}</td>
                            <td class="px-6 py-4 text-center border border-green-500">
                                <span class="px-3 py-1 rounded-full text-white text-sm font-bold"
                                    style="background-color: {{ $alergia->severidad === 'Alta' ? '#e74c3c' : ($alergia->severidad === 'Media' ? '#f39c12' : '#2ecc71') }};">
                                    {{ $alergia->severidad }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                                <a href="{{ route('alergias.edit', [$paciente->id_paciente, $alergia->id_alergia]) }}"
                                    class="bg-blue-700 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">
                                    Editar
                                </a>
                                <form action="{{ route('alergias.destroy', [$paciente->id_paciente, $alergia->id_alergia]) }}" method="POST"
                                    onsubmit="return confirm('¿Confirma eliminar esta alergia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-700 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">
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
            @elseif ($dni)
            <p class="text-red-600 mb-4">No se encontró ningún paciente con el DNI ingresado.</p>
            @else
            <p class="text-gray-600 mb-4">Ingrese un DNI para buscar un paciente.</p>
            @endif

            @if ($paciente && $paciente->historialClinico->isNotEmpty())
            <a href="{{ route('historial.show', $paciente->historialClinico->first()->id_historial) }}"
                class="inline-block px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg border border-black">
                Regresar al Historial
            </a>
            @endif
        </div>
    </div>
    @endsection