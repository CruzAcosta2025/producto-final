<?php

namespace App\Http\Controllers\CentroMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Especialidad;
use App\Models\PersonalMedico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GestionPersonalController extends Controller
{
    /**
     * Mostrar formulario para crear personal médico.
     */
    public function mostrarFormularioPersonal($id)
    {
        // Verificar usuario y centro
        $usuario = Usuario::where('id_usuario', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        // Obtener especialidades
        $especialidades = Especialidad::all();
        session()->flash('success', '¡Usuario creado exitosamente!');


        return view('admin.centro.personal.create', compact('usuario', 'especialidades'));
    }

    /**
     * Guardar personal médico.
     */
    public function guardarPersonalMedico(Request $request, $id)
    {
        try {
            // Verificar usuario y centro
            $usuario = Usuario::where('id_usuario', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->firstOrFail();

            Log::info('Usuario encontrado:', ['id_usuario' => $usuario->id_usuario]);

            // Validar datos
            $validatedData = $request->validate([
                'id_especialidad' => 'required|exists:especialidades,id_especialidad',
                'dni' => 'required|string|max:20|unique:personal_medico,dni',
                'telefono' => 'nullable|string|max:20',
                'correo_contacto' => 'required|email|unique:personal_medico,correo_contacto',
                'sueldo' => 'required|numeric|min:0',
                'codigo_postal' => 'nullable|string|max:10',
                'fecha_alta' => 'required|date',
                'banco' => 'nullable|string|max:50',
                'numero_cuenta' => 'nullable|string|max:50',
                'numero_colegiatura' => 'nullable|string|max:50',
                'direccion' => 'nullable|string|max:255',
            ]);

            Log::info('Datos validados para personal médico:', $validatedData);

            // Crear personal médico
            $personal = new PersonalMedico();
            $personal->id_usuario = $usuario->id_usuario;
            $personal->id_especialidad = $validatedData['id_especialidad'];
            $personal->dni = $validatedData['dni'];
            $personal->telefono = $validatedData['telefono'];
            $personal->correo_contacto = $validatedData['correo_contacto'];
            $personal->sueldo = $validatedData['sueldo'];
            $personal->codigo_postal = $validatedData['codigo_postal'];
            $personal->fecha_alta = $validatedData['fecha_alta'];
            $personal->banco = $validatedData['banco'];
            $personal->numero_cuenta = $validatedData['numero_cuenta'];
            $personal->numero_colegiatura = $validatedData['numero_colegiatura'];
            $personal->direccion = $validatedData['direccion'];
            $personal->id_centro = Auth::user()->id_centro;

            if ($personal->save()) {
                Log::info('Personal médico creado:', $personal->toArray());
                return redirect()->route('admin.centro.personal-medico.index')
                    ->with('success', 'Personal médico agregado exitosamente.');
            } else {
                Log::error('Error al guardar el personal médico: No se pudo guardar en la base de datos');
                return back()->withInput()->with('error', 'Error al guardar el personal médico: No se pudo guardar en la base de datos');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al guardar el personal médico:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Error al guardar el personal médico: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario para crear trabajadores no médicos.
     */
    public function mostrarFormularioTrabajadores($id)
    {
        // Verificar usuario y centro
        $usuario = Usuario::where('id_usuario', $id)
            ->where('id_centro', Auth::user()->id_centro)
            ->firstOrFail();

        return view('admin.centro.trabajadores.create', compact('usuario'));
    }

    /**
     * Guardar personal no médico.
     */
    public function guardarPersonalNoMedico(Request $request, $id)
    {
        try {
            // Verificar usuario y centro
            $usuario = Usuario::where('id_usuario', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->firstOrFail();

            Log::info('Usuario encontrado:', ['id_usuario' => $usuario->id_usuario]);

            // Validar datos
            $validatedData = $request->validate([
                'dni' => 'required|string|max:20|unique:personal_medico,dni',
                'telefono' => 'nullable|string|max:20',
                'correo_contacto' => 'required|email|unique:personal_medico,correo_contacto',
                'sueldo' => 'required|numeric|min:0',
                'codigo_postal' => 'nullable|string|max:10',
                'fecha_alta' => 'required|date',
                'banco' => 'nullable|string|max:50',
                'numero_cuenta' => 'nullable|string|max:50',
                'direccion' => 'nullable|string|max:255',
            ]);

            Log::info('Datos validados para personal no médico:', $validatedData);

            // Crear personal no médico
            $personal = new PersonalMedico();
            $personal->id_usuario = $usuario->id_usuario;
            $personal->dni = $validatedData['dni'];
            $personal->telefono = $validatedData['telefono'];
            $personal->correo_contacto = $validatedData['correo_contacto'];
            $personal->sueldo = $validatedData['sueldo'];
            $personal->codigo_postal = $validatedData['codigo_postal'];
            $personal->fecha_alta = $validatedData['fecha_alta'];
            $personal->banco = $validatedData['banco'];
            $personal->numero_cuenta = $validatedData['numero_cuenta'];
            $personal->direccion = $validatedData['direccion'];
            $personal->id_centro = Auth::user()->id_centro;
            // No se establece id_especialidad para personal no médico

            if ($personal->save()) {
                Log::info('Personal no médico creado:', $personal->toArray());
                return redirect()->route('trabajadores.index')
                    ->with('success', 'Personal no médico agregado exitosamente.');
            } else {
                Log::error('Error al guardar el personal no médico: No se pudo guardar en la base de datos');
                return back()->withInput()->with('error', 'Error al guardar el personal no médico: No se pudo guardar en la base de datos');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error al guardar el personal no médico:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Error al guardar el personal no médico: ' . $e->getMessage());
        }
    }
}
