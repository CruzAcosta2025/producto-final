<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use App\Models\Tratamiento;
use App\Models\Paciente;
use App\Models\HistorialClinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TratamientoController extends Controller
{
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $tratamientos = collect();

        if ($dni) {
            $paciente = Paciente::where('dni', $dni)->with('historialClinico.tratamientos')->first();

            if ($paciente && $paciente->historialClinico->isNotEmpty()) {
                $tratamientos = $paciente->historialClinico->flatMap->tratamientos;
                Log::info('Paciente encontrado:', ['id' => $paciente->id_paciente, 'nombre' => $paciente->primer_nombre]);
            } else {
                Log::info('Paciente no encontrado para DNI: ' . $dni);
            }
        }

        return view('admin.centro.historial.tratamientos.index', compact('paciente', 'tratamientos', 'dni'));
    }

    public function create($idHistorial)
    {
        $historial = HistorialClinico::findOrFail($idHistorial);
        $paciente = $historial->paciente;

        return view('admin.centro.historial.tratamientos.create', compact('historial', 'paciente'));
    }

    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fecha_creacion' => 'nullable|date',
        ]);

        Tratamiento::create([
            'id_historial' => $idHistorial,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
        ]);

        return redirect()->route('tratamientos.index', ['dni' => $request->get('dni')])
            ->with('success', 'Tratamiento registrado exitosamente.');
    }

    public function edit($idHistorial, $idTratamiento)
    {
        $tratamiento = Tratamiento::where('id_historial', $idHistorial)->findOrFail($idTratamiento);
        $paciente = $tratamiento->historialClinico->paciente;

        return view('admin.centro.historial.tratamientos.edit', compact('tratamiento', 'paciente'));
    }

    public function update(Request $request, $idHistorial, $idTratamiento)
    {
        $request->validate([
            'descripcion' => 'required|string', // Elimina la restricción de longitud
            'fecha_creacion' => 'nullable|date',
        ]);

        $tratamiento = Tratamiento::where('id_historial', $idHistorial)->findOrFail($idTratamiento);

        $data = $request->only(['descripcion', 'fecha_creacion']);

        // Si no se proporciona una nueva fecha, conserva la actual
        if (empty($data['fecha_creacion'])) {
            unset($data['fecha_creacion']);
        }

        $tratamiento->update($data);

        return redirect()->route('tratamientos.index', ['dni' => $tratamiento->historialClinico->paciente->dni])
            ->with('success', 'Tratamiento actualizado exitosamente.');
    }


    public function destroy($idHistorial, $idTratamiento)
    {
        $tratamiento = Tratamiento::where('id_historial', $idHistorial)->findOrFail($idTratamiento);
        $tratamiento->delete();

        return response()->json(['success' => true, 'message' => 'Tratamiento eliminado exitosamente.']);
    }
}
