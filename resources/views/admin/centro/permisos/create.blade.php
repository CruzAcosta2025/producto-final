@extends('layouts.admin-centro')

@section('title', 'Crear Nuevo Permiso')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-red-500">
            <h2 class="text-3xl font-semibold text-white text-center">Crear Nuevo Permiso</h2>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('permisos.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nombre_modulo" class="block text-lg font-semibold text-gray-700">Nombre del Módulo:</label>
                <select name="nombre_modulo" id="nombre_modulo" class="w-full p-3 border-2 border-black rounded-lg bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    <option value="">Selecciona un módulo</option>
                    @foreach($modulosPermitidos as $modulo)
                    <option value="{{ $modulo }}">{{ $modulo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tipo_permiso" class="block text-lg font-semibold text-gray-700">Tipo de Permiso:</label>
                <select name="tipo_permiso" id="tipo_permiso" class="w-full p-3 border-2 border-black rounded-lg bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    <option value="">Selecciona un tipo</option>
                </select>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-red-500 hover:bg-red-900 text-white font-bold rounded-lg shadow-md">
                    Guardar
                </button>
                <a href="{{ route('permisos.index') }}" class="px-20 py-3 bg-red-500 hover:bg-red-900 text-white font-bold rounded-lg shadow-md">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('nombre_modulo').addEventListener('change', function() {
        const modulo = this.value;
        const tipoPermisoSelect = document.getElementById('tipo_permiso');

        tipoPermisoSelect.innerHTML = '<option value="">Cargando...</option>';

        fetch(`{{ route('permisos.tipos') }}?nombre_modulo=${modulo}`)
            .then(response => response.json())
            .then(data => {
                tipoPermisoSelect.innerHTML = '<option value="">Selecciona un tipo</option>';
                data.forEach(tipo => {
                    tipoPermisoSelect.innerHTML += `<option value="${tipo}">${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</option>`;
                });
            })
            .catch(() => {
                tipoPermisoSelect.innerHTML = '<option value="">Error al cargar los tipos</option>';
            });
    });
</script>
@endsection