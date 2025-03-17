<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistorialClinico;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;

class HistorialClinicoController extends Controller
{
    // Listar todos los historiales clínicos de un centro médico y permitir la búsqueda de un paciente
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $paciente = null;

        if ($dni) {
            $paciente = Paciente::where('dni', $dni)
                ->where('id_centro', Auth::user()->id_centro)
                ->with(['historialClinico' => function ($query) {
                    $query->with('tratamientos'); // Agregar tratamientos solo si es necesario
                }])
                ->first();
        }

        $historiales = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->with(['paciente']) // Cargar solo la relación paciente en esta consulta
            ->get();

        return view('admin.centro.historial.index', compact('historiales', 'paciente', 'dni'));
    }

    // Crear historial clínico automáticamente sin necesidad de formulario
    //CORREGIDO
    public function store($idPaciente)
    {
        $paciente = Paciente::where('id_centro', Auth::user()->id_centro)->findOrFail($idPaciente);

        HistorialClinico::create([
            'id_paciente' => $paciente->id_paciente,
            'id_centro' => $paciente->id_centro,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('historial.index')->with('success', 'Historial clínico creado exitosamente.');
    }



    // Mostrar el formulario de edición de un historial clínico específico
    public function edit($idHistorial)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->with('paciente')
            ->findOrFail($idHistorial);

        return view('admin.centro.historial.edit', compact('historial'));
    }

    // Actualizar los datos de un historial clínico específico
    public function update(Request $request, $idHistorial)
    {
        $request->validate([
            'fecha_creacion' => 'required|date',
        ]);

        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)->findOrFail($idHistorial);
        $historial->update([
            'fecha_creacion' => $request->fecha_creacion,
        ]);

        return redirect()->route('historial.index')->with('success', 'Historial clínico actualizado exitosamente.');
    }

    // Mostrar el historial clínico completo de un paciente, incluyendo todas las secciones
    public function show($idHistorial)
    {
        $historial = HistorialClinico::where('id_centro', Auth::user()->id_centro)
            ->with([
                'paciente',
                'alergias',
                'vacunas',
                'consultas.archivos', // Relación archivos en consultas
                'cirugias',
                'diagnostico',
                'examenesMedicos.archivos', // Relación archivos en exámenes
                'recetas.medicamentos',
                'tratamientos', // Corrección: nombre plural
                'triaje',
                'anamnesis',
                'archivosAdjuntos'
            ])
            ->findOrFail($idHistorial);

        return view('admin.centro.historial.show', compact('historial'));
    }
}
