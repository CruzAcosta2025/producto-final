<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacuna;
use App\Models\Paciente;
use App\Models\HistorialClinico;
use Illuminate\Support\Facades\Log;

class VacunaController extends Controller
{
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $vacunas = collect();

        if ($dni) {
            // Buscar paciente por DNI con historiales y vacunas
            $paciente = Paciente::where('dni', $dni)->with('historialClinico.vacunas')->first();

            if ($paciente && $paciente->historialClinico->isNotEmpty()) {
                $vacunas = $paciente->historialClinico->flatMap->vacunas; // Todas las vacunas del historial
                Log::info('Paciente encontrado:', ['id' => $paciente->id_paciente, 'nombre' => $paciente->primer_nombre]);
                Log::info('Vacunas obtenidas:', $vacunas->toArray());
            } else {
                Log::warning('No se encontraron historiales o vacunas para el DNI: ' . $dni);
            }
        } else {
            Log::warning('No se ingresó un DNI para buscar.');
        }

        return view('admin.centro.historial.vacunas.index', compact('paciente', 'vacunas', 'dni'));
    }

    public function create($idHistorial)
    {
        $historial = HistorialClinico::with('paciente')->findOrFail($idHistorial);

        Log::info('Formulario de creación abierto para historial:', ['id_historial' => $idHistorial]);

        return view('admin.centro.historial.vacunas.create', ['historial' => $historial, 'paciente' => $historial->paciente]);
    }

    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'nombre_vacuna' => 'required|string|max:255',
            'fecha_aplicacion' => 'required|date',
            'dosis' => 'required|string|max:50',
            'proxima_dosis' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $historial = HistorialClinico::findOrFail($idHistorial);

        $vacuna = Vacuna::create([
            'id_historial' => $historial->id_historial,
            'nombre_vacuna' => $request->nombre_vacuna,
            'fecha_aplicacion' => $request->fecha_aplicacion,
            'dosis' => $request->dosis,
            'proxima_dosis' => $request->proxima_dosis,
            'observaciones' => $request->observaciones,
        ]);

        Log::info('Vacuna creada exitosamente:', $vacuna->toArray());

        return redirect()->route('vacunas.index', ['dni' => $historial->paciente->dni])
            ->with('success', 'Vacuna registrada exitosamente.');
    }

    public function edit($idHistorial, $idVacuna)
    {
        $vacuna = Vacuna::where('id_historial', $idHistorial)->findOrFail($idVacuna);
        $paciente = $vacuna->historialClinico->paciente;

        Log::info('Formulario de edición abierto para vacuna:', ['id_vacuna' => $idVacuna]);

        return view('admin.centro.historial.vacunas.edit', compact('vacuna', 'paciente'));
    }

    public function update(Request $request, $idHistorial, $idVacuna)
    {
        $request->validate([
            'nombre_vacuna' => 'required|string|max:255',
            'fecha_aplicacion' => 'required|date',
            'dosis' => 'required|string|max:50',
            'proxima_dosis' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $vacuna = Vacuna::where('id_historial', $idHistorial)->findOrFail($idVacuna);
        $vacuna->update($request->only(['nombre_vacuna', 'fecha_aplicacion', 'dosis', 'proxima_dosis', 'observaciones']));

        Log::info('Vacuna actualizada exitosamente:', $vacuna->toArray());

        return redirect()->route('vacunas.index', ['dni' => $vacuna->historialClinico->paciente->dni])
            ->with('success', 'Vacuna actualizada exitosamente.');
    }

    public function destroy($idHistorial, $idVacuna)
    {
        $vacuna = Vacuna::where('id_historial', $idHistorial)->findOrFail($idVacuna);
        $dni = $vacuna->historialClinico->paciente->dni;
        $vacuna->delete();

        Log::info('Vacuna eliminada:', ['id_vacuna' => $idVacuna, 'id_historial' => $idHistorial]);

        return response()->json(['success' => true, 'message' => 'Vacuna eliminada exitosamente.', 'dni' => $dni]);
    }
}
