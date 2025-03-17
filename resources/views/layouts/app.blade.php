<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-900 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-xl font-bold">SaniTrix</a>
            <div>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('admin.global.dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
                    <li><a href="{{ route('centros.index') }}" class="hover:text-gray-300">Centros Médicos</a></li>
                    <li><a href="{{ route('usuarios.index') }}" class="hover:text-gray-300">Usuarios</a></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-gray-300">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif
    @yield('scripts') <!-- Esto permite inyectar scripts en otras vistas -->

</body>

</html>