<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;

    protected $table = 'vacunas';
    protected $primaryKey = 'id_vacuna';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'nombre_vacuna',
        'fecha_aplicacion',
        'dosis',
        'proxima_dosis',
        'observaciones'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }
}
