@extends('layouts.admin-centro')

@section('title', 'Detalle de Consulta')

@section('content')
<div class="card">
    <h2 class="text-2xl font-bold mb-4">Detalle de Consulta</h2>

    <p><strong>Fecha de Consulta:</strong> {{ $consulta->fecha_consulta }}</p>
    <p><strong>Motivo de la Consulta:</strong> {{ $consulta->motivo_consulta }}</p>
    <p><strong>Síntomas:</strong> {{ $consulta->sintomas }}</p>
    <p><strong>Observaciones:</strong> {{ $consulta->observaciones }}</p>

    <h4 class="font-bold mt-4">Archivos Adjuntos:</h4>
    @if($consulta->archivos->isEmpty())
        <p>No hay archivos adjuntos.</p>
    @else
        <ul>
            @foreach($consulta->archivos as $archivo)
                <li>
                    <a href="{{ asset('storage/' . $archivo->ruta_archivo) }}" target="_blank">{{ $archivo->nombre_archivo }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('historial.show', $consulta->id_historial) }}" class="btn btn-secondary mt-4">Regresar</a>
</div>
@endsection
