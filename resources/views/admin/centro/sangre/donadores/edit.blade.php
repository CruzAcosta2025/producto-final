@extends('layouts.admin-centro')

@section('title', 'Editar Donador de Sangre')

@section('content')
<div class="max-w-xl mx-auto px-6 py-8">
    <div class="bg-white rounded-xl shadow-lg border-2 border-black p-6">
        <div class="bg-blue-900 text-white py-4 px-6 rounded-t-lg">
            <h2 class="text-2xl font-semibold text-center">Editar Donador</h2>
        </div>

        <form action="{{ route('sangre.donadores.update', $donador->id_donador) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block font-semibold text-gray-900">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="{{ $donador->nombre }}" readonly
                    class="w-full p-3 border-2 border-black rounded-lg bg-gray-200 text-gray-600">
            </div>

            <!-- Apellido -->
            <div>
                <label for="apellido" class="block font-semibold text-gray-900">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="{{ $donador->apellido }}" readonly
                    class="w-full p-3 border-2 border-black rounded-lg bg-gray-200 text-gray-600">
            </div>

            <!-- DNI -->
            <div>
                <label for="dni" class="block font-semibold text-gray-900">DNI:</label>
                <input type="text" id="dni" name="dni" value="{{ $donador->dni }}" readonly
                    class="w-full p-3 border-2 border-black rounded-lg bg-gray-200 text-gray-600">
            </div>

            <!-- Tipo de Sangre -->
            <div>
                <label for="tipo_sangre" class="block font-semibold text-gray-900">Tipo de Sangre:</label>
                @if ($editable)
                <select id="tipo_sangre" name="tipo_sangre"
                    class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:ring-2 focus:ring-blue-500">
                    @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $tipo)
                    <option value="{{ $tipo }}" {{ $donador->tipo_sangre == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
                @else
                <input type="text" value="{{ $donador->tipo_sangre }}" readonly
                    class="w-full p-3 border-2 border-black rounded-lg bg-gray-200 text-gray-600">
                @endif
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block font-semibold text-gray-900">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="{{ $donador->telefono }}"
                    class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Estado -->
            <div>
                <label for="estado" class="block font-semibold text-gray-900">Estado:</label>
                <select id="estado" name="estado"
                    class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:ring-2 focus:ring-blue-500">
                    <option value="POR_EXAMINAR" {{ $donador->estado == 'POR_EXAMINAR' ? 'selected' : '' }}>Por Examinar</option>
                    <option value="APTO" {{ $donador->estado == 'APTO' ? 'selected' : '' }}>Apto</option>
                    <option value="NO_APTO" {{ $donador->estado == 'NO_APTO' ? 'selected' : '' }}>No Apto</option>
                </select>
            </div>

            <!-- Última Donación -->
            <div>
                <label for="ultima_donacion" class="block font-semibold text-gray-900">Última Donación (Opcional):</label>
                <input type="date" id="ultima_donacion" name="ultima_donacion" value="{{ $donador->ultima_donacion }}"
                    class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('sangre.donadores.index') }}"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg border-2 border-black hover:bg-red-500">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-900 text-white rounded-lg border-2 border-black hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection