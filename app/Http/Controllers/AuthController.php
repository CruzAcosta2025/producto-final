<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Si el usuario ya está autenticado, redirigir al dashboard correspondiente
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Maneja el proceso de autenticación
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Clave única de bloqueo basada en IP
        $lockoutKey = 'login_lockout_' . $request->ip();

        // Validar intentos de login
        if ($this->hasTooManyLoginAttempts($request, $lockoutKey)) {
            return $this->sendLockoutResponse($request, $lockoutKey);
        }

        // Preparar credenciales de inicio de sesión
        $credentials = $request->only('email', 'password');

        //dd($credentials, Auth::attempt($credentials));


        // Intento de autenticación con opción de "recordar sesión"
        if (Auth::attempt($credentials, $request->boolean('remember-me'))) {
            // Regenerar ID de sesión para prevenir fijación de sesión
            $request->session()->regenerate();

            // Registrar inicio de sesión exitoso
            Log::info('Inicio de sesión exitoso', [
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            // Limpiar intentos de login fallidos
            $this->clearLoginAttempts($request, $lockoutKey);

            $user = Auth::user();

            // Redirigir según el rol del usuario
            return $this->redirectBasedOnRole($user);
        }

        // Incrementar intentos de login fallidos
        $this->incrementLoginAttempts($request, $lockoutKey);

        // Registro de intento fallido
        Log::warning('Intento de inicio de sesión fallido', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        // Regresar con mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->withInput($request->only('email'));
    }

    /**
     * Redirige al usuario según su rol
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->rol->nombre_rol) {
            case 'Administrador Global':
                return redirect()->route('admin.global.dashboard');
            case 'Administrador Centro Médico':
                return redirect()->route('admin.centro.dashboard')->with('centro', $user->centro);
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Cierra la sesión del usuario
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Registrar cierre de sesión
        Log::info('Cierre de sesión', [
            'email' => Auth::user()->email,
            'ip' => $request->ip()
        ]);

        // Cerrar sesión
        Auth::logout();

        // Invalidar sesión actual
        $request->session()->invalidate();

        // Regenerar token CSRF
        $request->session()->regenerateToken();

        // Redirigir a login
        return redirect()->route('login');
    }

    /**
     * Verifica si se han excedido los intentos de login
     *
     * @param Request $request
     * @param string $lockoutKey
     * @return bool
     */
    private function hasTooManyLoginAttempts(Request $request, $lockoutKey)
    {
        // Obtener intentos actuales
        $attempts = Session::get($lockoutKey . '_attempts', 0);

        // Máximo 3 intentos
        return $attempts >= 3 &&
            Session::has($lockoutKey) &&
            now()->diffInMinutes(Session::get($lockoutKey)) < 1;
    }

    /**
     * Envía respuesta de bloqueo
     *
     * @param Request $request
     * @param string $lockoutKey
     * @return \Illuminate\Http\RedirectResponse
     */
    private function sendLockoutResponse(Request $request, $lockoutKey)
    {
        $lockoutTime = Session::get($lockoutKey);
        $remainingTime = 1 - now()->diffInMinutes($lockoutTime);

        return back()->withErrors([
            'email' => "Demasiados intentos. Por favor, espere {$remainingTime} minuto(s)."
        ]);
    }

    /**
     * Incrementa los intentos de login
     *
     * @param Request $request
     * @param string $lockoutKey
     */
    private function incrementLoginAttempts(Request $request, $lockoutKey)
    {
        $attempts = Session::get($lockoutKey . '_attempts', 0) + 1;

        // Almacenar intentos
        Session::put($lockoutKey . '_attempts', $attempts);

        // Si supera 3 intentos, bloquear
        if ($attempts >= 3) {
            Session::put($lockoutKey, now());
        }
    }

    /**
     * Limpia los intentos de login
     *
     * @param Request $request
     * @param string $lockoutKey
     */
    private function clearLoginAttempts(Request $request, $lockoutKey)
    {
        Session::forget($lockoutKey);
        Session::forget($lockoutKey . '_attempts');
    }
}
