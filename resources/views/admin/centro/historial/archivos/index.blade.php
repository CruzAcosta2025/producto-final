@extends($layout)

@section('title', 'Gestión de Archivos Adjuntos')

@section('content')
<div class="card">
    <h2 class="text-xl font-bold mb-4">Gestión de Archivos Adjuntos</h2>

    <!-- Formulario de Búsqueda -->
    <form action="{{ route('archivos.index', ['idHistorial' => $idHistorial ?? null]) }}" method="GET" class="mb-4">
        <label for="dni" class="block font-bold">Buscar por DNI:</label>
        <input type="text" id="dni" name="dni" class="form-input mb-4" placeholder="Ingrese el DNI del paciente" required>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Resultado de la búsqueda -->
    @if ($dni && !$paciente)
        <p>No se encontró un paciente con el DNI ingresado.</p>
    @endif

    @if ($paciente)
        <h3 class="text-lg font-bold mb-4">Paciente: {{ $paciente->paciente->primer_nombre }} {{ $paciente->paciente->primer_apellido }}</h3>

        <!-- Lista de consultas -->
        <h4>Consultas</h4>
        @if ($consultas->isEmpty())
            <p>No hay consultas registradas para este paciente.</p>
        @else
            <ul>
                @foreach ($consultas as $consulta)
                    <li>
                        <strong>Consulta:</strong> {{ $consulta->fecha_consulta }} <br>
                        <a href="{{ route('archivos.create', ['idHistorial' => $paciente->id_historial]) }}?id_consulta={{ $consulta->id_consulta }}" class="btn btn-primary">Añadir Archivo</a>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Lista de exámenes -->
        <h4>Exámenes Médicos</h4>
        @if ($examenes->isEmpty())
            <p>No hay exámenes registrados para este paciente.</p>
        @else
            <ul>
                @foreach ($examenes as $examen)
                    <li>
                        <strong>Examen:</strong> {{ $examen->tipo_examen }} <br>
                        <a href="{{ route('archivos.create', ['idHistorial' => $paciente->id_historial]) }}?id_examen={{ $examen->id_examen }}" class="btn btn-primary">Añadir Archivo</a>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif

    <!-- Archivos adjuntos -->
    @if ($archivos->isNotEmpty())
        <h3 class="text-lg font-bold mb-4">Archivos Adjuntos</h3>
        <ul>
            @foreach ($archivos as $archivo)
                <li>
                    <strong>Tipo:</strong> {{ $archivo->tipo_archivo }} <br>
                    <strong>Nombre:</strong> {{ $archivo->nombre_archivo }} <br>
                    <strong>Descripción:</strong> {{ $archivo->descripcion ?? 'Sin descripción' }} <br>
                    <a href="{{ asset('storage/' . $archivo->ruta_archivo) }}" target="_blank" class="btn btn-view">Ver Archivo</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

<style>
    .card {
        padding: 1rem;
        background: white;
        border-radius: 8px;
    }

    .form-input {
        display: block;
        margin: 0.5rem 0;
        width: 100%;
        padding: 0.5rem;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn {
        padding: 0.5rem 1rem;
        background: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #0056b3;
    }
</style>
