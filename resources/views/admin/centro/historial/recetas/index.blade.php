@extends('layouts.admin-centro')

@section('title', 'Listado de Recetas')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <div class="bg-white border-2 border-black rounded-lg shadow-lg overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-rose-500 to-rose-700 p-4">
            <h2 class="text-white text-2xl font-bold">Listado de Recetas</h2>
        </div>

        <div class="p-6">
            <!-- Buscador DNI -->
            <form method="GET" action="{{ route('recetas.index') }}" class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <input type="text" name="dni" value="{{ $dni }}" placeholder="Buscar por DNI"
                        class="flex-1 min-w-[200px] p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500 bg-gray-100">
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-lg border border-black">
                        Buscar
                    </button>
                </div>
            </form>


            @if ($paciente)
            <h3 class="mb-5 font-semibold">Paciente: {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}</h3>

            @if ($paciente->historialClinico->isNotEmpty())
            <a href="{{ route('recetas.create', $paciente->historialClinico->first()->id_historial) }}"
                class="inline-block px-4 py-2 bg-red-600 text-white rounded-md mb-5 hover:bg-red-700 transition">
                Nueva Receta
            </a>
            @else
            <p class="text-red-500">El paciente no tiene un historial clínico.</p>
            @endif

            @if ($recetas->isEmpty())
            <p class="text-gray-500">No hay recetas registradas para este paciente.</p>
            @else

            @if ($paciente && $paciente->historialClinico->isNotEmpty())
            <a href="{{ route('historial.show', $paciente->historialClinico->first()->id_historial) }}"
                class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                Regresar al Historial
            </a>
            @endif

            <!-- Tabla de Pacientes -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-rose-100 border border-rose-600 rounded-lg shadow-md">
                    <thead class="bg-rose-600 text-white">
                        <tr class="bg-rose-600">
                            <th class="px-6 py-3 text-left border border-rose-700 text-center">Fecha</th>
                            <th class="px-6 py-3 text-left border border-rose-700 text-center">Médico</th>
                            <th class="px-6 py-3 text-left border border-rose-700 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recetas as $receta)
                        <tr class="border border-sky-500 hover:bg-rose-200 transition">
                            <td class="px-6 py-4 border border-rose-500 text-center">{{ $receta->fecha_receta }}</td>
                            <td class="px-6 py-4 border border-rose-500 text-center">{{ $receta->personalMedico->usuario->nombre ?? 'No registrado' }}</td>
                            <td class="px-6 py-4 border border-rose-500 text-center">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('recetas.edit', [$receta->id_historial, $receta->id_receta]) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                        Editar
                                    </a>
                                    <button class="btn-delete px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                                        data-url="{{ route('recetas.destroy', [$receta->id_historial, $receta->id_receta]) }}">
                                        Eliminar
                                    </button>
                                    <a href="{{ route('medicamentos.index', $receta->id_receta) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                        Ver Medicamentos
                                    </a>
                                    <a href="{{ route('medicamentos.create', $receta->id_receta) }}"
                                        class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                        Añadir Medicamento
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            @elseif ($dni)
            <p class="text-red-500">No se encontró ningún paciente con el DNI ingresado.</p>
            @else
            <p class="text-gray-500">Ingrese un DNI para buscar un paciente.</p>
            @endif


        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('¿Confirma eliminar esta receta?')) return;

            const url = this.getAttribute('data-url');
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Receta eliminada exitosamente.');
                        location.reload();
                    } else {
                        alert('Error al eliminar la receta.');
                    }
                })
                .catch(() => {
                    alert('Error al eliminar la receta.');
                });
        });
    });
</script>
@endsection