@extends('layouts.admin-centro')

@section('title', 'Gestión de Donadores de Sangre')

@section('content')
<div style="max-width: 1200px; margin: auto; padding: 20px;">
    <h2 style="text-align: center; margin-bottom: 20px; color: #004643;">Donadores de Sangre</h2>

    <!-- Buscador -->
    <form action="{{ route('sangre.donadores.index') }}" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="dni" value="{{ request('dni') }}" placeholder="Buscar por DNI"
            style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 200px;">
        <select name="tipo_sangre" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">Todos</option>
            <option value="A+" {{ request('tipo_sangre') == 'A+' ? 'selected' : '' }}>A+</option>
            <option value="A-" {{ request('tipo_sangre') == 'A-' ? 'selected' : '' }}>A-</option>
            <option value="B+" {{ request('tipo_sangre') == 'B+' ? 'selected' : '' }}>B+</option>
            <option value="B-" {{ request('tipo_sangre') == 'B-' ? 'selected' : '' }}>B-</option>
            <option value="O+" {{ request('tipo_sangre') == 'O+' ? 'selected' : '' }}>O+</option>
            <option value="O-" {{ request('tipo_sangre') == 'O-' ? 'selected' : '' }}>O-</option>
            <option value="AB+" {{ request('tipo_sangre') == 'AB+' ? 'selected' : '' }}>AB+</option>
            <option value="AB-" {{ request('tipo_sangre') == 'AB-' ? 'selected' : '' }}>AB-</option>
        </select>
        <button type="submit" style="padding: 10px; border: none; background: #004643; color: #fff; border-radius: 4px;">Buscar</button>
        <a href="{{ route('sangre.solicitudes.index') }}" style="padding: 10px; background: #f9bc60; color: #001e1d; border-radius: 4px; text-decoration: none;">Ir a Solicitudes</a>
    </form>

    @if ($mensaje)
    <div style="text-align: center; margin-bottom: 20px;">
        <p style="color: red;">{{ $mensaje }}</p>
        <a href="{{ route('sangre.donadores.create') }}"
            style="padding: 10px; background: #1d72b8; color: #fff; border-radius: 4px; text-decoration: none;">Registrar Manualmente</a>
    </div>
    @elseif ($paciente)
    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 20px;">
        <h3 style="color: #004643;">Paciente Encontrado</h3>
        <p><strong>Nombre:</strong> {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</p>
        <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
        <p><strong>Grupo Sanguíneo:</strong> {{ $paciente->grupo_sanguineo }}</p>
        <a href="{{ route('sangre.donadores.registrarPaciente', $paciente->id_paciente) }}"
            style="padding: 10px; background: #1d72b8; color: #fff; border-radius: 4px; text-decoration: none;">Registrar como Donador</a>
    </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background: #004643; color: #fff;">
                <th style="padding: 10px;">Nombre</th>
                <th style="padding: 10px;">DNI</th>
                <th style="padding: 10px;">Tipo de Sangre</th>
                <th style="padding: 10px;">Teléfono</th>
                <th style="padding: 10px;">Estado</th>
                <th style="padding: 10px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donadores as $donador)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">{{ $donador->nombre }} {{ $donador->apellido }}</td>
                <td style="padding: 10px;">{{ $donador->dni }}</td>
                <td style="padding: 10px;">{{ $donador->tipo_sangre }}</td>
                <td style="padding: 10px;">{{ $donador->telefono }}</td>
                <td style="padding: 10px;">{{ ucfirst(strtolower(str_replace('_', ' ', $donador->estado))) }}</td>
                <td style="padding: 10px;">
                    <a href="{{ route('sangre.donadores.edit', $donador->id_donador) }}"
                        style="background: #1d72b8; color: #fff; padding: 5px 10px; border-radius: 4px; text-decoration: none;">Editar</a>
                    <form action="{{ route('sangre.donadores.destroy', $donador->id_donador) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #e63946; color: #fff; padding: 5px 10px; border: none; border-radius: 4px;">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">No se encontraron donadores registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="text-align: center;">
        @if ($donadores instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $donadores->links() }}
        @endif
    </div>

</div>
@endsection