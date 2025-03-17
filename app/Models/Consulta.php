<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'id_medico',
        'fecha_consulta',
        'motivo_consulta',
        'sintomas',
        'observaciones'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function personalMedico()
    {
        return $this->belongsTo(PersonalMedico::class, 'id_medico');
    }

    public function archivos()
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_consulta', 'id_consulta');
    }
}
