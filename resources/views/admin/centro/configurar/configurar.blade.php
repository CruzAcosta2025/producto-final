@extends('layouts.admin-centro')


@section('title', 'Configurar Centro Médico')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-lime-500">
            <h2 class="text-3xl font-semibold text-white text-center">Configurar Centro Medico</h2>
        </div>

        @if (session('success'))
        <p class="text-green-600 text-center font-medium">{{ session('success') }}</p>
        @endif

        <form action="{{ route('configurar.centro.update') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-gray-700 font-medium">Nombre del Centro Médico</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $centroMedico->nombre) }}" class="w-full bg-lime-100 p-2 border rounded-lg focus:ring-2 focus:ring-lime-500">
                @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="direccion" class="block text-gray-700 font-medium">Dirección</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $centroMedico->direccion) }}" class="w-full bg-lime-100 p-2 border rounded-lg focus:ring-2 focus:ring-lime-500">
                @error('direccion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="ruc" class="block text-gray-700 font-medium">RUC</label>
                <input type="text" name="ruc" id="ruc" value="{{ old('ruc', $centroMedico->ruc) }}" class="w-full bg-lime-100 p-2 border rounded-lg focus:ring-2 focus:ring-lime-500">
                @error('ruc') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="color_tema" class="block text-gray-700 font-medium">Color del Tema</label>
                <input type="color" name="color_tema" id="color_tema" value="{{ old('color_tema', $centroMedico->color_tema) }}" class="w-full p-2 border rounded-lg">
                @error('color_tema') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="logo" class="block text-gray-700 font-medium">Logo</label>
                <input type="file" name="logo" id="logo" class="w-full p-2 border rounded-lg">
                @if ($centroMedico->logo)
                <p class="text-sm mt-2">Logo Actual:</p>
                <img src="{{ asset('storage/' . $centroMedico->logo) }}" alt="Logo Centro Médico" class="max-w-24 h-auto mt-2 border rounded-lg">
                @endif
                @error('logo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-lime-700 transition duration-300">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
    @endsection