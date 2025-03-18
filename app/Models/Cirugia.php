<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Cirugia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cirugias';
    protected $primaryKey = 'id_cirugia';
    public $timestamps = true;

    protected $dates = ['deleted_at']; 

    protected $fillable = [
        'id_historial',
        'tipo_cirugia',
        'fecha_cirugia',
        'cirujano',
        'descripcion',
        'complicaciones',
        'notas_postoperatorias'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }
}
