<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    use HasFactory;

    protected $table = 'historial_clinico';
    protected $primaryKey = 'id_historial';
    public $timestamps = true;

    protected $fillable = [
        'id_paciente',
        'id_centro',
        'fecha_creacion'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function alergias()
    {
        return $this->hasMany(Alergia::class, 'id_paciente', 'id_paciente');
    }

    public function vacunas()
    {
        return $this->hasMany(Vacuna::class, 'id_historial');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_historial');
    }

    public function cirugias()
    {
        return $this->hasMany(Cirugia::class, 'id_historial');
    }

    public function diagnostico()
    {
        return $this->hasMany(Diagnostico::class, 'id_historial');
    }

    public function examenesMedicos()
    {
        return $this->hasMany(ExamenMedico::class, 'id_historial');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'id_historial');
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class, 'id_historial');
    }



    public function triaje()
    {
        return $this->hasMany(Triaje::class, 'id_historial');
    }

    public function anamnesis()
    {
        return $this->hasMany(Anamnesis::class, 'id_historial');
    }

    public function archivosAdjuntos()
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_historial');
    }

    public function medicamentosReceta()
    {
        return $this->hasManyThrough(
            MedicamentoReceta::class,
            Receta::class,
            'id_historial', // Foreign key on the recetas table...
            'id_receta',    // Foreign key on the medicamentos_receta table...
            'id_historial', // Local key on the historial_clinico table...
            'id_receta'     // Local key on the recetas table...
        );
    }
}
