<?php

namespace App\Http\Controllers\CentroMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Support\Facades\Auth;

class RolPermisoController extends Controller
{
    public function edit($id)
    {
        $rol = Rol::where('id_rol', $id)
                  ->where('id_centro', Auth::user()->id_centro)
                  ->firstOrFail();

        // Agrupar permisos por módulo
        $permisos = Permiso::where('id_centro', Auth::user()->id_centro)
            ->get()
            ->groupBy('nombre_modulo');

        return view('admin.centro.roles-permisos.edit', compact('rol', 'permisos'));
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::where('id_rol', $id)
                  ->where('id_centro', Auth::user()->id_centro)
                  ->firstOrFail();

        $request->validate([
            'permisos' => 'array',
            'permisos.*' => 'exists:permisos,id_permiso',
        ]);

        $rol->permisos()->sync($request->permisos);

        return redirect()->route('roles.index')->with('success', 'Permisos asignados exitosamente.');
    }
}
