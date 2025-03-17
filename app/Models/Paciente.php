<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'genero',
        'dni',
        'direccion',
        'telefono',
        'email',
        'grupo_sanguineo',
        'nombre_contacto_emergencia',
        'telefono_contacto_emergencia',
        'relacion_contacto_emergencia',
        'es_donador'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function historialClinico()
    {
        return $this->hasMany(HistorialClinico::class, 'id_paciente');
    }
    public function alergias()
    {
        return $this->hasMany(Alergia::class, 'id_paciente');
    }
    public function vacunas()
    {
        return $this->hasManyThrough(
            Vacuna::class,
            HistorialClinico::class,
            'id_paciente', // Foreign key en HistorialClinico
            'id_historial', // Foreign key en Vacuna
            'id_paciente', // Local key en Paciente
            'id_historial' // Local key en HistorialClinico
        );
    }
    public function getNombreCompletoAttribute()
    {
        return "{$this->primer_nombre} {$this->primer_apellido}";
    }
}
