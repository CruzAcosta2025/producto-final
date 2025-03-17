@extends('layouts.admin-centro')

@section('title', 'Agregar Paciente')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-sky-700 rounded-t-lg">
        <h2 class="text-3xl font-semibold text-white text-center">Agregar Paciente</h2>
    </div>


    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4 border border-red-500">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Campo para buscar DNI -->
    <div class="mb-4">
        <label for="buscar_dni" class="font-bold ">DNI</label>
        <div class="flex gap-2">
            <input type="text" name="buscar_dni" id="buscar_dni" maxlength="8"
                pattern="[0-9]{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                placeholder="Ingrese DNI a buscar"
                class="bg-sky-100 flex-1 p-2 border border-black rounded" required>

            <button type="button" id="buscar-dni"
                class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">Buscar DNI</button>
        </div>
    </div>

    <!-- Formulario de creación -->
    <form action="{{ route('pacientes.store') }}" method="POST" id="form-paciente" class="space-y-4">
        @csrf
        <div>
            <label for="dni" class="font-bold">DNI</label>
            <input type="text" name="dni" id="dni" class="w-full bg-sky-100 p-2 border border-black rounded" readonly required>
        </div>

        <div>
            <label for="primer_nombre" class="font-bold">Primer Nombre</label>
            <input type="text" name="primer_nombre" id="primer_nombre" class="w-full bg-sky-100 p-2 border border-black rounded" readonly required>
        </div>

        <div>
            <label for="primer_apellido" class="font-bold">Primer Apellido</label>
            <input type="text" name="primer_apellido" id="primer_apellido" class="w-full bg-sky-100 p-2 border border-black rounded" readonly required>
        </div>

        <div>
            <label for="segundo_apellido" class="font-bold">Segundo Apellido</label>
            <input type="text" name="segundo_apellido" id="segundo_apellido" class="w-full bg-sky-100 p-2 border border-black rounded" readonly required>
        </div>

        <div>
            <label for="fecha_nacimiento" class="font-bold">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="w-full bg-sky-100 p-2 border border-black rounded" required>
        </div>
        <div>
            <label for="telefono" class="font-bold">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="w-full bg-sky-100 p-2 border border-black rounded" required>
        </div>
        <div>
            <label for="grupo_sanguineo" class="font-bold">Grupo Sanguíneo</label>
            <select name="grupo_sanguineo" id="grupo_sanguineo" class="w-full bg-sky-100 p-2 border border-black rounded" required>
                <option value="" disabled selected>Selecciona un grupo sanguíneo</option>
                <option value="O-">O-</option>
                <option value="O+">O+</option>
                <option value="A-">A-</option>
                <option value="A+">A+</option>
                <option value="B-">B-</option>
                <option value="B+">B+</option>
                <option value="AB-">AB-</option>
                <option value="AB+">AB+</option>
            </select>
        </div>
        <div class="flex justify-between items-center mt-4">
            <button type="submit"
                class="px-10 py-3 bg-sky-500 text-white rounded-lg border-2 border-black hover:bg-sky-400">
                Guardar</button>
            <a href="{{ route('pacientes.index') }}"
                class="px-10 py-3 bg-sky-500 text-white rounded-lg border-2 border-black hover:bg-sky-400">
                Cancelar</a>
        </div>
    </form>
</div>


<script>
    document.getElementById('buscar-dni').addEventListener('click', async () => {
        const dni = document.getElementById('buscar_dni').value.trim();
        if (!dni || dni.length !== 8) {
            alert('Por favor, ingresa un DNI válido de 8 dígitos.');
            return;
        }

        try {
            const response = await fetch(`/buscar-dni/${dni}`);
            const text = await response.text();

            if (text.startsWith('<')) {
                throw new Error('Error inesperado: Laravel devolvió HTML en lugar de JSON.');
            }

            const data = JSON.parse(text);
            if (!response.ok) throw new Error(data.error || 'Error al consultar DNI');

            document.getElementById('dni').value = data.dni || '';
            document.getElementById('primer_nombre').value = data.primer_nombre || '';
            document.getElementById('primer_apellido').value = data.primer_apellido || '';
            document.getElementById('segundo_apellido').value = data.segundo_apellido || '';
        } catch (error) {
            alert(error.message);
        }
    });
</script>


@endsection