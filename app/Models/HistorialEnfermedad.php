<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialEnfermedad extends Model
{
    use HasFactory;

    protected $table = 'historial_enfermedad';
    public $timestamps = true;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'id_historial',
        'id_enfermedad',
        'fecha_diagnostico'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function enfermedad()
    {
        return $this->belongsTo(Enfermedad::class, 'id_enfermedad');
    }
}
