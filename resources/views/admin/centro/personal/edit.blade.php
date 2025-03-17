@extends('layouts.admin-centro')

@section('title', 'Agregar Personal Médico')

@section('content')

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personal Médico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg border-2 border-black">
        <h2 class="text-3xl font-semibold text-center bg-amber-500 text-white py-4 rounded-t-xl">Editar Personal Médico</h2>

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('personal-medico.update', $personal->id_personal_medico) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block font-semibold text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500" value="{{ old('nombre', $personal->usuario->nombre) }}" required>
            </div>

            <div>
                <label for="id_especialidad" class="block font-semibold text-gray-700">Especialidad:</label>
                <select name="id_especialidad" id="id_especialidad" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500">
                    <option value="">Ninguna</option>
                    @foreach ($especialidades as $especialidad)
                    <option value="{{ $especialidad->id_especialidad }}" {{ old('id_especialidad', $personal->id_especialidad) == $especialidad->id_especialidad ? 'selected' : '' }}>
                        {{ $especialidad->nombre_especialidad }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="dni" class="block font-semibold text-gray-700">DNI:</label>
                    <input type="text" name="dni" id="dni" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500" value="{{ old('dni', $personal->dni) }}" required>
                </div>
                <div>
                    <label for="telefono" class="block font-semibold text-gray-700">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500" value="{{ old('telefono', $personal->telefono) }}">
                </div>
            </div>

            <div>
                <label for="correo_contacto" class="block font-semibold text-gray-700">Correo de Contacto:</label>
                <input type="email" name="correo_contacto" id="correo_contacto" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500" value="{{ old('correo_contacto', $personal->correo_contacto) }}" required>
            </div>

            <div>
                <label for="sueldo" class="block font-semibold text-gray-700">Sueldo:</label>
                <input type="number" step="0.01" name="sueldo" id="sueldo" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500" value="{{ old('sueldo', $personal->sueldo) }}" required>
            </div>

            <div>
                <label for="direccion" class="block font-semibold text-gray-700">Dirección:</label>
                <textarea name="direccion" id="direccion" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:ring-2 focus:ring-amber-500">{{ old('direccion', $personal->direccion) }}</textarea>
            </div>

            <div class="flex justify-between mt-4">
                <button type="submit" class="px-20 py-3 bg-amber-300 text-white rounded-lg border-2 border-amber-500 hover:bg-amber-400">
                    Actualizar
                </button>
                <a href="{{ route('personal-medico.index') }}" class="px-20 py-3 bg-amber-300 text-white rounded-lg border-2 border-amber-500 hover:bg-amber-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>

</html>
@endsection