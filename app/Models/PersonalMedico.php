<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalMedico extends Model
{
    use HasFactory;

    protected $table = 'personal_medico';
    protected $primaryKey = 'id_personal_medico';
    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'id_especialidad',
        'id_centro',
        'dni',
        'telefono',
        'correo_contacto',
        'sueldo',
        'codigo_postal',
        'fecha_alta',
        'fecha_baja',
        'banco',
        'numero_cuenta',
        'numero_colegiatura',
        'direccion'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }


    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro'); // Define la relación con centros_medicos
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_medico', 'id_personal_medico');
    }


    // Relación con los horarios médicos
    public function horariosMedicos()
    {
        return $this->hasMany(HorarioMedico::class, 'id_personal_medico', 'id_personal_medico');
    }



    // Método para verificar si el médico tiene horarios activos
    public function getHorariosActivosAttribute()
    {
        $currentDay = now()->locale('es')->dayName; // Obtiene el día actual
        $currentTime = now()->format('H:i'); // Hora actual en formato 24 horas

        return $this->horariosMedicos()->where('dia_semana', ucfirst($currentDay))
            ->where('hora_inicio', '<=', $currentTime)
            ->where('hora_fin', '>=', $currentTime)
            ->exists();
    }
}
