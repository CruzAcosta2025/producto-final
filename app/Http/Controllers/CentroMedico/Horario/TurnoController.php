<?php

namespace App\Http\Controllers\CentroMedico\Horario;

use App\Http\Controllers\Controller;
use App\Models\HorarioMedico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TurnoController extends Controller
{
    /**
     * Mostrar especialistas disponibles en el turno actual.
     */
    public function index()
    {
        $centroId = Auth::user()->id_centro;

        // Obtener el día actual y la hora actual en formato 24 horas
        $diaActual = ucfirst(Carbon::now()->locale('es')->isoFormat('dddd'));
        $horaActual = Carbon::now()->format('H:i');

        Log::info("Consultando turnos disponibles para el centro: $centroId. Día: $diaActual, Hora: $horaActual");

        // Filtrar los horarios de los especialistas del centro
        $horarios = HorarioMedico::whereHas('personalMedico', function ($query) use ($centroId) {
            $query->where('id_centro', $centroId);
        })
        ->where('dia_semana', $diaActual)
        ->where('hora_inicio', '<=', $horaActual)
        ->where('hora_fin', '>=', $horaActual)
        ->with('personalMedico.usuario', 'personalMedico.especialidad')
        ->get();

        Log::info("Especialistas disponibles encontrados: " . $horarios->count());

        return view('admin.centro.horarios.turnos.index', compact('horarios', 'diaActual', 'horaActual'));
    }
}
