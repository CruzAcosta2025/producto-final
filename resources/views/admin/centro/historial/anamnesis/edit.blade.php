@extends('layouts.admin-centro')

@section('title', 'Editar Anamnesis')

@section('content')
<div class="card">
    <h2 class="text-2xl font-bold mb-4">Editar Anamnesis</h2>

    <form action="{{ route('anamnesis.update', ['idHistorial' => $idHistorial, 'idAnamnesis' => $anamnesis->id_anamnesis]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Sección de Antecedentes -->
        <h3>Antecedentes</h3>
        <textarea name="antecedentes" rows="3" class="form-input" required>{{ $antecedentes }}</textarea>

        <!-- Sección de Síntomas Actuales -->
        <h3>Síntomas Actuales</h3>
        <textarea name="sintomas_actuales" rows="3" class="form-input" required>{{ $sintomas_actuales }}</textarea>

        <!-- Sección de Hábitos -->
        <h3>Hábitos</h3>
        <textarea name="habitos" rows="3" class="form-input">{{ $habitos }}</textarea>

        <button type="submit" class="btn btn-submit">Actualizar Anamnesis</button>
        <a href="{{ route('historial.show', $idHistorial) }}" class="btn btn-back">Regresar</a>
    </form>
</div>
@endsection

<style>
    .card {
        padding: 1.5rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .form-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 1rem;
    }
    .btn-submit {
        padding: 8px 16px;
        background-color: #3b82f6;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-back {
        padding: 8px 16px;
        background-color: #6b7280;
        color: #ffffff;
        border-radius: 4px;
        text-decoration: none;
    }
</style>
