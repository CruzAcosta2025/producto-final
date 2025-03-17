@extends('layouts.admin-centro')

@section('title', 'Gestión de Trabajadores No Médicos')

@section('content')

<style>
    .personal-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        background: white;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .personal-table th,
    .personal-table td {
        padding: 0.75rem;
        border: 1px solid #ddd;
        text-align: left;
    }
    .personal-table th {
        background: #f3f4f6;
        font-weight: bold;
    }
    .personal-table tr:hover {
        background: #f9fafb;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .btn {
        background: #0d9488;
        color: #ffffff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        display: inline-block;
    }
    .btn:hover {
        background: #0f766e;
    }
    .btn-delete {
        background: #ef4444;
    }
    .btn-delete:hover {
        background: #dc2626;
    }
    @media (max-width: 640px) {
        .personal-table th, .personal-table td {
            padding: 0.5rem;
        }
        .header-section {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="header-section">
    <h2 class="text-xl font-bold">Gestión de Trabajadores No Médicos</h2>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="table-container">
    <table class="personal-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th style="text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trabajadoresNoMedicos as $trabajador)
                <tr>
                    <td>{{ $trabajador->usuario->nombre }}</td>
                    <td>{{ $trabajador->usuario->email }}</td>
                    <td>{{ $trabajador->dni }}</td>
                    <td>{{ $trabajador->telefono }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('trabajadores.edit', $trabajador->id_personal_medico) }}" class="btn">Editar</a>
                            <form action="{{ route('trabajadores.destroy', $trabajador->id_personal_medico) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este trabajador?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete"disabled>Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No hay trabajadores no médicos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
