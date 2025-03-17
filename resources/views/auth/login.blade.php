<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SANITRIX</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-blue-900 p-4">
    <div class="bg-gray-700 p-8 rounded-xl shadow-xl w-full max-w-md">
        <img class="h-24 mx-auto object-contain" src="{{ asset('images/logo1.png') }}" alt="MediSys Logo">
        <h2 class="mt-4 text-center text-2xl font-bold text-white">SaniTrix</h2>

        @if ($errors->any())
        <div class="mt-4 p-3 rounded-lg bg-red-100 border border-red-400 text-red-700">
            <ul class="ml-4 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">Correo</label>
                <input id="email" name="email" type="email" required
                       class="w-full mt-1 p-2 border border-gray-500 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-600 text-white placeholder-gray-300"
                       placeholder="correo@gmail.com">
            </div>

            <div class="mb-4 relative">
                <label for="password" class="block text-sm font-medium text-white">Contraseña</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required
                           class="w-full mt-1 p-2 border border-gray-500 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-600 text-white placeholder-gray-300"
                           placeholder="••••••••">
                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300"
                            onclick="togglePassword()">👁️</button>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md flex items-center justify-center gap-2">
                🔐 Iniciar Sesión
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
