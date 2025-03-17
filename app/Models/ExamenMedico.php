<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenMedico extends Model
{
    use HasFactory;

    protected $table = 'examenes_medicos';
    protected $primaryKey = 'id_examen';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'tipo_examen',
        'descripcion',
        'fecha_examen',
        'resultados'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function archivos()
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_examen', 'id_examen');
    }
}
