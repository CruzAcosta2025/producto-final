<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudSangre extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_sangre';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'id_paciente',
        'tipo_sangre',
        'cantidad',
        'urgencia',
        'estado',
        'fecha_solicitud',
        'fecha_completada'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
