@extends('layouts.admin-centro')
@section('title', 'Servicios')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Listado de Servicios</h2>
        <a href="{{ route('servicios.create') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-orange-700 transition">
            + Crear Servicio
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Tabla de Servicios -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-orange-100 border border-orange-600 rounded-lg shadow-md">
            <thead class="bg-orange-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left border border-orange-700">Nombre</th>
                    <th class="px-6 py-3 text-left border border-orange-700">Categoría</th>
                    <th class="px-6 py-3 text-left border border-orange-700">Precio</th>
                    <th class="px-6 py-3 text-left border border-orange-700">Estado</th>
                    <th class="px-6 py-3 text-center border border-orange-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                <tr class="border border-orange-500 hover:bg-orange-200 transition">
                    <td class="px-6 py-4 border border-orange-500">{{ $servicio->nombre_servicio }}</td>
                    <td class="px-6 py-4 border border-orange-500">{{ $servicio->categoria_servicio }}</td>
                    <td class="px-6 py-4 border border-orange-500">S/ {{ number_format($servicio->precio, 2) }}</td>
                    <td class="px-6 py-4 border border-orange-500">{{ ucfirst($servicio->estado) }}</td>
                    <td class="px-6 py-4 flex flex-wrap justify-center gap-2">
                        <a href="{{ route('servicios.edit', $servicio->id_servicio) }}" class="bg-blue-700 text-white px-3 py-2 rounded-md hover:bg-blue-800 transition">
                            Editar
                        </a>
                        <form action="{{ route('servicios.destroy', $servicio->id_servicio) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este servicio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 transition" disabled>
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-600">No hay servicios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4 text-center">
        {{ $servicios->links() }}
    </div>
</div>
@endsection