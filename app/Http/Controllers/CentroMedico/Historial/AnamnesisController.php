<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anamnesis;
use App\Models\Paciente;
use App\Models\HistorialClinico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnamnesisController extends Controller
{
    public function index($idHistorial)
    {
        // Verifica si el historial pertenece al centro del usuario autenticado
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($idHistorial);

        // Obtiene las anamnesis asociadas al historial
        $anamnesis = Anamnesis::where('id_historial', $idHistorial)->get();

        return view('admin.centro.historial.anamnesis.index', compact('historial', 'anamnesis', 'idHistorial'));
    }



    // Mostrar formulario de creación de Anamnesis
    public function create($idHistorial)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)->findOrFail($idHistorial);
        return view('admin.centro.historial.anamnesis.create', compact('historial', 'idHistorial'));
    }

    // Guardar nueva Anamnesis en la base de datos
    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'antecedentes' => 'required|string',
            'sintomas_actuales' => 'required|string',
            'habitos' => 'nullable|string',
        ]);

        // Concatenar los datos en una sola descripción
        $descripcion = "Antecedentes: {$request->antecedentes}\n";
        $descripcion .= "Síntomas Actuales: {$request->sintomas_actuales}\n";
        $descripcion .= "Hábitos: {$request->habitos}\n";

        Anamnesis::create([
            'id_historial' => $idHistorial,
            'descripcion' => $descripcion,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('historial.show', $idHistorial)->with('success', 'Anamnesis registrada exitosamente.');
    }

    // Mostrar formulario de edición de Anamnesis
    public function edit($idHistorial, $idAnamnesis)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)->findOrFail($idHistorial);
        $anamnesis = Anamnesis::where('id_historial', $idHistorial)->findOrFail($idAnamnesis);

        // Separar la descripción en secciones para mostrar en los campos de entrada
        $data = explode("\n", $anamnesis->descripcion);
        $antecedentes = str_replace("Antecedentes: ", "", $data[0] ?? "");
        $sintomas_actuales = str_replace("Síntomas Actuales: ", "", $data[1] ?? "");
        $habitos = str_replace("Hábitos: ", "", $data[2] ?? "");

        return view('admin.centro.historial.anamnesis.edit', compact('historial', 'anamnesis', 'idHistorial', 'antecedentes', 'sintomas_actuales', 'habitos'));
    }

    // Actualizar Anamnesis en la base de datos
    public function update(Request $request, $idHistorial, $idAnamnesis)
    {
        $request->validate([
            'antecedentes' => 'required|string',
            'sintomas_actuales' => 'required|string',
            'habitos' => 'nullable|string',
        ]);

        // Concatenar los datos en una sola descripción
        $descripcion = "Antecedentes: {$request->antecedentes}\n";
        $descripcion .= "Síntomas Actuales: {$request->sintomas_actuales}\n";
        $descripcion .= "Hábitos: {$request->habitos}\n";

        $anamnesis = Anamnesis::where('id_historial', $idHistorial)->findOrFail($idAnamnesis);
        $anamnesis->update([
            'descripcion' => $descripcion,
        ]);

        return redirect()->route('historial.show', $idHistorial)->with('success', 'Anamnesis actualizada exitosamente.');
    }

    public function destroy($idHistorial, $idAnamnesis)
    {
        try {
            // Verifica que el historial clínico pertenezca al centro del usuario autenticado
            $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
                ->findOrFail($idHistorial);

            // Busca la anamnesis en el historial correspondiente
            $anamnesis = Anamnesis::where('id_historial', $idHistorial)
                ->findOrFail($idAnamnesis);

            // Eliminar la anamnesis
            $anamnesis->delete();

            // Retornar respuesta JSON para AJAX
            return response()->json(['success' => true, 'message' => 'Anamnesis eliminada exitosamente.']);
        } catch (\Exception $e) {
            \Log::error("Error al eliminar anamnesis: " . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error al eliminar la anamnesis.'], 500);
        }
    }
    
}
