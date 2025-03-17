<!-- Forgot Password Page -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediSys - Recuperar Contraseña</title>
    <style>
        /* Los mismos estilos que la página de login */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #115e59 0%, #0d9488 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 28rem;
        }

        .logo {
            display: block;
            height: 6rem;
            width: auto;
            margin: 0 auto;
            object-fit: contain;
        }

        .title {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 1.875rem;
            font-weight: 800;
            color: #111827;
        }

        .subtitle {
            text-align: center;
            font-size: 0.875rem;
            color: #6B7280;
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .input:focus {
            outline: none;
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }

        .btn {
            width: 100%;
            padding: 0.5rem 1rem;
            background: #0d9488;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background: #115e59;
        }

        .link {
            color: #0d9488;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .link:hover {
            color: #115e59;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: #FEE2E2;
            border: 1px solid #F87171;
            color: #991B1B;
        }

        .alert-success {
            background: #DCFCE7;
            border: 1px solid #86EFAC;
            color: #166534;
        }

        .alert ul {
            margin-left: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="logo" src="{{ asset('images/logo-medisys.png') }}" alt="MediSys Logo">
        <h2 class="title">Recuperar Contraseña</h2>
        <p class="subtitle">Te enviaremos un enlace para restablecer tu contraseña</p>

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="label" for="email">Correo Electrónico</label>
                <input id="email" name="email" type="email" required
                       class="input" placeholder="correo@ejemplo.com">
            </div>

            <button disabled="true" type="submit" class="btn">
                ✉️ Enviar Enlace de Recuperación
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="link">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>
</body>
</html>
