<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CentroMedico;

class CentroMedicoController extends Controller
{
    // Mostrar todos los centros médicos
    public function index()
    {
        $centros = CentroMedico::all();
        return view('admin.global.centros.index', compact('centros'));
    }

    // Mostrar formulario para crear un nuevo centro médico
    public function create()
    {
        return view('admin.global.centros.create');
    }

    // Guardar un nuevo centro médico
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:191',
            'direccion' => 'required|string|max:255',
            'ruc' => 'required|string|max:20|unique:centros_medicos,ruc',
            'color_tema' => 'required|string|max:7',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        DB::transaction(function () use ($request) {
            CentroMedico::create($request->all());
        });

        return redirect()->route('centros.index')
            ->with('success', 'Centro médico creado exitosamente. El administrador del centro puede definir los roles y permisos necesarios.');
    }

    // Mostrar formulario para editar un centro médico
    public function edit($id)
    {
        $centro = CentroMedico::findOrFail($id);
        return view('admin.global.centros.edit', compact('centro'));
    }

    // Actualizar los datos de un centro médico
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:191',
            'direccion' => 'required|string|max:255',
            'ruc' => 'required|string|max:20|unique:centros_medicos,ruc,' . $id . ',id_centro',
            'color_tema' => 'required|string|max:7',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $centro = CentroMedico::findOrFail($id);
        $centro->update($request->all());

        return redirect()->route('centros.index')->with('success', 'Centro médico actualizado exitosamente.');
    }

    // Deshabilitar un centro médico
    public function disable($id)
    {
        $centro = CentroMedico::findOrFail($id);

        DB::transaction(function () use ($centro) {
            $centro->update(['estado' => 'INACTIVO']);
            foreach ($centro->usuarios as $usuario) {
                $usuario->update(['estado' => 'INACTIVO']);
            }
        });

        return redirect()->route('centros.index')->with('success', 'Centro médico deshabilitado exitosamente.');
    }

    // Habilitar un centro médico
    public function enable($id)
    {
        $centro = CentroMedico::findOrFail($id);

        DB::transaction(function () use ($centro) {
            $centro->update(['estado' => 'ACTIVO']);
            foreach ($centro->usuarios as $usuario) {
                $usuario->update(['estado' => 'ACTIVO']);
            }
        });

        return redirect()->route('centros.index')->with('success', 'Centro médico habilitado exitosamente.');
    }

    // Eliminar un centro médico
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'confirmacion' => 'required|boolean',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt(['email' => auth()->user()->email, 'password' => $request->password])) {
            return redirect()->back()->withErrors(['password' => 'La contraseña proporcionada es incorrecta.']);
        }

        if (!$request->confirmacion) {
            return redirect()->back()->withErrors(['confirmacion' => 'La confirmación es requerida para eliminar el centro médico.']);
        }

        $centro = CentroMedico::findOrFail($id);

        DB::transaction(function () use ($centro) {
            $centro->usuarios()->delete();
            $centro->delete();
        });

        return redirect()->route('centros.index')->with('success', 'Centro médico eliminado exitosamente.');
    }
}
