@extends('layouts.admin-centro')

@section('title', 'Editar Trabajador No Médico')

@section('content')
<style>
    .container {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        max-width: 800px;
        margin: auto;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-label {
        font-weight: bold;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .btn-link {
            margin-left: 1rem;
            text-decoration: none;
            color: #0d9488;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
    .btn-primary {
        background: #0d9488;
        color: #ffffff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-primary:hover {
        background: #0f766e;
    }
</style>

<div class="container">
    <h2>Editar Trabajador No Médico</h2>
    <form action="{{ route('trabajadores.update', ['id' => $trabajador->id_personal_medico]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="dni" class="form-label">DNI:</label>
            <input type="text" name="dni" id="dni" class="form-control" value="{{ $trabajador->dni }}" required maxlength="8" pattern="\d{8}">
        </div>
        <div class="form-group">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $trabajador->telefono }}" maxlength="9" pattern="\d{9}">
        </div>
        <div class="form-group">
            <label for="correo_contacto" class="form-label">Correo de contacto:</label>
            <input type="email" name="correo_contacto" id="correo_contacto" class="form-control" value="{{ $trabajador->correo_contacto }}" required>
        </div>
        <div class="form-group">
            <label for="sueldo" class="form-label">Sueldo:</label>
            <input type="number" step="0.01" name="sueldo" id="sueldo" class="form-control" value="{{ $trabajador->sueldo }}" required min="0" max="999999.99">
        </div>
        <div class="form-group">
            <label for="codigo_postal" class="form-label">Código Postal:</label>
            <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" value="{{ $trabajador->codigo_postal }}" maxlength="5" pattern="\d{5}">
        </div>
        <div class="form-group">
            <label for="banco" class="form-label">Banco:</label>
            <input type="text" name="banco" id="banco" class="form-control" value="{{ $trabajador->banco }}">
        </div>
        <div class="form-group">
            <label for="numero_cuenta" class="form-label">Número de Cuenta:</label>
            <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control" value="{{ $trabajador->numero_cuenta }}" maxlength="20">
        </div>
        <div class="form-group">
            <label for="direccion" class="form-label">Dirección:</label>
            <textarea name="direccion" id="direccion" class="form-control">{{ $trabajador->direccion }}</textarea>
        </div>
        <button type="submit" class="btn-primary">Actualizar</button>
        <a href="{{ route('trabajadores.index') }}" class="btn-link">Cancelar</a>
    </form>
</div>
@endsection
