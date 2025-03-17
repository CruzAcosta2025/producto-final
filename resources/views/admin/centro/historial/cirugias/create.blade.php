@extends('layouts.admin-centro')

@section('title', 'Registrar Cirugía')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-indigo-700 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Registrar Cirugía</h2>
    </div>

        <form action="{{ route('cirugias.store', $historial->id_historial) }}" method="POST">
            @csrf

            <!-- Tipo de Cirugía -->
            <div class="mb-4">
                <label for="tipo_cirugia" class="block font-bold text-gray-800 mb-1">Tipo de Cirugía</label>
                <input type="text" name="tipo_cirugia" id="tipo_cirugia" value="{{ old('tipo_cirugia') }}" required
                    class="w-full bg-indigo-100 p-2 border border-black rounded">
            </div>

            <!-- Fecha de la Cirugía -->
            <div class="mb-4">
                <label for="fecha_cirugia" class="block font-bold text-gray-800 mb-1">Fecha de la Cirugía</label>
                <input type="date" name="fecha_cirugia" id="fecha_cirugia" value="{{ old('fecha_cirugia') }}" required
                    class="w-full bg-indigo-100 p-2 border border-black rounded">
            </div>

            <!-- Especialidad -->
            <div class="mb-4">
                <label for="especialidad" class="block font-bold text-gray-800 mb-1">Especialidad</label>
                <select id="especialidad" class="w-full bg-indigo-100 p-2 border border-black rounded">
                    <option value="">Seleccione una especialidad</option>
                    @foreach ($especialidades as $especialidad)
                        <option value="{{ $especialidad->id_especialidad }}">{{ $especialidad->nombre_especialidad }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Cirujano -->
            <div class="mb-4">
                <label for="cirujano" class="block font-bold text-gray-800 mb-1">Cirujano</label>
                <select id="cirujano" name="cirujano"
                    class="w-full bg-indigo-100 p-2 border border-black rounded">
                    <option value="">Seleccione un cirujano</option>
                </select>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block font-bold text-gray-800 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full bg-indigo-100 p-2 border border-black rounded">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Complicaciones -->
            <div class="mb-4">
                <label for="complicaciones" class="block font-bold text-gray-800 mb-1">Complicaciones</label>
                <textarea name="complicaciones" id="complicaciones" rows="3"
                    class="w-full bg-indigo-100 p-2 border border-black rounded">{{ old('complicaciones') }}</textarea>
            </div>

            <!-- Notas Postoperatorias -->
            <div class="mb-4">
                <label for="notas_postoperatorias" class="block font-bold text-gray-800 mb-1">Notas Postoperatorias</label>
                <textarea name="notas_postoperatorias" id="notas_postoperatorias" rows="3"
                    class="w-full bg-indigo-100 p-2 border border-black rounded">{{ old('notas_postoperatorias') }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('cirugias.index', ['dni' => $paciente->dni]) }}"
                    class="px-10 py-3 bg-indigo-600 text-white rounded-lg border-2 border-black hover:bg-indigo-400">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-10 py-3 bg-indigo-600 text-white rounded-lg border-2 border-black hover:bg-indigo-400">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const especialidadSelect = document.getElementById('especialidad');
        const cirujanoSelect = document.getElementById('cirujano');

        especialidadSelect.addEventListener('change', function () {
            const especialidadId = this.value;

            if (!especialidadId) {
                cirujanoSelect.innerHTML = '<option value="">Seleccione un cirujano</option>';
                return;
            }

            fetch(`/personal-medico/por-especialidad/${especialidadId}`)
                .then(response => response.json())
                .then(data => {
                    cirujanoSelect.innerHTML = '<option value="">Seleccione un cirujano</option>';
                    data.forEach(personal => {
                        cirujanoSelect.innerHTML += `
                            <option value="${personal.usuario.nombre}">${personal.usuario.nombre}</option>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error al cargar personal médico:', error);
                });
        });
    });
</script>
@endsection
