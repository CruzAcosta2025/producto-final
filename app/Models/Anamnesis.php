<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnesis extends Model
{
    use HasFactory;

    protected $table = 'anamnesis';
    protected $primaryKey = 'id_anamnesis';
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
