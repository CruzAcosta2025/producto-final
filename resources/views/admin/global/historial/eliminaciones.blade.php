@extends('layouts.app')

@section('title', 'Historial de Eliminaciones')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Historial de Eliminaciones</h1>

    <div class="mb-4">
        <a href="{{ route('historial.exportExcel') }}" class="bg-green-500 text-white px-4 py-2 rounded">Exportar a Excel</a>
    </div>


    {{-- Tabla de eliminaciones --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Usuario</th>
                    <th class="border border-gray-300 px-4 py-2">Centro Médico</th>
                    <th class="border border-gray-300 px-4 py-2">Tipo de Recurso</th>
                    <th class="border border-gray-300 px-4 py-2">Recurso Eliminado</th>
                    <th class="border border-gray-300 px-4 py-2">Detalles</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach($eliminaciones as $eliminacion)
                <tr class="bg-white hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $eliminacion->usuario ? $eliminacion->usuario->nombre : 'N/A' }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $eliminacion->centroMedico ? $eliminacion->centroMedico->nombre : 'N/A' }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $eliminacion->recurso_tipo }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $eliminacion->recurso_nombre }}
                    </td>

                    <td class="border border-gray-300 px-4 py-2">
                        {{ $eliminacion->recurso_tipo }}
                        <br>
                        <small class="text-gray-600">{{ $eliminacion->detalles }}</small>
                    </td>

                    <td class="border border-gray-300 px-4 py-2">
                        {{ $eliminacion->fecha_eliminacion ? $eliminacion->fecha_eliminacion->format('d/m/Y H:i') : 'Sin fecha' }}
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $eliminaciones->links() }}
    </div>
</div>

@endsection