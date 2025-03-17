@extends('layouts.admin-centro')

@section('title', 'Turnos Disponibles')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-black">
        <div class="bg-blue-900 text-white py-4 px-6 rounded-t-lg">
            <h2 class="text-3xl font-semibold text-center">Especialistas Disponibles</h2>
        </div>

        <p class="mt-4 text-lg text-gray-800">
            Turno actual: <strong>{{ ucfirst($diaActual) }}</strong>, Hora:
            <strong>{{ date('h:i A', strtotime($horaActual)) }}</strong>
        </p>

        @if ($horarios->isEmpty())
        <p class="mt-6 text-lg text-red-600 font-semibold text-center">
            No hay especialistas disponibles en este momento.
        </p>
        @else
        <div class="overflow-x-auto mt-4">
            <table class="w-full border-2 border-black">
                <thead class="bg-gray-300 text-gray-800">
                    <tr>
                        <th class="py-3 px-4 border-2 border-black text-left">Nombre</th>
                        <th class="py-3 px-4 border-2 border-black text-left">Especialidad</th>
                        <th class="py-3 px-4 border-2 border-black text-left">Hora Inicio</th>
                        <th class="py-3 px-4 border-2 border-black text-left">Hora Fin</th>
                    </tr>
                </thead>
                <tbody class="bg-blue-100">
                    @foreach ($horarios as $horario)
                    <tr class="hover:bg-blue-200">
                        <td class="py-3 px-4 border-2 border-black">{{ $horario->personalMedico->usuario->nombre }}</td>
                        <td class="py-3 px-4 border-2 border-black">
                            {{ $horario->personalMedico->especialidad->nombre_especialidad ?? 'Sin Especialidad' }}
                        </td>
                        <td class="py-3 px-4 border-2 border-black text-sm font-medium">
                            {{ date('h:i A', strtotime($horario->hora_inicio)) }}
                        </td>
                        <td class="py-3 px-4 border-2 border-black text-sm font-medium">
                            {{ date('h:i A', strtotime($horario->hora_fin)) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection