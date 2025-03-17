@extends('layouts.admin-centro')

@section('title', 'Registrar Donador de Sangre')

@section('content')
<div style="max-width: 700px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h2 style="text-align: center; margin-bottom: 20px; color: #004643;">Registrar Donador de Sangre</h2>

    <!-- Campo para buscar DNI -->
    <div style="margin-bottom: 15px;">
        <label for="buscar_dni" style="display: block; font-weight: bold;">Buscar DNI:</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="buscar_dni" name="buscar_dni" placeholder="Ingrese DNI" maxlength="8"
                   style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="button" id="btn-buscar-dni"
                    style="background: #004643; color: #fff; padding: 10px; border: none; border-radius: 4px;">
                Buscar
            </button>
        </div>
    </div>

    <form action="{{ route('sangre.donadores.store') }}" method="POST">
        @csrf

        <!-- Nombre -->
        <div style="margin-bottom: 15px;">
            <label for="nombre" style="display: block; font-weight: bold;">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required readonly>
        </div>

        <!-- Apellido -->
        <div style="margin-bottom: 15px;">
            <label for="apellido" style="display: block; font-weight: bold;">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required readonly>
        </div>

        <!-- DNI -->
        <div style="margin-bottom: 15px;">
            <label for="dni" style="display: block; font-weight: bold;">DNI:</label>
            <input type="text" id="dni" name="dni" value="{{ old('dni') }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required readonly>
        </div>

        <!-- Tipo de Sangre -->
        <div style="margin-bottom: 15px;">
            <label for="tipo_sangre" style="display: block; font-weight: bold;">Tipo de Sangre:</label>
            <select id="tipo_sangre" name="tipo_sangre" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                <option value="">Seleccione un tipo de sangre</option>
                <option value="A+" {{ old('tipo_sangre') == 'A+' ? 'selected' : '' }}>A+</option>
                <option value="A-" {{ old('tipo_sangre') == 'A-' ? 'selected' : '' }}>A-</option>
                <option value="B+" {{ old('tipo_sangre') == 'B+' ? 'selected' : '' }}>B+</option>
                <option value="B-" {{ old('tipo_sangre') == 'B-' ? 'selected' : '' }}>B-</option>
                <option value="O+" {{ old('tipo_sangre') == 'O+' ? 'selected' : '' }}>O+</option>
                <option value="O-" {{ old('tipo_sangre') == 'O-' ? 'selected' : '' }}>O-</option>
                <option value="AB+" {{ old('tipo_sangre') == 'AB+' ? 'selected' : '' }}>AB+</option>
                <option value="AB-" {{ old('tipo_sangre') == 'AB-' ? 'selected' : '' }}>AB-</option>
            </select>
        </div>

        <!-- Teléfono -->
        <div style="margin-bottom: 15px;">
            <label for="telefono" style="display: block; font-weight: bold;">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <!-- Estado -->
        <div style="margin-bottom: 15px;">
            <label for="estado" style="display: block; font-weight: bold;">Estado:</label>
            <select id="estado" name="estado" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                <option value="POR_EXAMINAR" {{ old('estado') == 'POR_EXAMINAR' ? 'selected' : '' }}>Por Examinar</option>
                <option value="APTO" {{ old('estado') == 'APTO' ? 'selected' : '' }}>Apto</option>
                <option value="NO_APTO" {{ old('estado') == 'NO_APTO' ? 'selected' : '' }}>No Apto</option>
            </select>
        </div>

        <!-- Última Donación -->
        <div style="margin-bottom: 15px;">
            <label for="ultima_donacion" style="display: block; font-weight: bold;">Última Donación (Opcional):</label>
            <input type="date" id="ultima_donacion" name="ultima_donacion" value="{{ old('ultima_donacion') }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <button type="submit" style="background: #004643; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; width: 100%;">
            Registrar
        </button>
    </form>
</div>

<script>
    document.getElementById('btn-buscar-dni').addEventListener('click', async () => {
        const dni = document.getElementById('buscar_dni').value.trim();

        if (!dni || dni.length !== 8) {
            alert('Por favor, ingrese un DNI válido.');
            return;
        }

        try {
            const response = await fetch(`/buscar-dni?dni=${dni}`);
            if (!response.ok) {
                throw new Error('Error al consultar el DNI.');
            }

            const datos = await response.json();

            // Rellenar los campos automáticamente
            document.getElementById('nombre').value = datos.nombres || '';
            document.getElementById('apellido').value = `${datos.apellidoPaterno || ''} ${datos.apellidoMaterno || ''}`;
            document.getElementById('dni').value = datos.numeroDocumento || '';
        } catch (error) {
            console.error(error);
            alert('Error al buscar el DNI. Intente nuevamente.');
        }
    });
</script>
@endsection
