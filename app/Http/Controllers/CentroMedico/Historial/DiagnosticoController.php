<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\HistorialClinico;
use App\Models\Cie10; // Agregamos el modelo CIE-10
use Illuminate\Support\Facades\Log;

class DiagnosticoController extends Controller
{
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $diagnosticos = collect();

        if ($dni) {
            $paciente = Paciente::where('dni', $dni)
                ->with('historialClinico.diagnostico.cie10')
                ->first();

            if ($paciente && $paciente->historialClinico->isNotEmpty()) {
                $diagnosticos = $paciente->historialClinico->flatMap->diagnostico;
            }
        }

        return view('admin.centro.historial.diagnosticos.index', compact('paciente', 'diagnosticos', 'dni'));
    }



    public function create($idHistorial)
    {
        $historial = HistorialClinico::with('paciente')->findOrFail($idHistorial);
        $paciente = $historial->paciente;

        // 🔹 Cargamos los datos de la CIE-10 para la vista
        $cie10 = Cie10::all();

        return view('admin.centro.historial.diagnosticos.create', compact('historial', 'paciente', 'cie10'));
    }

    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'required|date',
            'cie_10_id' => 'required|exists:cie_10,id_cie10'
        ]);

        $diagnostico = Diagnostico::create([
            'id_historial' => $idHistorial,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
            'id_cie10' => $request->cie_10_id, // ✅ Guardamos el ID de la CIE-10 correctamente

        ]);

        Log::info('Diagnóstico creado:', $diagnostico->toArray());

        return redirect()->route('diagnosticos.index', ['dni' => $diagnostico->historialClinico->paciente->dni])
            ->with('success', 'Diagnóstico registrado exitosamente.');
    }


    public function edit($idHistorial, $idDiagnostico)
    {
        $diagnostico = Diagnostico::where('id_historial', $idHistorial)->findOrFail($idDiagnostico);
        $paciente = $diagnostico->historialClinico->paciente;

        // 🔹 Cargamos los códigos CIE-10 también en la vista de edición
        $cie10 = Cie10::all();

        return view('admin.centro.historial.diagnosticos.edit', compact('diagnostico', 'paciente', 'cie10'));
    }

    public function update(Request $request, $idHistorial, $idDiagnostico)
    {
        $request->validate([
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'required|date',
            'cie_10_id' => 'required|exists:cie_10,id_cie10' // Asegurar que el ID del CIE-10 es válido
        ]);

        $diagnostico = Diagnostico::where('id_historial', $idHistorial)->findOrFail($idDiagnostico);

        // Actualizar los datos
        $diagnostico->update([
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
            'id_cie10' => $request->cie_10_id, // ✅ Ahora también se actualiza el código CIE-10
        ]);

        Log::info('Diagnóstico actualizado:', $diagnostico->toArray());

        return redirect()->route('diagnosticos.index', ['dni' => $diagnostico->historialClinico->paciente->dni])
            ->with('success', 'Diagnóstico actualizado exitosamente.');
    }


    public function destroy($idHistorial, $idDiagnostico)
    {
        $diagnostico = Diagnostico::where('id_historial', $idHistorial)->findOrFail($idDiagnostico);
        $dni = $diagnostico->historialClinico->paciente->dni;
        $diagnostico->delete();

        Log::info('Diagnóstico eliminado:', ['id' => $idDiagnostico, 'historial_id' => $idHistorial]);

        return response()->json(['success' => true, 'message' => 'Diagnóstico eliminado exitosamente.', 'dni' => $dni]);
    }
}
