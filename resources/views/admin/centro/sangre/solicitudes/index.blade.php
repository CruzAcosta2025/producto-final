@extends('layouts.admin-centro')

@section('title', 'Gestión de Solicitudes de Sangre')

@section('content')
<div style="max-width: 1200px; margin: auto; padding: 20px;">
    <h2 style="text-align: center; margin-bottom: 20px; color: #004643;">Solicitudes de Sangre</h2>

    <!-- Filtros de búsqueda -->
    <form action="{{ route('sangre.solicitudes.index') }}" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="paciente_nombre" value="{{ request('paciente_nombre') }}" placeholder="Buscar por nombre o apellido"
               style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 200px;">
        <input type="text" name="dni" value="{{ request('dni') }}" placeholder="Buscar por DNI"
               style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 200px;">
        <select name="tipo_sangre" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">Todos los Tipos de Sangre</option>
            <option value="A+" {{ request('tipo_sangre') == 'A+' ? 'selected' : '' }}>A+</option>
            <option value="A-" {{ request('tipo_sangre') == 'A-' ? 'selected' : '' }}>A-</option>
            <option value="B+" {{ request('tipo_sangre') == 'B+' ? 'selected' : '' }}>B+</option>
            <option value="B-" {{ request('tipo_sangre') == 'B-' ? 'selected' : '' }}>B-</option>
            <option value="O+" {{ request('tipo_sangre') == 'O+' ? 'selected' : '' }}>O+</option>
            <option value="O-" {{ request('tipo_sangre') == 'O-' ? 'selected' : '' }}>O-</option>
            <option value="AB+" {{ request('tipo_sangre') == 'AB+' ? 'selected' : '' }}>AB+</option>
            <option value="AB-" {{ request('tipo_sangre') == 'AB-' ? 'selected' : '' }}>AB-</option>
        </select>
        <button type="submit" style="padding: 10px; border: none; background: #004643; color: #fff; border-radius: 4px;">
            Buscar
        </button>
        <a href="{{ route('sangre.solicitudes.create') }}"
           style="padding: 10px; background: #f9bc60; color: #001e1d; border-radius: 4px; text-decoration: none;">
           Nueva Solicitud
        </a>
    </form>

    <!-- Tabla de Solicitudes -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background: #004643; color: #fff;">
                <th style="padding: 10px;">Paciente</th>
                <th style="padding: 10px;">DNI</th>
                <th style="padding: 10px;">Tipo de Sangre</th>
                <th style="padding: 10px;">Cantidad</th>
                <th style="padding: 10px;">Urgencia</th>
                <th style="padding: 10px;">Estado</th>
                <th style="padding: 10px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solicitudes as $solicitud)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">
                        {{ $solicitud->paciente ? $solicitud->paciente->primer_nombre . ' ' . $solicitud->paciente->primer_apellido : 'No registrado' }}
                    </td>
                    <td style="padding: 10px;">{{ $solicitud->paciente ? $solicitud->paciente->dni : 'N/A' }}</td>
                    <td style="padding: 10px;">{{ $solicitud->tipo_sangre }}</td>
                    <td style="padding: 10px;">{{ $solicitud->cantidad }}</td>
                    <td style="padding: 10px;">{{ ucfirst(strtolower($solicitud->urgencia)) }}</td>
                    <td style="padding: 10px;">{{ ucfirst(strtolower($solicitud->estado)) }}</td>
                    <td style="padding: 10px;">
                        <a href="{{ route('sangre.solicitudes.edit', $solicitud->id_solicitud) }}"
                           style="background: #1d72b8; color: #fff; padding: 5px 10px; border-radius: 4px; text-decoration: none;">
                           Editar
                        </a>
                        <form action="{{ route('sangre.solicitudes.destroy', $solicitud->id_solicitud) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background: #e63946; color: #fff; padding: 5px 10px; border: none; border-radius: 4px;">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No se encontraron solicitudes registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div style="text-align: center;">
        {{ $solicitudes->links() }}
    </div>
</div>
@endsection
