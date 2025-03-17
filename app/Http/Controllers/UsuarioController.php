<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\CentroMedico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol', 'centroMedico')->get();
        return view('admin.global.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $usuarioActual = Auth::user();

        if (!$usuarioActual || !$usuarioActual->rol) {
            abort(403, 'No tienes un rol asignado o no estás autenticado.');
        }

        if ($usuarioActual->rol->nombre_rol === 'Administrador Global') {
            // ✅ Mostrar los tres roles
            $roles = Rol::whereIn('nombre_rol', ['Administrador Global', 'Administrador Centro Médico'])->get();
            // ✅ Mostrar todos los centros médicos
            $centros = CentroMedico::all();
        } elseif ($usuarioActual->rol->nombre_rol === 'Administrador Centro Médico') {
            // ✅ Filtrar roles correctamente
            $roles = Rol::all();
            // ✅ Mantener solo su centro médico
            $centros = CentroMedico::all();
        } else {
            abort(403, 'No tienes permiso para crear usuarios.');
        }

        return view('admin.global.usuarios.create', compact('roles', 'centros'));
    }


    public function store(Request $request)
    {
        $usuarioActual = Auth::user();

        if (!$usuarioActual || !$usuarioActual->rol) {
            abort(403, 'No tienes un rol asignado o no estás autenticado.');
        }

        $this->validateUser($request);

        $rolPermitido = $this->checkRolPermitido($usuarioActual, $request->id_rol);

        if (!$rolPermitido) {
            return redirect()->back()->withErrors(['id_rol' => 'No tienes permiso para asignar este rol.'])->withInput();
        }

        $userData = $request->only(['nombre', 'email', 'id_rol', 'id_centro']);
        $userData['password'] = bcrypt($request->password);

        if ($usuarioActual->rol->nombre_rol === 'Administrador Centro Médico') {
            $userData['id_centro'] = $usuarioActual->id_centro;
        }

        Usuario::create($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuarioActual = Auth::user();

        if (!$usuarioActual || !$usuarioActual->rol) {
            abort(403, 'No tienes un rol asignado o no estás autenticado.');
        }

        if ($usuarioActual->rol->nombre_rol === 'Administrador Global') {
            $roles = Rol::whereIn('nombre_rol', ['Administrador Global', 'Administrador Centro Médico'])->get();
            $centros = CentroMedico::all();
        } elseif ($usuarioActual->rol->nombre_rol === 'Administrador Centro Médico') {
            if ($usuario->id_centro !== $usuarioActual->id_centro) {
                abort(403, 'No tienes permiso para editar este usuario.');
            }
            $roles = Rol::all();
            $centros = CentroMedico::all();
        } else {
            abort(403, 'No tienes permiso para editar usuarios.');
        }

        return view('admin.global.usuarios.edit', compact('usuario', 'roles', 'centros'));
    }

    public function update(Request $request, $id)
    {
        $usuarioActual = Auth::user();
        $usuario = Usuario::findOrFail($id);

        if (!$usuarioActual || !$usuarioActual->rol) {
            abort(403, 'No tienes un rol asignado o no estás autenticado.');
        }

        $this->validateUser($request, $id);

        $rolPermitido = $this->checkRolPermitido($usuarioActual, $request->id_rol);

        if (!$rolPermitido) {
            return redirect()->back()->withErrors(['id_rol' => 'No tienes permiso para asignar este rol.'])->withInput();
        }

        $userData = $request->only(['nombre', 'email', 'id_rol', 'id_centro']);

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        if ($usuarioActual->rol->nombre_rol === 'Administrador Centro Médico') {
            $userData['id_centro'] = $usuarioActual->id_centro;
        }

        $usuario->update($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuarioActual = Auth::user();

        if ($usuario->rol->nombre_rol === 'Administrador Global') {
            return redirect()->route('usuarios.index')->withErrors(['error' => 'No se puede eliminar al Administrador Global.']);
        }

        if ($usuarioActual->rol->nombre_rol === 'Administrador Centro Médico' && $usuario->id_centro !== $usuarioActual->id_centro) {
            abort(403, 'No tienes permiso para eliminar este usuario.');
        }

        // Eliminar primero los horarios de cada personal médico asociado a este usuario
        foreach ($usuario->personalMedico as $personal) {
            $personal->horariosMedicos()->delete(); // ⬅️ Primero eliminamos los horarios
            $personal->consultas()->delete(); // ⬅️ Luego eliminamos las consultas
        }

        // Ahora podemos eliminar los registros de personal médico sin restricciones
        $usuario->personalMedico()->delete();

        // Finalmente, eliminamos el usuario
        $usuario->delete();


        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    private function validateUser(Request $request, $userId = null)
    {
        $rules = [
            'nombre' => 'required|string|max:50',
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($userId, 'id_usuario')],
            'id_rol' => 'required|exists:roles,id_rol',
            'id_centro' => 'nullable|exists:centros_medicos,id_centro',
        ];

        if ($userId === null || $request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);
    }

    private function checkRolPermitido($usuarioActual, $rolId)
    {
        if ($usuarioActual->rol->nombre_rol === 'Administrador Global') {
            return Rol::whereIn('nombre_rol', ['Administrador Global', 'Administrador Centro Médico'])
                ->where('id_rol', $rolId)
                ->exists();
        } elseif ($usuarioActual->rol->nombre_rol === 'Administrador Centro Médico') {
            return Rol::whereNotIn('nombre_rol', ['Administrador Global', 'Administrador Centro Médico'])
                ->where('id_rol', $rolId)
                ->exists();
        }
        return false;
    }
}
