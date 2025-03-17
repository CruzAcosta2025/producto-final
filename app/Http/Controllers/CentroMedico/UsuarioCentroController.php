<?php

namespace App\Http\Controllers\CentroMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;

class UsuarioCentroController extends Controller
{
    public function index()
    {
        // Obtiene usuarios del centro del administrador autenticado
        $idCentro = Auth::user()->id_centro;
        $usuarios = Usuario::where('id_centro', $idCentro)->get();

        return view('admin.centro.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Obtiene roles disponibles para el centro del administrador autenticado
        $roles = Rol::where('id_centro', Auth::user()->id_centro)->get();

        return view('admin.centro.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|confirmed|min:6',
            'id_rol' => 'required|exists:roles,id_rol',
            'tipo_personal' => 'required|in:medico,no_medico',
        ]);

        // Crea el usuario con la información proporcionada
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_rol' => $request->id_rol,
            'id_centro' => Auth::user()->id_centro,
        ]);

        // Redirige según el tipo de personal
        if ($request->tipo_personal === 'medico') {
            return redirect()->route('personal.create', ['id' => $usuario->id_usuario])
                ->with('success', 'Usuario creado exitosamente. Continúa registrando detalles del personal médico.');
        } else {
            return redirect()->route('trabajadores.create', ['id' => $usuario->id_usuario])
                ->with('success', 'Usuario creado exitosamente. Continúa registrando detalles del personal no médico.');
        }
    }

    public function edit($id)
    {
        // Busca el usuario por ID y verifica que pertenezca al centro del administrador autenticado
        $usuario = Usuario::where('id_usuario', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        // Obtiene los roles disponibles para el centro
        $roles = Rol::where('id_centro', Auth::user()->id_centro)->get();

        return view('admin.centro.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Busca el usuario por ID y verifica que pertenece al centro del administrador autenticado
        $usuario = Usuario::where('id_usuario', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        // Validación de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|string|min:6|confirmed',
            'id_rol' => 'required|exists:roles,id_rol',
        ]);

        // Actualiza los datos del usuario
        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
            'id_rol' => $request->id_rol,
        ]);

        // Redirige usando la acción del controlador
        return redirect()->action([UsuarioCentroController::class, 'index'])
            ->with('success', 'Usuario actualizado exitosamente.');
    }





    public function destroy($id)
    {
        // Busca el usuario por ID y verifica que pertenezca al centro del administrador autenticado
        $usuario = Usuario::where('id_usuario', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        // Elimina al usuario
        $usuario->delete();

        return redirect()->route('usuarios-centro.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
