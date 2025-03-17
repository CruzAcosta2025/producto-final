<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HorarioMedico extends Model
{
    use HasFactory;

    protected $table = 'horarios_medicos';
    protected $primaryKey = 'id_horario';
    public $timestamps = true;

    protected $fillable = [
        'id_personal_medico',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    public function personalMedico()
    {
        return $this->belongsTo(PersonalMedico::class, 'id_personal_medico');
    }

    /**
     * Filtrar horarios disponibles según el día y la hora actual en formato 12 horas.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function especialistasDisponibles()
    {
        $diaActual = Carbon::now()->isoFormat('dddd'); // Día actual en español
        $horaActual = Carbon::now()->format('h:i A'); // Hora actual en formato 12 horas

        return self::where('dia_semana', $diaActual)
            ->whereRaw("STR_TO_DATE(hora_inicio, '%h:%i %p') <= STR_TO_DATE(?, '%h:%i %p')", [$horaActual])
            ->whereRaw("STR_TO_DATE(hora_fin, '%h:%i %p') >= STR_TO_DATE(?, '%h:%i %p')", [$horaActual])
            ->with('personalMedico.usuario');
    }
}

