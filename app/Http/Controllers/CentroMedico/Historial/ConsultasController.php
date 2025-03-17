<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\HistorialClinico;
use App\Models\PersonalMedico;
use Illuminate\Support\Facades\Auth;

class ConsultasController extends Controller
{
    // Mostrar formulario para crear una nueva consulta
    public function create($idHistorial)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)->findOrFail($idHistorial);

        // Obtener la lista de médicos disponibles si el usuario es Administrador Centro Médico
        $medicos = [];
        if (Auth::user()->rol->nombre_rol === 'Administrador Centro Médico') {
            $medicos = PersonalMedico::where('id_centro', Auth::user()->id_centro)
                ->whereNotNull('id_especialidad') // Solo médicos con especialidad
                ->get();
        }

        return view('admin.centro.historial.consultas.create', compact('historial', 'medicos'));
    }

    // Almacenar la nueva consulta en la base de datos
    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'motivo_consulta' => 'required|string',
            'sintomas' => 'required|string',
            'observaciones' => 'nullable|string',
            'id_medico' => 'nullable|exists:personal_medico,id_personal_medico',
        ]);

        $id_medico = null;

        if (Auth::user()->rol->nombre_rol === 'Médico/Doctor') {
            $personalMedico = PersonalMedico::where('id_usuario', Auth::id())->first();
            if ($personalMedico) {
                $id_medico = $personalMedico->id_personal_medico;
            } else {
                return back()->withErrors(['id_medico' => 'No se encontró su registro como médico.']);
            }
        } elseif (Auth::user()->rol->nombre_rol === 'Administrador Centro Médico') {
            $id_medico = $request->id_medico;
        }

        if (!$id_medico) {
            return back()->withErrors(['id_medico' => 'Debe asignarse un médico a la consulta.']);
        }

        Consulta::create([
            'id_historial' => $idHistorial,
            'id_medico' => $id_medico,
            'fecha_consulta' => now(),
            'motivo_consulta' => $request->motivo_consulta,
            'sintomas' => $request->sintomas,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('historial.show', $idHistorial)->with('success', 'Consulta registrada exitosamente.');
    }

    // Mostrar formulario para editar una consulta existente
    public function edit($idHistorial, $idConsulta)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)->findOrFail($idHistorial);
        $consulta = Consulta::where('id_historial', $idHistorial)->findOrFail($idConsulta);

        return view('admin.centro.historial.consultas.edit', compact('historial', 'consulta'));
    }

    // Actualizar los datos de una consulta
    public function update(Request $request, $idHistorial, $idConsulta)
    {
        $request->validate([
            'motivo_consulta' => 'required|string',
            'sintomas' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        $consulta = Consulta::where('id_historial', $idHistorial)->findOrFail($idConsulta);

        $consulta->update([
            'fecha_consulta' => now(),
            'motivo_consulta' => $request->motivo_consulta,
            'sintomas' => $request->sintomas,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('historial.show', $idHistorial)->with('success', 'Consulta actualizada exitosamente.');
    }
}
