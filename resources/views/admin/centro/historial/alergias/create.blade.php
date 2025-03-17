@extends('layouts.admin-centro')

@section('title', 'Registrar Nueva Alergia')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-green-700 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">
        Registrar Nueva Alergia para {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}
        </h2>
    </div>

        <form action="{{ route('alergias.store', $paciente->id_paciente) }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="tipo" class="block font-bold mb-1">Tipo de Alergia</label>
                <input type="text" name="tipo" id="tipo" required class="w-full bg-green-100 p-2 border border-black rounded">
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block font-bold mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" required class="w-full bg-green-100 p-2 border border-black rounded"></textarea>
            </div>
            <div class="mb-4">
                <label for="severidad" class="block font-bold mb-1">Severidad</label>
                <select name="severidad" id="severidad" required class="w-full bg-green-100 p-2 border border-black rounded">
                    <option value="leve">Leve</option>
                    <option value="moderada">Moderada</option>
                    <option value="severa">Severa</option>
                </select>
            </div>
            <div class="flex justify-between mt-4">
                <button type="submit" class="px-10 py-3 bg-green-500 text-white rounded-lg border-2 border-black hover:bg-green-400">
                    Registrar
                </button>
                <a href="{{ route('alergias.index') }}" class="px-10 py-3 bg-green-500 text-white rounded-lg border-2 border-black hover:bg-green-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
