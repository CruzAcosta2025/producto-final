<?php

namespace App\Http\Controllers\CentroMedico\Especialidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Auth;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::where('id_centro', Auth::user()->id_centro)->get();
        return view('admin.centro.especialidad.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.centro.especialidad.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_especialidad' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = Especialidad::where('nombre_especialidad', $value)
                        ->where('id_centro', Auth::user()->id_centro)
                        ->exists();

                    if ($exists) {
                        $fail('La especialidad ya existe en este centro médico.');
                    }
                },
            ],
            'descripcion' => 'nullable|string'
        ]);

        Especialidad::create([
            'nombre_especialidad' => $request->nombre_especialidad,
            'descripcion' => $request->descripcion,
            'id_centro' => Auth::user()->id_centro,
        ]);

        return redirect()->route('especialidad.index')->with('success', 'Especialidad creada exitosamente.');
    }

    public function edit($id)
    {
        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        return view('admin.centro.especialidad.edit', compact('especialidad'));
    }

    public function update(Request $request, $id)
    {
        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        $request->validate([
            'nombre_especialidad' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($especialidad) {
                    $exists = Especialidad::where('nombre_especialidad', $value)
                        ->where('id_centro', Auth::user()->id_centro)
                        ->where('id_especialidad', '!=', $especialidad->id_especialidad)
                        ->exists();

                    if ($exists) {
                        $fail('La especialidad ya existe en este centro médico.');
                    }
                },
            ],
            'descripcion' => 'nullable|string',
        ]);

        $especialidad->update([
            'nombre_especialidad' => $request->nombre_especialidad,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('especialidad.index')->with('success', 'Especialidad actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $especialidad = Especialidad::where('id_especialidad', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        $especialidad->delete();

        return redirect()->route('especialidad.index')->with('success', 'Especialidad eliminada exitosamente.');
    }
}
