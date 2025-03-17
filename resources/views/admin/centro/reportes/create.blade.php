@extends('layouts.admin-centro')

@section('title', 'Generar Reporte')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Encabezado -->
        <div style="background: linear-gradient(to right, #3b82f6, #1d4ed8); padding: 20px;">
            <h2 style="color: #ffffff; margin: 0; text-align: center; font-size: 1.5rem;">
                Generar Reporte: {{ $tipo }}
            </h2>
        </div>

        <!-- Formulario -->
        <form action="{{ route('reportes.store', $tipo) }}" method="POST" style="padding: 20px;">
            @csrf
            <!-- Fecha Inicio -->
            <div style="margin-bottom: 15px;">
                <label for="fecha_inicio" style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;">
                @error('fecha_inicio')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fecha Fin -->
            <div style="margin-bottom: 15px;">
                <label for="fecha_fin" style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha de Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" required
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;">
                @error('fecha_fin')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botones -->
            <div style="display: flex; justify-content: space-between; gap: 15px; margin-top: 20px;">
                <button type="submit"
                        style="background-color: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                    Generar Reporte
                </button>
                <a href="{{ route('reportes.index') }}"
                   style="background-color: #6b7280; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; text-align: center;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
