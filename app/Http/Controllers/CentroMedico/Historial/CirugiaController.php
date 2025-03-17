<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cirugia;
use App\Models\Paciente;
use App\Models\HistorialClinico;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CirugiaController extends Controller
{
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $cirugias = collect();

        if ($dni) {
            $paciente = Paciente::where('dni', $dni)->with(['historialClinico.cirugias'])->first();

            if ($paciente && $paciente->historialClinico->isNotEmpty()) {
                $cirugias = $paciente->historialClinico->flatMap->cirugias;
                Log::info('Paciente encontrado:', ['id' => $paciente->id_paciente, 'nombre' => $paciente->primer_nombre]);
            } else {
                Log::info('Paciente no encontrado para DNI: ' . $dni);
            }
        }

        return view('admin.centro.historial.cirugias.index', compact('paciente', 'cirugias', 'dni'));
    }

    public function create($idHistorial)
    {
        $historial = HistorialClinico::with('paciente')->findOrFail($idHistorial);
        $paciente = $historial->paciente;

        // Asegúrate de importar Especialidad y Auth
        $especialidades = Especialidad::where('id_centro', Auth::user()->id_centro)->get();

        return view('admin.centro.historial.cirugias.create', compact('historial', 'paciente', 'especialidades'));
    }



    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'tipo_cirugia' => 'required|string|max:255',
            'fecha_cirugia' => 'required|date',
            'cirujano' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'complicaciones' => 'nullable|string',
            'notas_postoperatorias' => 'nullable|string',
        ]);

        $cirugia = Cirugia::create([
            'id_historial' => $idHistorial,
            'tipo_cirugia' => $request->tipo_cirugia,
            'fecha_cirugia' => $request->fecha_cirugia,
            'cirujano' => $request->cirujano,
            'descripcion' => $request->descripcion,
            'complicaciones' => $request->complicaciones,
            'notas_postoperatorias' => $request->notas_postoperatorias,
        ]);

        Log::info('Cirugía creada:', $cirugia->toArray());

        return redirect()->route('cirugias.index', ['dni' => $cirugia->historialClinico->paciente->dni])
            ->with('success', 'Cirugía registrada exitosamente.');
    }

    public function edit($idHistorial, $idCirugia)
    {
        $cirugia = Cirugia::where('id_historial', $idHistorial)->findOrFail($idCirugia);
        $paciente = $cirugia->historialClinico->paciente;

        return view('admin.centro.historial.cirugias.edit', compact('cirugia', 'paciente'));
    }

    public function update(Request $request, $idHistorial, $idCirugia)
    {
        $validatedData = $request->validate([
            'tipo_cirugia' => 'required|string|max:255',
            'fecha_cirugia' => 'nullable|date',
            'cirujano' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'complicaciones' => 'nullable|string',
            'notas_postoperatorias' => 'nullable|string',
        ]);

        $cirugia = Cirugia::where('id_historial', $idHistorial)->findOrFail($idCirugia);

        // Si no se envía una nueva fecha, mantener la existente
        if (empty($validatedData['fecha_cirugia'])) {
            $validatedData['fecha_cirugia'] = $cirugia->fecha_cirugia;
        }

        $cirugia->update($validatedData);

        Log::info('Cirugía actualizada:', $cirugia->toArray());

        return redirect()->route('cirugias.index', ['dni' => $cirugia->historialClinico->paciente->dni])
            ->with('success', 'Cirugía actualizada exitosamente.');
    }


    public function destroy($idHistorial, $idCirugia)
    {
        $cirugia = Cirugia::where('id_historial', $idHistorial)->findOrFail($idCirugia);
        $dni = $cirugia->historialClinico->paciente->dni;
        $cirugia->delete();

        Log::info('Cirugía eliminada:', ['id' => $idCirugia, 'historial_id' => $idHistorial]);

        return response()->json(['success' => true, 'message' => 'Cirugía eliminada exitosamente.', 'dni' => $dni]);
    }
}
