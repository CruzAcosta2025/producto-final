<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

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

    public function anamnesis()
    {
        return $this->hasManyThrough(
            Anamnesis::class,       // Modelo final
            HistorialClinico::class, // Modelo intermedio
            'id_paciente',         // Clave foránea en HistorialClinico
            'id_historial',        // Clave foránea en Anamnesis
            'id_paciente',         // Clave primaria en Paciente
            'id_historial'         // Clave primaria en HistorialClinico
        );
    }
    public function diagnosticos()
    {
        return $this->hasManyThrough(
            Diagnostico::class,     // Modelo final
            HistorialClinico::class, // Modelo intermedio
            'id_paciente',         // Clave foránea en HistorialClinico
            'id_historial',        // Clave foránea en Diagnostico
            'id_paciente',         // Clave primaria en Paciente
            'id_historial'         // Clave primaria en HistorialClinico
        );
    }

    public function recetas()
    {
        return $this->hasManyThrough(
            Receta::class,
            HistorialClinico::class,
            'id_paciente', // Foreign key en HistorialClinico
            'id_historial', // Foreign key en Receta
            'id_paciente', // Local key en Paciente
            'id_historial' // Local key en HistorialClinico
        );
    }

    public function examenesMedicos()
    {
        return $this->hasManyThrough(
            ExamenMedico::class,
            HistorialClinico::class,
            'id_paciente', // Foreign key en HistorialClinico
            'id_historial', // Foreign key en ExamenMedico
            'id_paciente', // Local key en Paciente
            'id_historial' // Local key en HistorialClinico
        );
    }

    public function consultas()
    {
        return $this->hasManyThrough(
            Receta::class,
            HistorialClinico::class,
            'id_paciente', // Foreign key en HistorialClinico
            'id_historial', // Foreign key en Receta
            'id_paciente', // Local key en Paciente
            'id_historial' // Local key en HistorialClinico
        );
    }

    public function cirugias()
    {
        return $this->hasManyThrough(
            Receta::class,
            HistorialClinico::class,
            'id_paciente', // Foreign key en HistorialClinico
            'id_historial', // Foreign key en Receta
            'id_paciente', // Local key en Paciente
            'id_historial' // Local key en HistorialClinico
        );
    }

    public function tratamientos()
    {
        return $this->hasManyThrough(
            Receta::class,
            HistorialClinico::class,
            'id_paciente', // Foreign key en HistorialClinico
            'id_historial', // Foreign key en Receta
            'id_paciente', // Local key en Paciente
            'id_historial' // Local key en HistorialClinico
        );
    }

    
}
