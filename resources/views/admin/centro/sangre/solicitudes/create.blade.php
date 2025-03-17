@extends('layouts.admin-centro')

@section('title', 'Registrar Solicitud de Sangre')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg border-2 border-black">
        <div class="px-6 py-4 bg-blue-900">
            <h2 class="text-3xl font-semibold text-white text-center">Registrar Solicitud de Sangre</h2>
        </div>

        <form action="{{ route('sangre.solicitudes.store') }}" method="POST" class="space-y-4" id="solicitud-form">
            @csrf

            <div>
                <label for="dni" class="block text-lg font-semibold text-gray-700">Buscar Paciente por DNI:</label>
                <div class="flex gap-2">
                    <input type="text" id="dni" name="dni" placeholder="Ingrese DNI" class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" id="buscar-dni" class="px-4 py-3 bg-blue-900 text-white rounded-lg border-2 border-black hover:bg-blue-700">Buscar</button>
                </div>
                <span id="paciente-info" class="text-sm text-blue-900"></span>
                <span id="error-info" class="text-sm text-red-600"></span>
            </div>

            <input type="hidden" id="id_paciente" name="id_paciente">

            <div>
                <label for="tipo_sangre" class="block text-lg font-semibold text-gray-700">Tipo de Sangre:</label>
                <input type="text" id="tipo_sangre" name="tipo_sangre" readonly class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none">
            </div>

            <div>
                <label for="cantidad" class="block text-lg font-semibold text-gray-700">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" min="1" max="10" required class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="fecha_solicitud" class="block text-lg font-semibold text-gray-700">Fecha de Solicitud:</label>
                <input type="date" id="fecha_solicitud" name="fecha_solicitud" required class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="urgencia" class="block text-lg font-semibold text-gray-700">Nivel de Urgencia:</label>
                <select id="urgencia" name="urgencia" required class="w-full p-3 border-2 border-black rounded-lg bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="BAJA">Baja</option>
                    <option value="MEDIA">Media</option>
                    <option value="ALTA">Alta</option>
                </select>
            </div>

            <div class="flex justify-between items-center mt-4">
                <button type="submit" class="px-20 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Guardar
                </button>
                <a href="{{ route('sangre.solicitudes.index') }}" class="px-20 py-3 bg-gray-300 text-gray-700 rounded-lg border-2 border-gray-500 hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('buscar-dni').addEventListener('click', function() {
        const dni = document.getElementById('dni').value;
        document.getElementById('paciente-info').innerText = '';
        document.getElementById('error-info').innerText = '';

        if (!dni) {
            document.getElementById('error-info').innerText = 'Por favor, ingrese un DNI para buscar.';
            return;
        }

        fetch(`/sangre/buscar-paciente?dni=${dni}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('paciente-info').innerText = `Paciente: ${data.primer_nombre} ${data.primer_apellido}`;
                    document.getElementById('id_paciente').value = data.id_paciente;
                    document.getElementById('tipo_sangre').value = data.grupo_sanguineo;
                } else {
                    document.getElementById('error-info').innerText = 'Paciente no encontrado. Registre al paciente primero.';
                    document.getElementById('id_paciente').value = '';
                    document.getElementById('tipo_sangre').value = '';
                }
            })
            .catch(error => {
                console.error('Error en la búsqueda del DNI:', error);
                document.getElementById('error-info').innerText = 'Hubo un error al buscar el DNI.';
            });
    });
</script>
@endsection