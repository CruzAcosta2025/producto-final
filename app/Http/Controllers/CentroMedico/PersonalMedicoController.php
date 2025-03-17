<?php

namespace App\Http\Controllers\CentroMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalMedico;
use App\Models\Especialidad;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PersonalMedicoController extends Controller
{
    /**
     * Mostrar la lista de personal médico.
     */
    public function index()
    {
        $centro = Auth::user()->centroMedico;

        $personalMedico = PersonalMedico::where('id_centro', $centro->id_centro)
            ->whereNotNull('id_especialidad')
            ->with(['usuario', 'especialidad'])
            ->get();

        return view('admin.centro.personal.index', compact('personalMedico'));
    }

    /**
     * Mostrar la lista de trabajadores no médicos.
     */
    public function indexTrabajadores()
    {
        $centro = Auth::user()->centroMedico;

        $trabajadoresNoMedicos = PersonalMedico::where('id_centro', $centro->id_centro)
            ->whereNull('id_especialidad')
            ->with('usuario')
            ->get();

        return view('admin.centro.trabajadores.index', compact('trabajadoresNoMedicos'));
    }

    /**
     * Mostrar el formulario para editar personal médico.
     */
    public function edit($id)
    {
        $personal = PersonalMedico::with('usuario')->findOrFail($id);
        $especialidades = Especialidad::all();
        $roles = Rol::where('id_centro', Auth::user()->id_centro)->get();

        if ($personal->id_centro !== Auth::user()->id_centro) {
            abort(403, 'No tienes permiso para editar este personal médico.');
        }

        return view('admin.centro.personal.edit', compact('personal', 'especialidades', 'roles'));
    }

    /**
     * Actualizar datos de personal médico.
     */
    public function update(Request $request, $id)
    {
        $personal = PersonalMedico::with('usuario')->findOrFail($id);

        if ($personal->id_centro !== Auth::user()->id_centro) {
            abort(403, 'No tienes permiso para actualizar este personal médico.');
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'id_especialidad' => 'required|exists:especialidades,id_especialidad',
            'dni' => 'required|string|max:20|unique:personal_medico,dni,' . $id . ',id_personal_medico',
            'telefono' => 'nullable|string|max:20',
            'correo_contacto' => 'required|email|unique:personal_medico,correo_contacto,' . $id . ',id_personal_medico',
            'correo_sistema' => 'required|email|unique:usuarios,email,' . $personal->usuario->id_usuario . ',id_usuario',
            'sueldo' => 'required|numeric|min:0',
            'codigo_postal' => 'nullable|string|max:10',
            'banco' => 'nullable|string|max:50',
            'numero_cuenta' => 'nullable|string|max:50',
            'numero_colegiatura' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $personal->usuario->update([
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['correo_sistema'],
            'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : $personal->usuario->password,
        ]);

        $personal->update($validatedData);
        session()->flash('success', '¡Usuario creado exitosamente!');


        return redirect()->route('personal-medico.index')->with('success', 'Personal médico actualizado exitosamente.');
    }

    /**
     * Mostrar formulario para editar trabajadores no médicos.
     */
    public function editTrabajador($id)
    {
        $trabajador = PersonalMedico::with('usuario')->whereNull('id_especialidad')->findOrFail($id);

        if ($trabajador->id_centro !== Auth::user()->id_centro) {
            abort(403, 'No tienes permiso para editar este trabajador no médico.');
        }

        return view('admin.centro.trabajadores.edit', compact('trabajador'));
    }

    /**
     * Actualizar datos de trabajadores no médicos.
     */
    public function updateTrabajador(Request $request, $id)
    {
        $trabajador = PersonalMedico::with('usuario')->whereNull('id_especialidad')->findOrFail($id);

        if ($trabajador->id_centro !== Auth::user()->id_centro) {
            abort(403, 'No tienes permiso para actualizar este trabajador no médico.');
        }

        $validatedData = $request->validate([
            'dni' => 'required|string|max:20|unique:personal_medico,dni,' . $id . ',id_personal_medico',
            'telefono' => 'nullable|string|max:20',
            'correo_contacto' => 'required|email|unique:personal_medico,correo_contacto,' . $id . ',id_personal_medico',
            'sueldo' => 'required|numeric|min:0',
            'codigo_postal' => 'nullable|string|max:10',
            'banco' => 'nullable|string|max:50',
            'numero_cuenta' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ]);

        $trabajador->update($validatedData);

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador no médico actualizado exitosamente.');
    }

    /**
     * Eliminar personal médico.
     */
    public function destroy($id)
    {
        $personal = PersonalMedico::with('usuario')->findOrFail($id);

        if ($personal->id_centro !== Auth::user()->id_centro) {
            abort(403, 'No tienes permiso para eliminar este personal médico.');
        }

        $personal->usuario->delete();
        $personal->delete();

        return redirect()->route('personal-medico.index')->with('success', 'Personal médico eliminado exitosamente.');
    }

    /**
     * Eliminar trabajador no médico.
     */
    public function destroyTrabajador($id)
    {
        $trabajador = PersonalMedico::with('usuario')->whereNull('id_especialidad')->findOrFail($id);

        if ($trabajador->id_centro !== Auth::user()->id_centro) {
            abort(403, 'No tienes permiso para eliminar este trabajador no médico.');
        }

        $trabajador->usuario->delete();
        $trabajador->delete();

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador no médico eliminado exitosamente.');
    }
}
