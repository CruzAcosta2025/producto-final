@extends('layouts.admin-centro')

@section('title', 'Registrar Diagnóstico')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-purple-700 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Registrar Diagnóstico</h2>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-200 text-red-800 rounded-md">
            <strong>Errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>

    <!-- Contenido del Formulario -->
    <div class="p-6">
        <form action="{{ route('diagnosticos.store', $historial->id_historial) }}" method="POST">
            @csrf

            <!-- CIE-10 Grupo -->
            <div class="mb-5">
                <label for="grupo" class="block font-bold mb-1">Grupo</label>
                <select id="grupo" required class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-100">
                    <option value="">Seleccione un grupo</option>
                    @foreach($cie10->groupBy('grupo') as $grupo => $categorias)
                    <option value="{{ $grupo }}">{{ $grupo }}</option>
                    @endforeach
                </select>
            </div>

            <!-- CIE-10 Categoría -->
            <div class="mb-5">
                <label for="categoria" class="block font-bold mb-1">Categoría</label>
                <select id="categoria" required class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-100" disabled required>
                    <option value="">Seleccione una categoría</option>
                </select>
            </div>

            <!-- CIE-10 Subcategoría -->
            <div class="mb-4">
                <label for="cie_10_id" class="block font-bold mb-1">Subcategoría (Código CIE-10)</label>
                <select name="cie_10_id" id="cie_10_id" required class="w-full p-3 border border-black rounded-md bg-gray-100" disabled>
                    <option value="">Seleccione una subcategoría</option>
                </select>
            </div>


            <!-- Fecha del Diagnóstico -->
            <div class="mb-4">
                <label for="fecha_creacion" class="block font-bold mb-1">Fecha del Diagnóstico</label>
                <input type="date" name="fecha_creacion" id="fecha_creacion" value="{{ old('fecha_creacion') }}" required
                    class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-100">
            </div>


            <!-- Descripción -->
            <div class="mb-4">
                <label for="detalles" class="block font-bold mb-1">Detalles(Opcional)</label>
                <textarea name="detalles" id="detalles" rows="4"
                    class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 bg-gray-100 resize-y">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end items-center mt-6 space-x-4">
                <a href="{{ route('diagnosticos.index', ['dni' => $paciente->dni]) }}"
                    class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg border border-black">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg border border-black">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cie10 = @json($cie10);

        const grupoSelect = document.getElementById('grupo');
        const categoriaSelect = document.getElementById('categoria');
        const subcategoriaSelect = document.getElementById('cie_10_id');

        grupoSelect.addEventListener('change', function() {
            const grupoSeleccionado = this.value;
            const categorias = cie10.filter(item => item.grupo === grupoSeleccionado);

            categoriaSelect.innerHTML = '<option value="">Seleccione una categoría</option>';
            categorias.forEach(c => {
                categoriaSelect.innerHTML += `<option value="${c.categoria}">${c.categoria}</option>`;
            });

            categoriaSelect.disabled = categorias.length === 0;
            subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
            subcategoriaSelect.disabled = true;
        });

        categoriaSelect.addEventListener('change', function() {
            const categoriaSeleccionada = this.value;
            const subcategorias = cie10.filter(item => item.categoria === categoriaSeleccionada);

            subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
            subcategorias.forEach(s => {
                subcategoriaSelect.innerHTML += `<option value="${s.id_cie10}">${s.subcategoria}</option>`;
            });

            subcategoriaSelect.disabled = subcategorias.length === 0;
        });
    });
</script>
@endsection