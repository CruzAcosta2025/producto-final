@extends('layouts.admin-centro')

@section('title', 'Gestión de Personal Médico')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Gestión de Personal Médico</h2>
        <!--  <a href="{{ route('personal.create', ['id' => Auth::user()->id_usuario]) }}" class="bg-amber-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-amber-500 transition">
           + Crear Personal Medico 
        </a> -->
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Tabla de Personal Médico -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-amber-100 border border-amber-100 rounded-lg shadow-md">
            <thead class="bg-amber-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left border border-amber-100">Nombre</th>
                    <th class="px-6 py-3 text-left border border-amber-100">Especialidad</th>
                    <th class="px-6 py-3 text-left border border-amber-100">Correo</th>
                    <th class="px-6 py-3 text-left border border-amber-100">DNI</th>
                    <th class="px-6 py-3 text-left border border-amber-100">Teléfono</th>
                    <th class="px-6 py-3 text-center border border-amber-100">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personalMedico as $personal)
                <tr class="border border-amber-400 hover:bg-amber-200 transition">
                    <td class="px-6 py-4 border border-amber-400">{{ $personal->usuario->nombre ?? 'Sin asignar' }}</td>
                    <td class="px-6 py-4 border border-amber-400">{{ $personal->especialidad->nombre_especialidad ?? 'N/A' }}</td>
                    <td class="px-6 py-4 border border-amber-400">{{ $personal->correo_contacto }}</td>
                    <td class="px-6 py-4 border border-amber-400">{{ $personal->dni }}</td>
                    <td class="px-6 py-4 border border-amber-400">{{ $personal->telefono }}</td>
                    <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                       <!-- <a href="{{ route('personal-medico.edit', $personal->id_personal_medico) }}" class="bg-blue-800 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">
                            Editar
                        </a> -->
                        <form action="{{ route('personal-medico.destroy', $personal->id_personal_medico) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-800 text-white px-3 py-2 rounded-md hover:bg-red-700 transition">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-600">No hay personal médico registrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
