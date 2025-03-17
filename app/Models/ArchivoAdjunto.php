<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoAdjunto extends Model
{
    use HasFactory;

    protected $table = 'archivos_adjuntos';
    protected $primaryKey = 'id_archivo';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'id_consulta',
        'id_examen',
        'tipo_archivo',
        'nombre_archivo',
        'ruta_archivo',
        'descripcion'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta');
    }

    public function examenMedico()
    {
        return $this->belongsTo(ExamenMedico::class, 'id_examen');
    }
}
