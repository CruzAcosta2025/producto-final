@extends('layouts.admin-centro')

@section('title', 'Editar Paciente')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-sky-600">
            <h2 class="text-3xl font-semibold text-white text-center">Editar Paciente</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pacientes.update', $paciente->id_paciente) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            @php
                $fields = [
                    'dni' => 'DNI',
                    'primer_nombre' => 'Primer Nombre',
                    'segundo_nombre' => 'Segundo Nombre',
                    'primer_apellido' => 'Primer Apellido',
                    'segundo_apellido' => 'Segundo Apellido'
                ];
            @endphp

            @foreach ($fields as $field => $label)
                <div>
                    <label class="block text-lg font-semibold text-gray-700">{{ $label }}</label>
                    <input type="text" name="{{ $field }}" value="{{ old($field, $paciente->$field) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 cursor-not-allowed" readonly>
                </div>
            @endforeach

            <div>
                <label class="block text-lg font-semibold text-gray-700">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Género</label>
                <select name="genero" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                    <option value="Masculino" {{ old('genero', $paciente->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('genero', $paciente->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Dirección</label>
                <textarea name="direccion" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="2" required>{{ old('direccion', $paciente->direccion) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-lg font-semibold text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $paciente->telefono) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-lg font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $paciente->email) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Grupo Sanguíneo</label>
                <select name="grupo_sanguineo" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                    @foreach(['O-', 'O+', 'A-', 'A+', 'B-', 'B+', 'AB-', 'AB+'] as $grupo)
                        <option value="{{ $grupo }}" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == $grupo ? 'selected' : '' }}>{{ $grupo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Contacto de Emergencia</label>
                <input type="text" name="nombre_contacto_emergencia" value="{{ old('nombre_contacto_emergencia', $paciente->nombre_contacto_emergencia) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-lg font-semibold text-gray-700">Teléfono de Emergencia</label>
                    <input type="text" name="telefono_contacto_emergencia" value="{{ old('telefono_contacto_emergencia', $paciente->telefono_contacto_emergencia) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-lg font-semibold text-gray-700">Relación de Emergencia</label>
                    <input type="text" name="relacion_contacto_emergencia" value="{{ old('relacion_contacto_emergencia', $paciente->relacion_contacto_emergencia) }}" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">¿Es donador de sangre?</label>
                <select name="es_donador" class="w-full p-3 border-2 border-black rounded-lg bg-sky-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="SI" {{ old('es_donador', $paciente->es_donador) == 'SI' ? 'selected' : '' }}>Sí</option>
                    <option value="NO" {{ old('es_donador', $paciente->es_donador) == 'NO' ? 'selected' : '' }}>No</option>
                    <option value="POR_EXAMINAR" {{ old('es_donador', $paciente->es_donador) == 'POR_EXAMINAR' ? 'selected' : '' }}>Por Examinar</option>
                </select>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-sky-300 text-gray-700 rounded-lg border-2 border-black hover:bg-sky-400">
                    Actualizar
                </button>
                <a href="{{ route('pacientes.index') }}" class="px-20 py-3 bg-sky-300 text-gray-700 rounded-lg border-2 border-black hover:bg-sky-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
