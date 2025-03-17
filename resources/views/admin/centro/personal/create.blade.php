@extends('layouts.admin-centro')

@section('title', 'Agregar Personal Médico')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-amber-500">
           <h2 class="text-3xl font-semibold text-white text-center">Agregar Personal Médico</h2>
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

        <form action="{{ route('personal.store', ['id' => $usuario->id_usuario]) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="id_especialidad" class="block text-lg font-semibold text-gray-700">Especialidad:</label>
                <select name="id_especialidad" id="id_especialidad" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                    @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad->id_especialidad }}">{{ $especialidad->nombre_especialidad }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="dni" class="block text-lg font-semibold text-gray-700">DNI:</label>
                    <input type="text" name="dni" id="dni" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>
                <div>
                    <label for="telefono" class="block text-lg font-semibold text-gray-700">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div>
                <label for="correo_contacto" class="block text-lg font-semibold text-gray-700">Correo de Contacto:</label>
                <input type="email" name="correo_contacto" id="correo_contacto" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="sueldo" class="block text-lg font-semibold text-gray-700">Sueldo:</label>
                    <input type="number" name="sueldo" id="sueldo" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500" required step="0.01">
                </div>
                <div>
                    <label for="codigo_postal" class="block text-lg font-semibold text-gray-700">Código Postal:</label>
                    <input type="text" name="codigo_postal" id="codigo_postal" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div>
                <label for="fecha_alta" class="block text-lg font-semibold text-gray-700">Fecha de Alta:</label>
                <input type="date" name="fecha_alta" id="fecha_alta" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="banco" class="block text-lg font-semibold text-gray-700">Banco:</label>
                    <input type="text" name="banco" id="banco" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label for="numero_cuenta" class="block text-lg font-semibold text-gray-700">Número de Cuenta:</label>
                    <input type="text" name="numero_cuenta" id="numero_cuenta" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="numero_colegiatura" class="block text-lg font-semibold text-gray-700">Número de Colegiatura:</label>
                    <input type="text" name="numero_colegiatura" id="numero_colegiatura" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label for="direccion" class="block text-lg font-semibold text-gray-700">Dirección:</label>
                    <textarea name="direccion" id="direccion" class="w-full p-3 border-2 border-black rounded-lg bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                </div>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-amber-300 text-white rounded-lg border-2 border-amber-500 hover:bg-amber-500">
                    Guardar
                </button>
                <a href="{{ route('personal-medico.index') }}" class="px-20 py-3 bg-amber-300 text-white rounded-lg border-2 border-amber-500 hover:bg-amber-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection