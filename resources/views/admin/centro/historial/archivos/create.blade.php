@extends($layout)

@section('title', 'Subir Archivo Adjunto')

@section('content')
<div class="card">
    <h2 class="text-xl font-bold mb-4">Subir Archivo Adjunto</h2>
    <form action="{{ route('archivos.store', $historial->id_historial) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="tipo_archivo" class="block font-bold mb-2">Tipo de Archivo:</label>
        <input type="text" id="tipo_archivo" name="tipo_archivo" class="form-input mb-4" required>

        <label for="archivo" class="block font-bold mb-2">Archivo:</label>
        <input type="file" id="archivo" name="archivo" class="form-input mb-4" required>

        <label for="descripcion" class="block font-bold mb-2">Descripción (opcional):</label>
        <textarea id="descripcion" name="descripcion" class="form-input mb-4"></textarea>

        <label for="id_consulta" class="block font-bold">Consulta:</label>
        <select id="id_consulta" name="id_consulta" class="form-input mb-4">
            <option value="">Seleccione una consulta</option>
            @foreach ($consultas as $consulta)
                <option value="{{ $consulta->id_consulta }}">Consulta del {{ $consulta->fecha_consulta }}</option>
            @endforeach
        </select>

        <label for="id_examen" class="block font-bold">Examen Médico:</label>
        <select id="id_examen" name="id_examen" class="form-input mb-4">
            <option value="">Seleccione un examen</option>
            @foreach ($examenes as $examen)
                <option value="{{ $examen->id_examen }}">{{ $examen->tipo_examen }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Subir Archivo</button>
    </form>
</div>
@endsection

