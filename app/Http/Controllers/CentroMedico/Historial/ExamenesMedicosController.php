<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamenMedico;
use App\Models\HistorialClinico;
use Illuminate\Support\Facades\Auth;

class ExamenesMedicosController extends Controller
{
    // Mostrar lista de exámenes médicos de un historial
    public function index($idHistorial)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($idHistorial);

        $examenes = $historial->examenesMedicos;

        return view('admin.centro.historial.examenes.index', compact('historial', 'examenes'));
    }

    // Buscar historial clínico por DNI del paciente
    public function buscar(Request $request)
    {
        $request->validate(['dni' => 'required|digits:8']);

        $historial = HistorialClinico::whereHas('paciente', function ($query) use ($request) {
            $query->where('dni', $request->dni);
        })
            ->where('id_centro', Auth::user()->id_centro)
            ->first();

        if (!$historial) {
            return redirect()->back()->withErrors(['dni' => 'Paciente no encontrado o sin historial clínico.']);
        }

        $examenes = $historial->examenesMedicos;

        return view('admin.centro.historial.examenes.index', compact('historial', 'examenes'));
    }

    // Mostrar formulario para crear un nuevo examen médico
    public function create($idHistorial)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($idHistorial);

        return view('admin.centro.historial.examenes.create', compact('historial'));
    }

    // Almacenar un nuevo examen médico
    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'tipo_examen' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'resultados' => 'nullable|string',
        ]);

        ExamenMedico::create([
            'id_historial' => $idHistorial,
            'tipo_examen' => $request->tipo_examen,
            'descripcion' => $request->descripcion,
            'fecha_examen' => now(),
            'resultados' => $request->resultados,
        ]);

        return redirect()->route('examenes.index', $idHistorial)
            ->with('success', 'Examen médico registrado exitosamente.');
    }

    // Mostrar formulario para editar un examen médico
    public function edit($idHistorial, $idExamen)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($idHistorial);

        $examen = ExamenMedico::where('id_historial', $idHistorial)->findOrFail($idExamen);

        return view('admin.centro.historial.examenes.edit', compact('historial', 'examen'));
    }

    // Actualizar un examen médico existente
    public function update(Request $request, $idHistorial, $idExamen)
    {
        $request->validate([
            'tipo_examen' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'resultados' => 'nullable|string',
        ]);

        $examen = ExamenMedico::where('id_historial', $idHistorial)->findOrFail($idExamen);

        $examen->update([
            'tipo_examen' => $request->tipo_examen,
            'descripcion' => $request->descripcion,
            'resultados' => $request->resultados,
        ]);

        return redirect()->route('examenes.index', $idHistorial)
            ->with('success', 'Examen médico actualizado exitosamente.');
    }

    // Eliminar un examen médico
    public function destroy($idHistorial, $idExamen)
    {
        $examen = ExamenMedico::where('id_historial', $idHistorial)->findOrFail($idExamen);
        $examen->delete();

        return redirect()->route('examenes.index', $idHistorial)
            ->with('success', 'Examen médico eliminado exitosamente.');
    }
}
