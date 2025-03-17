@extends('layouts.admin-centro')

@section('title', 'Registrar Nueva Vacuna')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg border-2 border-black">
    <div class="px-6 py-4 bg-amber-700 rounded-t-lg">
        <!-- Encabezado -->
        <div class="px-6 py-4 bg-amber-700 rounded-t-lg">
            <h2 class="text-3xl font-semibold text-white text-center">
                Registrar Nueva Vacuna para {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}
            </h2>
        </div>
    </div>

    <!-- Formulario -->
    <div class="p-6">
        <form action="{{ route('vacunas.store', $historial->id_historial) }}" method="POST">
            @csrf

            <!-- Nombre de la Vacuna -->
            <div class="mb-4">
                <label for="nombre_vacuna" class="block font-bold mb-1">Nombre de la Vacuna</label>
                <input type="text" name="nombre_vacuna" id="nombre_vacuna" required
                    class="w-full bg-amber-100 p-2 border border-black rounded">
            </div>

            <!-- Fecha de Aplicación -->
            <div class="mb-4">
                <label for="fecha_aplicacion" class="block font-bold mb-1">Fecha de Aplicación</label>
                <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" required
                    class="w-full bg-amber-100 p-2 border border-black rounded">
            </div>

            <!-- Dosis -->
            <div class="mb-4">
                <label for="dosis" class="block font-bold mb-1">Dosis</label>
                <input type="text" name="dosis" id="dosis" required
                    class="w-full bg-amber-100 p-2 border border-black rounded">
            </div>

            <!-- Próxima Dosis -->
            <div class="mb-4">
                <label for="proxima_dosis" class="block font-bold mb-1">Próxima Dosis</label>
                <input type="date" name="proxima_dosis" id="proxima_dosis"
                    class="w-full bg-amber-100 p-2 border border-black rounded">
            </div>

            <!-- Observaciones -->
            <div class="mb-4">
                <label for="observaciones" class="block font-bold mb-1">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="4"
                    class="w-full bg-amber-100 p-2 border border-black rounded"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end items-center mt-6 space-x-4">
                <a href="{{ route('vacunas.index', ['dni' => $paciente->dni]) }}"
                    class="px-10 py-3 bg-amber-500 text-white rounded-lg border-2 border-black hover:bg-amber-400">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-10 py-3 bg-amber-500 text-white rounded-lg border-2 border-black hover:bg-amber-400">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection