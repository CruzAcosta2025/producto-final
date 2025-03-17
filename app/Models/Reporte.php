<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'tipo_reporte',
        'descripcion',
        'fecha_reporte',
        'contenido'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }
}
