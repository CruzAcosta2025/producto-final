<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alergia;
use App\Models\Paciente;

class AlergiaController extends Controller
{
    // Listar alergias con buscador por DNI
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $alergias = collect(); // Colección vacía

        if ($dni) {
            $paciente = Paciente::where('dni', $dni)->with('alergias')->first();
            if ($paciente) {
                $alergias = $paciente->alergias;
            }
        }

        return view('admin.centro.historial.alergias.index', compact('paciente', 'alergias', 'dni'));
    }

    // Mostrar formulario para crear una nueva alergia
    public function create($idPaciente)
    {
        $paciente = Paciente::findOrFail($idPaciente);

        return view('admin.centro.historial.alergias.create', compact('paciente'));
    }

    // Guardar una nueva alergia en la base de datos
    public function store(Request $request, $idPaciente)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'severidad' => 'required|string|max:50',
        ]);

        Alergia::create([
            'id_paciente' => $idPaciente,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'severidad' => $request->severidad,
        ]);

        return redirect()->route('alergias.index')->with('success', 'Alergia registrada exitosamente.');
    }


    // Actualizar una alergia en la base de datos
    public function update(Request $request, $idPaciente, $idAlergia)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'severidad' => 'required|string|max:50',
        ]);

        $alergia = Alergia::where('id_paciente', $idPaciente)->findOrFail($idAlergia);
        $alergia->update($request->only(['tipo', 'descripcion', 'severidad']));

        return redirect()->route('alergias.index')->with('success', 'Alergia actualizada exitosamente.');
    }
    public function edit($idPaciente, $idAlergia)
    {
        $paciente = Paciente::findOrFail($idPaciente);
        $alergia = Alergia::where('id_paciente', $idPaciente)->findOrFail($idAlergia);

        return view('admin.centro.historial.alergias.edit', compact('paciente', 'alergia'));
    }

    public function destroy($idPaciente, $idAlergia)
    {
        $alergia = Alergia::where('id_paciente', $idPaciente)->findOrFail($idAlergia);
        $alergia->delete();

        return response()->json(['success' => 'Alergia eliminada exitosamente.']);
    }
}
