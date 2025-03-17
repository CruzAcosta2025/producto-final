@extends('layouts.admin-centro')

@section('title', 'Editar Cirugía')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-indigo-700 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Editar Cirugía</h2>
    </div>

    <form action="{{ route('cirugias.update', [$cirugia->id_historial, $cirugia->id_cirugia]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="tipo_cirugia" class="font-semibold text-indigo-700 block mb-2">Tipo de Cirugía</label>
            <input type="text" name="tipo_cirugia" id="tipo_cirugia" value="{{ old('tipo_cirugia', $cirugia->tipo_cirugia) }}"
                class="w-full bg-indigo-100 p-2 border border-black rounded" required>
        </div>

        <div class="mb-4">
            <label for="fecha_cirugia" class="font-semibold text-indigo-700 block mb-2">Fecha de la Cirugía</label>
            <input type="date" name="fecha_cirugia" id="fecha_cirugia" value="{{ $cirugia->fecha_cirugia }}"
                class="w-full bg-indigo-100 p-2 border border-black rounded">
        </div>

        <div class="mb-4">
            <label for="cirujano" class="font-semibold text-indigo-700 block mb-2">Cirujano</label>
            <input type="text" name="cirujano" id="cirujano" value="{{ old('cirujano', $cirugia->cirujano) }}"
                class="w-full bg-indigo-100 p-2 border border-black rounded">
        </div>

        <div class="mb-4">
            <label for="descripcion" class="font-semibold text-indigo-700 block mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                class="w-full bg-indigo-100 p-2 border border-black rounded">{{ old('descripcion', $cirugia->descripcion) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="complicaciones" class="font-semibold text-indigo-700 block mb-2">Complicaciones</label>
            <textarea name="complicaciones" id="complicaciones" rows="3"
                class="w-full bg-indigo-100 p-2 border border-black rounded">{{ old('complicaciones', $cirugia->complicaciones) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="notas_postoperatorias" class="font-semibold text-indigo-700 block mb-2">Notas Postoperatorias</label>
            <textarea name="notas_postoperatorias" id="notas_postoperatorias" rows="3"
                class="w-full bg-indigo-100 p-2 border border-black rounded">{{ old('notas_postoperatorias', $cirugia->notas_postoperatorias) }}</textarea>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit"
                class="px-10 py-3 bg-indigo-600 text-white rounded-lg border-2 border-black hover:bg-indigo-400">
                Guardar
            </button>

            <a href="{{ route('cirugias.index', ['dni' => $paciente->dni]) }}"
                class="px-10 py-3 bg-indigo-600 text-white rounded-lg border-2 border-black hover:bg-indigo-400">
                Cancelar
            </a>
        </div>
    </form>
</div>
</div>
@endsection