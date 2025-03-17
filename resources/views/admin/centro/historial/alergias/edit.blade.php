@extends('layouts.admin-centro')

@section('title', 'Editar Alergia')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-green-700 rounded-t-lg">
        <div class="text-3xl font-semibold text-white text-center">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Alergia</h2>
        </div>
    </div>

    <form action="{{ route('alergias.update', [$paciente->id_paciente, $alergia->id_alergia]) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="tipo" class="block font-bold mb-1">Tipo</label>
            <input type="text" name="tipo" id="tipo" value="{{ $alergia->tipo }}" required
                class="w-full bg-green-100 p-2 border border-black rounded">
        </div>
        <div class="mb-4">
            <label for="descripcion" class="block font-bold mb-1">Descripción</label>
            <textarea name="descripcion" id="descripcion" required
                class="w-full bg-green-100 p-2 border border-black rounded">{{ $alergia->descripcion }}</textarea>
        </div>
        <div class="mb-4">
            <label for="severidad" class="block font-bold mb-1">Severidad</label>
            <select name="severidad" id="severidad" required
                class="w-full bg-green-100 p-2 border border-black rounded">
                <option value="leve" {{ $alergia->severidad == 'leve' ? 'selected' : '' }}>Leve</option>
                <option value="moderada" {{ $alergia->severidad == 'moderada' ? 'selected' : '' }}>Moderada</option>
                <option value="severa" {{ $alergia->severidad == 'severa' ? 'selected' : '' }}>Severa</option>
            </select>
        </div>
        <div class="flex justify-between mt-4">
            <button type="submit" class="px-10 py-3 bg-green-500 text-white rounded-lg border-2 border-black hover:bg-green-400">
                Actualizar
            </button>
            <a href="{{ route('historial.show', $paciente->historialClinico->first()->id_historial) }}"
                class="px-10 py-3 bg-green-500 text-white rounded-lg border-2 border-black hover:bg-green-400">
                Cancelar
            </a>
        </div>
    </form>
</div>
</div>
@endsection