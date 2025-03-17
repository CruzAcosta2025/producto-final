{{-- resources/views/admin/centro/dashboard.blade.php --}}
@extends('layouts.admin-centro')

@section('title', 'Panel de Control del Centro Médico')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-6 rounded-xl shadow-lg max-w-4xl w-full mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">👨‍⚕️ Bienvenido, a {{ $centro->nombre }}</h2>
        <p class="text-gray-700">Administra el personal, usuarios, roles y permisos de tu centro de manera eficiente.</p>

        <!-- Sección de Acciones Rápidas -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4">
            <a href="{{ route('usuarios-centro.index') }}" class="bg-blue-600 text-white px-4 py-3 rounded-lg shadow-md text-center hover:bg-blue-700 transition">
                Gestión de Usuarios
            </a>
            <a href="{{ route('roles.index') }}" class="bg-green-600 text-white px-4 py-3 rounded-lg shadow-md text-center hover:bg-green-700 transition">
                Gestión de Roles
            </a>
            <a href="{{ route('permisos.index') }}" class="bg-purple-600 text-white px-4 py-3 rounded-lg shadow-md text-center hover:bg-purple-700 transition">
                Gestión de Permisos
            </a>
        </div>
    </div>
</div>
@endsection
