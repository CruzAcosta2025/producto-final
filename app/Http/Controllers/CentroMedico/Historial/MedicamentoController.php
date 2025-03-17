<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicamentoReceta;
use App\Models\Receta;
use Illuminate\Support\Facades\Log;

class MedicamentoController extends Controller
{
    public function index($idReceta)
    {
        $receta = Receta::with('historialClinico.paciente', 'medicamentos')->findOrFail($idReceta);
        $medicamentos = $receta->medicamentos;

        return view('admin.centro.historial.recetas.medicamentos.index', compact('receta', 'medicamentos'));
    }

    public function create($idReceta)
    {
        $receta = Receta::with('historialClinico.paciente')->findOrFail($idReceta);

        return view('admin.centro.historial.recetas.medicamentos.create', compact('receta'));
    }

    public function store(Request $request, $idReceta)
    {
        $request->validate([
            'medicamento' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'frecuencia' => 'required|string|max:255',
            'duracion' => 'required|string|max:255',
            'instrucciones' => 'nullable|string|max:500',
        ]);

        MedicamentoReceta::create([
            'id_receta' => $idReceta,
            'medicamento' => $request->medicamento,
            'dosis' => $request->dosis,
            'frecuencia' => $request->frecuencia,
            'duracion' => $request->duracion,
            'instrucciones' => $request->instrucciones,
        ]);

        return redirect()->route('medicamentos.index', $idReceta)->with('success', 'Medicamento añadido correctamente.');
    }

    public function edit($idReceta, $idMedicamento)
    {
        $receta = Receta::with('historialClinico.paciente')->findOrFail($idReceta);
        $medicamento = MedicamentoReceta::where('id_receta', $idReceta)->findOrFail($idMedicamento);

        return view('admin.centro.historial.recetas.medicamentos.edit', compact('receta', 'medicamento'));
    }

    public function update(Request $request, $idReceta, $idMedicamento)
    {
        $request->validate([
            'medicamento' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'frecuencia' => 'required|string|max:255',
            'duracion' => 'required|string|max:255',
            'instrucciones' => 'nullable|string|max:500',
        ]);

        $medicamento = MedicamentoReceta::where('id_receta', $idReceta)->findOrFail($idMedicamento);
        $medicamento->update($request->all());

        return redirect()->route('medicamentos.index', $idReceta)->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy($idReceta, $idMedicamento)
    {
        $medicamento = MedicamentoReceta::where('id_receta', $idReceta)->findOrFail($idMedicamento);
        $medicamento->delete();

        return response()->json(['success' => true, 'message' => 'Medicamento eliminado correctamente.']);
    }
}
