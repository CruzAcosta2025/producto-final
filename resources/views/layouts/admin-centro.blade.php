<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>@yield('title', 'Panel Administrador - Centro Médico')</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-[#003366] text-white w-64 min-h-screen p-5 shadow-lg hidden md:block">
        <div class="text-center mb-6">
            @if (Auth::user()->centroMedico->logo)
            <img src="{{ asset('storage/' . Auth::user()->centroMedico->logo) }}" alt="Logo Centro Médico"
                class="h-20 w-auto mx-auto rounded-md">
            @endif
            <h1 class="text-lg font-bold mt-3">{{ Auth::user()->centroMedico->nombre ?? 'Centro Médico' }}</h1>
        </div>
        <nav>
            <ul class="space-y-3">
                <li>
                    <button class="w-full bg-blue-800 text-left px-4 py-2 rounded-md hover:bg-blue-900 transition" onclick="toggleDropdown('gestion')">Gestión</button>
                    <ul id="gestion" class="hidden space-y-2 mt-2 pl-4">
                        <li><a href="{{ route('roles.index') }}" class="block px-4 py-2 bg-blue-700 rounded-md hover:bg-blue-800 transition">Gestión de Roles</a></li> 
                        <!-- <li><a href="{{ route('permisos.index') }}" class="block px-4 py-2 bg-blue-700 rounded-md hover:bg-blue-800 transition">Gestión de Permisos</a></li> -->
                        <li><a href="{{ route('usuarios-centro.index') }}" class="block px-4 py-2 bg-blue-700 rounded-md hover:bg-blue-800 transition">Gestión de Usuarios</a></li>
                        <li><a href="{{ route('configurar.centro') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Edición</a></li>
                        <li><a href="{{ route('caja.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Facturación</a></li>

                    </ul>
                </li>
                <li>
                    <button class="w-full bg-blue-800 text-left px-4 py-2 rounded-md hover:bg-blue-900 transition" onclick="toggleDropdown('medicos')">Personal Médico</button>
                    <ul id="medicos" class="hidden space-y-2 mt-2 pl-4">
                        <li><a href="{{ route('personal-medico.index') }}" class="block px-4 py-2 bg-blue-700 rounded-md hover:bg-blue-800 transition">Personal Médico</a></li>
                        <li><a href="{{ route('especialidad.index') }}" class="block px-4 py-2 bg-blue-700 rounded-md hover:bg-blue-800 transition">Especialidades</a></li>
                        <li><a href="{{ route('horarios.index') }}" class="block px-4 py-2 bg-blue-700 rounded-md hover:bg-blue-800 transition">Horarios</a></li>
                        <li><a href="{{ route('servicios.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Servicios</a></li>
                        <li><a href="{{ route('turnos.disponibles') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Turnos Disponibles</a></li>
                        <li><a href="{{ route('sangre.donadores.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Donadores de Sangre</a></li>
                        <li><a href="{{ route('sangre.solicitudes.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Solicitudes de Sangre</a></li>

                    </ul>
                </li>
                <li>
                    <button class="w-full bg-blue-800 text-left px-4 py-2 rounded-md hover:bg-blue-900 transition" onclick="toggleDropdown('pacientes')">Pacientes</button>
                    <ul id="pacientes" class="hidden space-y-2 mt-2 pl-4">
                        <li><a href="{{ route('pacientes.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Pacientes</a></li>
                        <li><a href="{{ route('historial.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Historial Clínico</a></li>
                        <li><a href="{{ route('alergias.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Alergias</a></li>
                        <li><a href="{{ route('vacunas.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Vacunas</a></li>
                        <li><a href="{{ route('cirugias.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Cirugías</a></li>
                        <li><a href="{{ route('diagnosticos.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Diagnósticos</a></li>
                        <li><a href="{{ route('recetas.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Recetas y Medicamentos</a></li>
                        <li><a href="{{ route('tratamientos.index') }}" class="block px-4 py-2 bg-blue-800 rounded-md hover:bg-blue-900 transition">Tratamientos</a></li>
                    </ul>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 bg-red-600 rounded-md hover:bg-red-700 transition">Cerrar sesión</a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Panel de Administración</h2>
            <button class="md:hidden bg-blue-600 text-white px-3 py-2 rounded-md" onclick="toggleMenu()">☰ Menú</button>
        </header>

        <main class="p-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleMenu() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
        }

        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>

    <!-- Scripts -->
    <script>
        function toggleMenu() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
        }

        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>

    
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