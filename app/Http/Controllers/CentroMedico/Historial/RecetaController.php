<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receta;
use App\Models\Paciente;
use App\Models\HistorialClinico;
use App\Models\PersonalMedico;
use Illuminate\Support\Facades\Auth;

class RecetaController extends Controller
{
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $recetas = collect();

        if ($dni) {
            $paciente = Paciente::where('dni', $dni)->with(['historialClinico.recetas.personalMedico'])->first();

            if ($paciente && $paciente->historialClinico->isNotEmpty()) {
                $recetas = $paciente->historialClinico->flatMap->recetas;
            }
        }

        return view('admin.centro.historial.recetas.index', compact('paciente', 'recetas', 'dni'));
    }

    public function create($idHistorial)
    {
        $historial = HistorialClinico::with('paciente')->findOrFail($idHistorial);
        $paciente = $historial->paciente;

        $personalMedico = PersonalMedico::where('id_centro', Auth::user()->id_centro)
            ->with('usuario', 'especialidad')
            ->get();

        return view('admin.centro.historial.recetas.create', compact('historial', 'paciente', 'personalMedico'));
    }

    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'id_medico' => 'required|exists:personal_medico,id_personal_medico',
            'fecha_receta' => 'required|date',
        ]);

        $receta = Receta::create([
            'id_historial' => $idHistorial,
            'id_medico' => $request->id_medico,
            'fecha_receta' => $request->fecha_receta,
        ]);

        return redirect()->route('recetas.index', ['dni' => $receta->historialClinico->paciente->dni])
            ->with('success', 'Receta registrada exitosamente.');
    }

    public function edit($idHistorial, $idReceta)
    {
        $receta = Receta::where('id_historial', $idHistorial)->findOrFail($idReceta);
        $paciente = $receta->historialClinico->paciente;

        $personalMedico = PersonalMedico::where('id_centro', Auth::user()->id_centro)
            ->with('usuario', 'especialidad')
            ->get();

        return view('admin.centro.historial.recetas.edit', compact('receta', 'paciente', 'personalMedico'));
    }

    public function update(Request $request, $idHistorial, $idReceta)
    {
        $request->validate([
            'id_medico' => 'required|exists:personal_medico,id_personal_medico',
            'fecha_receta' => 'nullable|date',
        ]);

        $receta = Receta::where('id_historial', $idHistorial)->findOrFail($idReceta);

        $receta->update([
            'id_medico' => $request->id_medico,
            'fecha_receta' => $request->fecha_receta ?? $receta->fecha_receta, // Mantener la fecha actual si no se proporciona una nueva
        ]);

        return redirect()->route('recetas.index', ['dni' => $receta->historialClinico->paciente->dni])
            ->with('success', 'Receta actualizada exitosamente.');
    }


    public function destroy($idHistorial, $idReceta)
    {
        $receta = Receta::where('id_historial', $idHistorial)->findOrFail($idReceta);
        $receta->delete();

        return response()->json(['success' => true, 'message' => 'Receta eliminada exitosamente.']);
    }
}
