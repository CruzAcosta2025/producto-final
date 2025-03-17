@extends('layouts.admin-centro')

@section('title', 'Gestión de Reportes')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Encabezado -->
        <div style="background: linear-gradient(to right, #3b82f6, #1d4ed8); padding: 20px;">
            <h2 style="color: #ffffff; margin: 0; text-align: center; font-size: 1.5rem;">Gestión de Reportes</h2>
        </div>

        <!-- Listado de Tipos de Reportes -->
        <div style="padding: 20px;">
            <h3 style="margin-bottom: 20px;">Seleccione un tipo de reporte para generar:</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                @foreach($tiposReportes as $tipo => $descripcion)
                    <div style="flex: 1; min-width: 300px; padding: 15px; background-color: #f9fafb; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <h4 style="margin-bottom: 10px; font-size: 1.2rem;">{{ $tipo }}</h4>
                        <p style="margin-bottom: 15px; color: #6b7280;">{{ $descripcion }}</p>
                        <a href="{{ route('reportes.create', $tipo) }}"
                           style="background-color: #3b82f6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
                            Generar Reporte
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
