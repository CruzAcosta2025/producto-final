<?php

namespace App\Http\Controllers\CentroMedico\Horario;

use App\Http\Controllers\Controller;
use App\Models\HorarioMedico;
use App\Models\PersonalMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HorarioMedicoController extends Controller
{
    /**
     * Mostrar todos los horarios médicos.
     */
    public function index(Request $request)
    {
        $dni = $request->get('dni');
        $centroId = Auth::user()->id_centro;

        Log::info("Cargando horarios para el centro: $centroId");

        $horarios = HorarioMedico::whereHas('personalMedico', function ($query) use ($centroId, $dni) {
            $query->where('id_centro', $centroId);
            if ($dni) {
                $query->where('dni', $dni);
            }
        })->with('personalMedico.usuario')->get();

        Log::info("Horarios encontrados: " . $horarios->count());

        return view('admin.centro.horarios.index', compact('horarios', 'dni'));
    }

    /**
     * Mostrar formulario para crear un nuevo horario.
     */
    public function create()
    {
        $centroId = Auth::user()->id_centro;
        $personalMedico = PersonalMedico::where('id_centro', $centroId)
            ->whereNotNull('id_especialidad')
            ->with('usuario')
            ->get();

        Log::info("Personal médico disponible para horarios en el centro: $centroId");

        return view('admin.centro.horarios.create', compact('personalMedico'));
    }

    /**
     * Almacenar un nuevo horario en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info("Datos recibidos para creación de horario:", $request->all());

        $request->validate([
            'id_personal_medico' => 'required|exists:personal_medico,id_personal_medico',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio_hora' => 'required|integer|between:1,12',
            'hora_inicio_minuto' => 'required|integer|between:0,59',
            'hora_inicio_periodo' => 'required|in:AM,PM',
            'hora_fin_hora' => 'required|integer|between:1,12',
            'hora_fin_minuto' => 'required|integer|between:0,59',
            'hora_fin_periodo' => 'required|in:AM,PM',
        ]);

        // Convertir horas a formato de 24 horas
        $hora_inicio = $this->convertirAFormato24Horas(
            $request->hora_inicio_hora,
            $request->hora_inicio_minuto,
            $request->hora_inicio_periodo
        );

        $hora_fin = $this->convertirAFormato24Horas(
            $request->hora_fin_hora,
            $request->hora_fin_minuto,
            $request->hora_fin_periodo
        );

        Log::info("Horas procesadas para guardar: Inicio: $hora_inicio, Fin: $hora_fin");

        HorarioMedico::create([
            'id_personal_medico' => $request->id_personal_medico,
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
        ]);

        Log::info("Horario creado exitosamente.");

        return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar un horario existente.
     */
    public function edit($id)
    {
        $horario = HorarioMedico::findOrFail($id);
        $centroId = Auth::user()->id_centro;
        $personalMedico = PersonalMedico::where('id_centro', $centroId)
            ->whereNotNull('id_especialidad')
            ->with('usuario')
            ->get();

        Log::info("Cargando horario ID: $id para edición");

        return view('admin.centro.horarios.edit', compact('horario', 'personalMedico'));
    }

    /**
     * Actualizar un horario existente.
     */
    public function update(Request $request, $id)
    {
        Log::info("Intentando actualizar horario ID: $id. Datos recibidos:", $request->all());

        $horario = HorarioMedico::findOrFail($id);

        $request->validate([
            'dia_semana' => 'required|string|max:50',
            'hora_inicio_hora' => 'nullable|integer|between:1,12',
            'hora_inicio_minuto' => 'nullable|integer|between:0,59',
            'hora_inicio_periodo' => 'nullable|in:AM,PM',
            'hora_fin_hora' => 'nullable|integer|between:1,12',
            'hora_fin_minuto' => 'nullable|integer|between:0,59',
            'hora_fin_periodo' => 'nullable|in:AM,PM',
        ]);

        $data = ['dia_semana' => $request->dia_semana];

        // Convertir hora_inicio y hora_fin a formato de 24 horas si se envían los valores
        if ($request->filled(['hora_inicio_hora', 'hora_inicio_minuto', 'hora_inicio_periodo'])) {
            $data['hora_inicio'] = $this->convertirAFormato24Horas(
                $request->hora_inicio_hora,
                $request->hora_inicio_minuto,
                $request->hora_inicio_periodo
            );
            Log::info("Hora inicio convertida: " . $data['hora_inicio']);
        }

        if ($request->filled(['hora_fin_hora', 'hora_fin_minuto', 'hora_fin_periodo'])) {
            $data['hora_fin'] = $this->convertirAFormato24Horas(
                $request->hora_fin_hora,
                $request->hora_fin_minuto,
                $request->hora_fin_periodo
            );
            Log::info("Hora fin convertida: " . $data['hora_fin']);
        }

        $horario->update($data);

        Log::info("Horario ID: $id actualizado exitosamente.");

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
    }

    /**
     * Eliminar un horario existente.
     */
    public function destroy($id)
    {
        Log::info("Intentando eliminar horario ID: $id");

        $horario = HorarioMedico::findOrFail($id);
        $horario->delete();

        Log::info("Horario ID: $id eliminado exitosamente.");

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');
    }

    /**
     * Convertir hora de formato de 12 horas (AM/PM) a 24 horas.
     *
     * @param int $hora
     * @param int $minuto
     * @param string $periodo
     * @return string
     */
    private function convertirAFormato24Horas($hora, $minuto, $periodo)
    {
        if ($periodo === 'PM' && $hora != 12) {
            $hora += 12;
        }

        if ($periodo === 'AM' && $hora == 12) {
            $hora = 0;
        }

        return sprintf('%02d:%02d', $hora, $minuto);
    }
}
