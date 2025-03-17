<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador Global</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <header class="bg-blue-900 text-white p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between">
            <h1 class="text-2xl font-bold mb-2 sm:mb-0">Panel Administrador Global</h1>
            <nav>
                <ul class="flex flex-col sm:flex-row gap-2 sm:gap-4 list-none">
                    <li><a href="{{ route('admin.global.dashboard') }}" class="px-3 py-1 hover:bg-blue-700 rounded">Dashboard</a></li>
                    <li><a href="{{ route('centros.index') }}" class="px-3 py-1 hover:bg-blue-700 rounded">Gestión de Centros</a></li>
                    <li><a href="{{ route('usuarios.index') }}" class="px-3 py-1 hover:bg-blue-700 rounded">Usuarios</a></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-3 py-1 hover:bg-blue-700 rounded">Cerrar sesión</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido -->
    <main class="max-w-7xl mx-auto mt-8 space-y-8">
        <!-- Tarjetas de estadísticas -->
        <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['title' => 'Centros Médicos', 'value' => $totalCentrosMedicos, 'bg' => 'bg-blue-100', 'border' => 'border-blue-500', 'text' => 'text-blue-700'],
                ['title' => 'Total Pacientes', 'value' => $totalPacientes, 'bg' => 'bg-green-100', 'border' => 'border-green-500', 'text' => 'text-green-700'],
                ['title' => 'Personal Médico', 'value' => $totalPersonalMedico, 'bg' => 'bg-purple-100', 'border' => 'border-purple-500', 'text' => 'text-purple-700'],
                ['title' => 'Total Consultas', 'value' => $totalConsultas, 'bg' => 'bg-red-100', 'border' => 'border-red-500', 'text' => 'text-red-700']
            ] as $stat)
                <div class="p-6 rounded-lg shadow-lg border-2 {{ $stat['border'] }} {{ $stat['bg'] }}">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $stat['title'] }}</h2>
                    <p class="text-4xl font-bold {{ $stat['text'] }}">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </section>

        <!-- Sección de gráficos -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
                <h3 class="text-lg font-semibold mb-4">Distribución de Pacientes</h3>
                <div class="w-full h-64">
                    <canvas id="pacientesChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
                <h3 class="text-lg font-semibold mb-4">Consultas vs Cirugías</h3>
                <div class="w-full h-64">
                    <canvas id="consultasChart"></canvas>
                </div>
            </div>
        </section>
    </main>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Chart(document.getElementById('pacientesChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($nombresCentros ?? []),
                    datasets: [{
                        label: 'Pacientes',
                        data: @json($cantidadPacientes ?? []),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        barThickness: 50,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(5, Math.max(...(@json($cantidadPacientes ?? []))) + 2),
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('consultasChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Consultas', 'Cirugías'],
                    datasets: [{
                        data: [{{ $totalConsultas }}, {{ $totalCirugias }}],
                        backgroundColor: ['#4CAF50', '#FF6384'],
                        borderColor: ['#388E3C', '#D32F2F'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
</body>
</html>
