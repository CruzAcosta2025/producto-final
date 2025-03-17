@extends('layouts.admin-centro')

@section('title', 'Listado de Diagnósticos')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <div class="bg-white border-2 border-black rounded-lg shadow-lg overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-700 p-4">
            <h2 class="text-white text-2xl font-bold">Listado de Diagnósticos</h2>
        </div>

        <div class="p-6">
            <!-- Buscador DNI -->
            <form method="GET" action="{{ route('diagnosticos.index') }}" class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <input type="text" name="dni" value="{{ $dni }}" placeholder="Buscar por DNI"
                        class="flex-1 min-w-[200px] p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-100">
                    <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg border border-black">
                        Buscar
                    </button>
                </div>
            </form>

            @if ($paciente)
            <h3 class="mb-4 text-lg font-semibold">Paciente: {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}</h3>

            @if ($paciente->historialClinico->isNotEmpty())
            <a href="{{ route('diagnosticos.create', $paciente->historialClinico->first()->id_historial) }}"
                class="inline-block px-5 py-2 mb-4 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg border border-black">
                Nuevo Diagnóstico
            </a>
            @else
            <p class="text-red-600 mb-4">El paciente no tiene un historial clínico.</p>
            @endif

            @if ($diagnosticos->isEmpty())
            <p class="text-gray-600 mb-4">No hay diagnósticos registrados para este paciente.</p>
            @else

            
            <div class="overflow-x-auto mb-4">
                <table class="w-full border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-4 text-center border-b-2 border-gray-300">Fecha</th>
                            <th class="p-4 text-center border-b-2 border-gray-300">Grupo</th>
                            <th class="p-4 text-center border-b-2 border-gray-300">Categoría</th>
                            <th class="p-4 text-center border-b-2 border-gray-300">Subcategoría</th>
                            <th class="p-4 text-center border-b-2 border-gray-300 w-48">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($diagnosticos as $diagnostico)
                        <tr>
                            <td class="p-4 text-center border-b border-gray-300">{{ \Carbon\Carbon::parse($diagnostico->fecha_creacion)->format('Y-m-d') }}</td>
                            <td class="p-4 text-center border-b border-gray-300">{{ $diagnostico->cie10->grupo ?? 'N/A' }}</td>
                            <td class="p-4 text-center border-b border-gray-300">{{ $diagnostico->cie10->categoria ?? 'N/A' }}</td>
                            <td class="p-4 text-center border-b border-gray-300">{{ $diagnostico->cie10->subcategoria ?? 'N/A' }}</td>
                            <td class="p-4 text-center border-b border-gray-300">
                                <div class="flex gap-2">
                                    <a href="{{ route('diagnosticos.edit', [$diagnostico->id_historial, $diagnostico->id_diagnostico]) }}"
                                        class="px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-md border border-black">
                                        Editar
                                    </a>
                                    <button class="btn-delete px-3 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md border border-black"
                                        data-url="{{ route('diagnosticos.destroy', [$diagnostico->id_historial, $diagnostico->id_diagnostico]) }}">
                                        Eliminar
                                    </button>
                                </div>
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
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('¿Confirma eliminar este diagnóstico?')) return;
            const url = this.getAttribute('data-url');
            const token = '{{ csrf_token() }}';

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Diagnóstico eliminado exitosamente.');
                        location.reload();
                    } else {
                        alert('Error al eliminar el diagnóstico.');
                    }
                })
                .catch(() => {
                    alert('Error al eliminar el diagnóstico.');
                });
        });
    });
</script>
@endsection