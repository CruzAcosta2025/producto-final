<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Anamnesis extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'anamnesis';
    protected $primaryKey = 'id_anamnesis';
    public $timestamps = true;
    protected $dates = ['deleted_at']; 

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
