@extends('layouts.admin-centro')

@section('title', 'Medicamentos de la Receta')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <div class="bg-white border-2 border-black rounded-lg shadow-lg overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-green-500 to-green-700 p-4">
            <h2 class="text-white text-2xl font-bold">Listado de Medicamentos</h2>
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <h3 class="mb-4 text-lg font-semibold">Paciente: {{ $receta->historialClinico->paciente->primer_nombre }} {{ $receta->historialClinico->paciente->primer_apellido }} {{ $receta->historialClinico->paciente->segundo_apellido }}</h3>

            <a href="{{ route('medicamentos.create', $receta->id_receta) }}"
                class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                Añadir Medicamento
            </a>

            <a href="{{ route('recetas.index', ['dni' => $receta->historialClinico->paciente->dni]) }}"
                class="inline-block mt-6 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                Regresar a Recetas
            </a>

            @if ($medicamentos->isEmpty())
            <p class="text-gray-500 mt-4">No hay medicamentos registrados para esta receta.</p>
            @else

            <!-- Tabla de Pacientes -->
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full bg-green-100 border border-rose-600 rounded-lg shadow-md">
                    <thead class="bg-green-600 text-white">
                        <tr class="bg-green-600">
                            <th class="px-6 py-3 text-left border border-green-700 text-center">Medicamento</th>
                            <th class="px-6 py-3 text-left border border-green-700 text-center">Dosis</th>
                            <th class="px-6 py-3 text-left border border-green-700 text-center">Frecuencia</th>
                            <th class="px-6 py-3 text-left border border-green-700 text-center">Duración</th>
                            <th class="px-6 py-3 text-left border border-green-700 text-center">Instrucciones</th>
                            <th class="px-6 py-3 text-left border border-green-700 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicamentos as $medicamento)
                        <tr class="border border-green-500 hover:bg-green-200 transition">
                            <td class="px-6 py-4 border border-green-500 text-center">{{ $medicamento->medicamento }}</td>
                            <td class="px-6 py-4 border border-green-500 text-center">{{ $medicamento->dosis }}</td>
                            <td class="px-6 py-4 border border-green-500 text-center">{{ $medicamento->frecuencia }}</td>
                            <td class="px-6 py-4 border border-green-500 text-center">{{ $medicamento->duracion }}</td>
                            <td class="px-6 py-4 border border-green-500 text-center">{!! nl2br(e($medicamento->instrucciones ?? 'Sin instrucciones')) !!}</td>
                            <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                                <a href="{{ route('medicamentos.edit', [$receta->id_receta, $medicamento->id_medicamento_receta]) }}"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 transition">
                                    Editar
                                </a>
                                <button class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 transition btn-delete" data-url="{{ route('medicamentos.destroy', [$receta->id_receta, $medicamento->id_medicamento_receta]) }}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif


        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                if (!confirm('¿Confirma eliminar este medicamento?')) return;

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
                            alert('Medicamento eliminado exitosamente.');
                            location.reload();
                        } else {
                            alert('Error al eliminar el medicamento.');
                        }
                    })
                    .catch(() => {
                        alert('Error al eliminar el medicamento.');
                    });
            });
        });
    </script>
    @endsection