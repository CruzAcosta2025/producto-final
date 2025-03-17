<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Usuario')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        .header {
            background: {{ $color_tema ?? '#004643' }};
            padding: 1rem 1.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-logo img {
            height: 150px;
            width: 150px;
            border-radius: 4px;
        }

        .header-user {
            text-align: right;
        }

        .header-user p {
            margin: 0;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .header-user span {
            font-size: 0.85rem;
            font-weight: normal;
        }

        .nav-list {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            padding: 1rem 0;
        }

        .nav-list a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background: {{ $color_tema ?? '#004643' }};
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .nav-list a:hover {
            background: {{ $hover_color ?? '#006d62' }};
            border-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .main-content {
            padding: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .nav-list {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-logo">
            @if ($logo_centro)
                <img src="{{ asset($logo_centro) }}" alt="Logo Centro Médico">
            @endif
            <span>{{ $nombre_centro ?? 'Centro Médico' }}</span>
        </div>

        <div class="header-user">
            <p>{{ Auth::user()->name }}</p>
            <span>{{ Auth::user()->rol->nombre_rol }}</span>
        </div>
    </header>

    <nav>
        <ul class="nav-list">
            @foreach ($menus as $menu)
                <li>
                    <a href="{{ route($menu['ruta']) }}">{{ $menu['nombre'] }}</a>
                </li>
            @endforeach
            <!-- Botón de Cerrar Sesión -->
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                </a>
            </li>
        </ul>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>
</body>

</html>
