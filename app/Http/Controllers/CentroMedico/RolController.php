<?php

namespace App\Http\Controllers\CentroMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    public function index()
    {
        $idCentro = Auth::user()->id_centro;
        $roles = Rol::where('id_centro', $idCentro)->get();
        return view('admin.centro.roles.index', compact('roles'));
    }
    public function create()
    {
        // Roles permitidos para el administrador del centro médico
        $rolesPermitidos = [
            'Médico/a',
            'Técnico',
            'Enfermero/a',
            'Personal Administrativo',
        ];

        return view('admin.centro.roles.create', compact('rolesPermitidos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|string|in:Médico/a,Técnico,Enfermero/a,Personal Administrativo',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Rol::create([
            'nombre_rol' => $request->nombre_rol,
            'descripcion' => $request->descripcion,
            'id_centro' => auth()->user()->id_centro,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }


    /*public function create()
    {
        return view('admin.centro.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $idCentro = Auth::user()->id_centro;

        // Verifica que el usuario autenticado tenga un id_centro válido
        if (!$idCentro) {
            return redirect()->back()->withErrors(['error' => 'No se pudo determinar el centro médico del usuario.']);
        }

        Rol::create([
            'nombre_rol' => $request->nombre_rol,
            'descripcion' => $request->descripcion,
            'id_centro' => $idCentro, // Asignación directa del id_centro del usuario autenticado
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit($id)
    {
        $rol = Rol::where('id_rol', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        return view('admin.centro.roles.edit', compact('rol'));
    }
        */

    public function edit($id)
    {
        $rol = Rol::findOrFail($id); // Encuentra el rol o lanza un error 404
        $rolesPermitidos = ['Administrador Centro Médico', 'Médico/a', 'Técnico', 'Enfermero/a', 'Personal Administrativo']; // Lista de roles válidos

        return view('admin.centro.roles.edit', compact('rol', 'rolesPermitidos'));
    }


    public function update(Request $request, $id)
    {
        $rol = Rol::where('id_rol', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        $request->validate([
            'nombre_rol' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $rol->update([
            'nombre_rol' => $request->nombre_rol,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }



    public function destroy($id)
    {
        $rol = Rol::where('id_rol', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
