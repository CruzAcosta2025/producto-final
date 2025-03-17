<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $table = 'tratamiento';
    protected $primaryKey = 'id_tratamiento';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'descripcion',
        'fecha_creacion'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }
}
