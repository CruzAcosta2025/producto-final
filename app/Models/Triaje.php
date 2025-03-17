<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triaje extends Model
{
    use HasFactory;

    protected $table = 'triaje';
    protected $primaryKey = 'id_triaje';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'presion_arterial',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'peso',
        'talla',
        'imc',
        'fecha_triaje'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function personalMedico()
    {
        return $this->belongsTo(PersonalMedico::class, 'id_personal_medico');
    }
}
