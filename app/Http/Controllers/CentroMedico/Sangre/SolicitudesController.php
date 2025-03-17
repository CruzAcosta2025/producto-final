<?php

namespace App\Http\Controllers\CentroMedico\Sangre;

use App\Http\Controllers\Controller;
use App\Models\SolicitudSangre;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SolicitudesController extends Controller
{
    /**
     * Mostrar el listado de solicitudes de sangre.
     */
    public function index(Request $request)
    {
        Log::info('Iniciando SolicitudesController@index');

        $tipoSangre = $request->input('tipo_sangre');
        $nombrePaciente = $request->input('paciente_nombre');
        $dni = $request->input('dni');

        $solicitudes = SolicitudSangre::where('id_centro', Auth::user()->id_centro);

        if ($tipoSangre) {
            $solicitudes->where('tipo_sangre', $tipoSangre);
        }

        if ($nombrePaciente) {
            $solicitudes->whereHas('paciente', function ($query) use ($nombrePaciente) {
                $query->where('primer_nombre', 'LIKE', "%$nombrePaciente%")
                    ->orWhere('primer_apellido', 'LIKE', "%$nombrePaciente%");
            });
        }

        if ($dni) {
            $solicitudes->whereHas('paciente', function ($query) use ($dni) {
                $query->where('dni', $dni);
            });
        }

        $solicitudes = $solicitudes->paginate(10);

        return view('admin.centro.sangre.solicitudes.index', compact('solicitudes', 'tipoSangre', 'nombrePaciente', 'dni'));
    }

    /**
     * Mostrar el formulario para registrar una nueva solicitud.
     */
    public function create()
    {
        Log::info('Iniciando SolicitudesController@create');
        return view('admin.centro.sangre.solicitudes.create');
    }

    /**
     * Guardar una nueva solicitud en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('Datos recibidos en SolicitudesController@store', $request->all());

        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'cantidad' => 'required|integer|min:1|max:10',
            'urgencia' => 'required|in:BAJA,MEDIA,ALTA',
            'fecha_solicitud' => 'required|date',

        ]);

        $paciente = Paciente::findOrFail($request->id_paciente);

        SolicitudSangre::create([
            'id_centro' => Auth::user()->id_centro,
            'id_paciente' => $paciente->id_paciente,
            'tipo_sangre' => $paciente->grupo_sanguineo,
            'cantidad' => $request->cantidad,
            'urgencia' => $request->urgencia,
            'fecha_solicitud' => $request->fecha_solicitud,
            'estado' => 'PENDIENTE',
            'fecha_completada' => null, // Queda pendiente por defecto
        ]);

        Log::info('Solicitud de sangre creada exitosamente.');

        return redirect()->route('sangre.solicitudes.index')->with('success', 'Solicitud registrada correctamente.');
    }

    /**
     * Mostrar el formulario para editar una solicitud existente.
     */
    public function edit($id)
    {
        Log::info("Iniciando SolicitudesController@edit para el ID: $id");

        $solicitud = SolicitudSangre::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        return view('admin.centro.sangre.solicitudes.edit', compact('solicitud'));
    }

    /**
     * Actualizar los datos de una solicitud en la base de datos.
     */
    public function update(Request $request, $id)
    {
        Log::info("Datos recibidos en SolicitudesController@update para el ID: $id", $request->all());

        $request->validate([
            'cantidad' => 'required|integer|min:1|max:10',
            'urgencia' => 'required|in:BAJA,MEDIA,ALTA',
            'estado' => 'required|in:PENDIENTE,COMPLETADA,CANCELADA',
        ]);

        $solicitud = SolicitudSangre::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $updateData = [
            'cantidad' => $request->cantidad,
            'urgencia' => $request->urgencia,
            'estado' => $request->estado,
        ];

        if ($request->estado === 'COMPLETADA') {
            $updateData['fecha_completada'] = now();
        } elseif ($request->estado === 'CANCELADA') {
            $updateData['fecha_completada'] = null;
        }

        $solicitud->update($updateData);

        Log::info('Solicitud actualizada exitosamente.');

        return redirect()->route('sangre.solicitudes.index')->with('success', 'Solicitud actualizada correctamente.');
    }

    /**
     * Eliminar una solicitud.
     */
    public function destroy($id)
    {
        Log::info("Iniciando SolicitudesController@destroy para el ID: $id");

        $solicitud = SolicitudSangre::where('id_centro', Auth::user()->id_centro)
            ->findOrFail($id);

        $solicitud->delete();

        Log::info('Solicitud eliminada exitosamente.');

        return redirect()->route('sangre.solicitudes.index')->with('success', 'Solicitud eliminada correctamente.');
    }

    /**
     * Buscar paciente por DNI.
     */
    public function buscarPaciente(Request $request)
    {
        $dni = $request->input('dni');
        $paciente = Paciente::where('dni', $dni)
            ->where('id_centro', Auth::user()->id_centro)
            ->first();

        return response()->json($paciente);
    }
}
